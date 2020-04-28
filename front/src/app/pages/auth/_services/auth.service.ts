import { Injectable } from '@angular/core';
import { HttpClient, HttpParams, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
import { Observable, throwError } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';

import { environment } from './../../../../environments/environment';
import { User } from './../user';
import { RequestLogin } from './../request-login';

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type': 'application/json',
    'X-Requested-With': 'XMLHttpRequest'
  })
};

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  public currentUser: User;
  private readonly apiUrl = environment.apiURL;
  private loginUrl = this.apiUrl + '/api/auth/login';

  constructor(
    private http: HttpClient,
    private router: Router) { }

  onLogin(requestLogin: RequestLogin): Observable<User> {
    const request = JSON.stringify(
      {
        email: requestLogin.email,
        password: requestLogin.password,
        remember_me: requestLogin.remember_me
      });

    // console.warn(request);

    return this.http.post(this.loginUrl, request, httpOptions)
      .pipe(
        map((response: User) => {
          const token: string = response['access_token'];
          if (token) {
            this.setToken(token);
            this.getUser().subscribe();
          }
          return response;
        }),
        catchError(error => this.handleError(error))
      );

  }

  setToken(token: string): void {
    return localStorage.setItem('token', token);
  }

  getToken() {
    return localStorage.getItem('token');
  }

  getUser(): Observable<User> {
    return this.http.get(this.apiUrl + '/api/auth/user')
      .pipe(
        tap(
          (user: User) => {
            this.currentUser = user;
          }
        )
      )
  }

  isAuthenticated(): boolean {
    const token: string = this.getToken();
    if (token) {
      return true;
    }
    return false
  }

  private handleError(error: HttpErrorResponse) {
    if (error.error instanceof ErrorEvent) {
      console.error('Un error a ocurrido', error.error.message);
    } else {
      return throwError(error);
    }
    return throwError('Ooops algo a pasado aqui, por favor pruebe más tartde');
  }
}
