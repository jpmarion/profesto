import { Injectable } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { Observable, of } from 'rxjs';

export type HandleError = <T> (operation?: string, result?: T) =>
  (error: HttpErrorResponse) =>
    Observable<T>;

@Injectable({
  providedIn: 'root'
})
export class HhtpHandleErrorService {

  constructor() { }

  createHandleError = (serviceName = '') => <T>
    (operation = 'operation', result = {} as T) =>
    this.handleError(serviceName, operation, result)
  handleError<T>(serviceName = '', operation = 'operation', result = {} as T) {
    return (response: HttpErrorResponse):
      Observable<T> => {
      console.error(response);
      const message = (response.error instanceof ErrorEvent) ?
        response.error.message :
        `Código devuelto por el servidor ${response.status} con body "${response.error.error}"`;
      alert(message);
      return of(result);
    };
  }
}
