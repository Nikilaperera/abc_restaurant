import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, RouterStateSnapshot, UrlTree, RouterLink, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { AuthService } from './auth.service';
import { map, switchMap } from 'rxjs/operators';
@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {
  userGroups: any = [];
  constructor(private authService: AuthService, private router: Router) {

  }

  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {

    return this.authService.isAuthenticated().pipe(
      switchMap((data) => {
        this.authService.setData(data); // Store the data in the AuthService for later use

        return this.authService.getLoggedUserGroups().pipe(
          map((groups: any) => {
            const gLength = groups.length;
         //   const isAdmin = groups.find((group:any) => group.name === 'Admin');
            const isStudent = groups.find((group:any) => group.name === 'Student');
           if(gLength===1){
            if(isStudent){
              return this.router.createUrlTree(['abc_restaurant/student-dashboard']);

            }else{
              return true;
            }
           }else if(gLength>1){
            return true;
           }else {
              return this.router.createUrlTree(['auth/login']);
            }
          })
        );
      })
    );
  }

}
