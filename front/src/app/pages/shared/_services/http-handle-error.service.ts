import { Injectable } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { Observable, of } from 'rxjs';

export type HandleError = <T>(operation?: string, result?: T) => (error: HttpErrorResponse) => Observable<T>;

@Injectable({
  providedIn: 'root'
})
export class HttpHandleErrorService {

  constructor() { }

  createHandleError = (serviceName = '') => <T>
    (operation = 'operation', result = {} as T) =>
    this.handleError(serviceName, operation, result)
  handleError<T>(serviceName = '', operation = 'operation', result = {} as T) {
    return (response: HttpErrorResponse): Observable<T> => {
      console.log(response);
      const message = (response.error instanceof ErrorEvent ?
        response.error.message :
        `server returned code ${response.status} whit body ${response.error.error}`
      );
      alert(message);
      return of(result);
    }
  }
}
