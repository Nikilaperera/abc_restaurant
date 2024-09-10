import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AuthLayoutComponent } from './layouts/auth-layout/auth-layout.component';
import { UserLayoutComponent } from './layouts/user-layout/user-layout.component';
import { CommonModule } from '@angular/common';
import { SidenavComponent } from './sidenav/sidenav.component';
import { AuthGuard } from './auth.guard';


import { UserLoginComponent } from './pages/user-login/user-login.component';



const routes: Routes = [
  { path: 'side-nav', component: SidenavComponent },

  {
    path: 'auth',
    component: AuthLayoutComponent,
    children: [
      {
        path: '',
        loadChildren: () => import('./layouts/auth-layout/auth-layout.module').then(m => m.AuthLayoutModule,)
      }
    ]
  },
  {
    path: 'abc_restaurant',
    component: UserLayoutComponent,
    canActivate: [AuthGuard],
   // data: { allowedGroups: ['admin', 'manager'] },

    children: [
      {
        path: '',
        loadChildren: () => import('./layouts/user-layout/user-layout.module').then(m => m.UserLayoutModule)
      }
    ]
  },
  {
    path: '',
    redirectTo: 'auth/login',
    pathMatch: 'full'
  },
  {
    path: 'auth/login',
    component: UserLoginComponent
  },
  // {
  //   path: '**',
  //   redirectTo: 'abc_restaurant/login',
  //   pathMatch: 'full'
  // }
];

@NgModule({
  imports: [
    CommonModule,

    RouterModule.forRoot(routes, {
      useHash: false
    })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
