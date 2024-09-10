import { Routes } from '@angular/router';
import { UserLoginComponent } from '../../pages/user-login/user-login.component';
import { AdminResetPasswordComponent } from 'src/app/pages/user-login/admin-reset-password/admin-reset-password.component';

export const AuthLayoutRoutes: Routes = [
  { path: 'login', component: UserLoginComponent },
  { path: 'app-admin-reset-password', component: AdminResetPasswordComponent },
];
