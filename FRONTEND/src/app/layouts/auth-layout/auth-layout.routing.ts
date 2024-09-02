import { Routes } from '@angular/router';
import { LoginComponent } from '../../pages/login/login.component';
import { UserLoginComponent } from '../../pages/user-login/user-login.component';
import { AdminResetPasswordComponent } from 'src/app/pages/user-login/admin-reset-password/admin-reset-password.component';

export const AuthLayoutRoutes: Routes = [
  { path: 'login', component: UserLoginComponent },
  { path: 'user-login', component: LoginComponent },
  { path: 'app-admin-reset-password', component: AdminResetPasswordComponent },
];
