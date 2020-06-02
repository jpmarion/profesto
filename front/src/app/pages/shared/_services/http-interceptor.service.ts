import { Injectable, Injector } from '@angular/core';
import {
  HttpEvent, HttpHeaders, HttpInterceptor, HttpHandler, HttpRequest,
  HttpErrorResponse, HttpResponse
} from '@angular/common/http';
import { Observable } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';
import { Router } from '@angular/router';

import { AuthService } from '../../auth/_services/auth.service';

@Injectable({
  providedIn: 'root'
})
export class HttpInterceptorService {

  constructor(
    public auth: AuthService,
    private router: Router
  ) { }

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    console.log('interceptor running');
    const authToken = this.auth.getToken();
    if (authToken) {
      const authReq = req.clone(
        { headers: req.headers.set('Authorization', `Bearer ${authToken}`) }
      );
      console.log('interceptor running with new headers');
      return next.handle(authReq).pipe(
        tap((event: HttpEvent<any>) => {
          if (event instanceof HttpResponse) {
            console.log('TAP function', event);
          } (err: any) => {
            console.log(err);
            if (err instanceof HttpErrorResponse) {
              if (err.status === 401) {
                localStorage.removeItem('token');
                this.router.navigate(['/']);
              } else {
                console.log('intercepor without changes');
                return next.handle(req);
              }
            }
          }
        }
        )
      )
    }
  }
}
