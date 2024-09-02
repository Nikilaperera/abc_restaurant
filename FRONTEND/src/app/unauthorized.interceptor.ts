import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor,
  HttpErrorResponse
} from '@angular/common/http';
import { Observable } from 'rxjs';
import { Router } from '@angular/router';
import { catchError } from 'rxjs/operators';
import { throwError } from 'rxjs';

@Injectable()
export class UnauthorizedInterceptor implements HttpInterceptor {

  constructor(private router: Router) { }

  intercept(req: HttpRequest<any>, next: HttpHandler) {
    return next.handle(req).pipe(
      catchError((error: HttpErrorResponse) => {
        // console.log(error.url?.split('/'));
        // if (error.status === 401) {
        //   this.router.navigate(['auth/login']).then(() => {
        //    // window.location.reload();
        //   });
        // }

        if (error.status === 401 && error.url?.split('/')[5]=== 'dashboard') {
          this.router.navigate(['auth/login']).then(() => {
           // window.location.reload();
          });
        }else if(error.status === 401 && error.url?.split('/')[5]==='student_profile'){
          this.router.navigate(['auth/user-login']).then(() => {
            // window.location.reload();
           });
        }
        return throwError(error);
      })
    );
  }
}
