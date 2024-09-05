import { BodyComponent } from './body/body.component';
import { NgModule } from '@angular/core';
import { InitialsPipe } from './initials.pipe'; // import the pipe
import { ShortenPipe } from './shorten.pipe';
import { BrowserModule } from '@angular/platform-browser';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { LayoutModule } from '@angular/cdk/layout';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatButtonModule } from '@angular/material/button';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatIconModule } from '@angular/material/icon';
import { MatListModule } from '@angular/material/list';
import { DashboardComponent } from './pages/user-dashboard/dashboard/dashboard.component';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { DragDropModule } from '@angular/cdk/drag-drop';
import { MatGridListModule } from '@angular/material/grid-list';
import { MatCardModule } from '@angular/material/card';
import { MatMenuModule } from '@angular/material/menu';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { MatDialogModule } from '@angular/material/dialog';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatPaginatorModule } from '@angular/material/paginator';
import { MatSelectModule } from '@angular/material/select';
import { MatSortModule } from '@angular/material/sort';
import { MatTableModule } from '@angular/material/table';
import { MatInputModule } from '@angular/material/input';
import { MatStepperModule } from '@angular/material/stepper';
import { ClipboardModule } from '@angular/cdk/clipboard';

import { MatExpansionModule } from '@angular/material/expansion';
import { MatDividerModule } from '@angular/material/divider';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { AuthLayoutComponent } from './layouts/auth-layout/auth-layout.component';
import { UserLayoutComponent } from './layouts/user-layout/user-layout.component';
import { CommonModule } from '@angular/common';
import { UserLoginComponent } from './pages/user-login/user-login.component';
import { FlexLayoutModule } from '@angular/flex-layout';
import { MatTabsModule } from '@angular/material/tabs';

import { MatDatepickerModule } from '@angular/material/datepicker';
import { TitleComponent } from './pages/master/title-page/title/title/title.component';
import { TitleDialogComponent } from './pages/master/title-page/title-dialog/title-dialog/title-dialog.component';
import { SystemusersComponent } from './pages/administration-management/systemusers-page/systemusers/systemusers.component';
import { SystemusersDialogComponent } from './pages/administration-management/systemusers-page/systemusers-dialog/systemusers-dialog.component';
import { MatRadioModule } from '@angular/material/radio';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { MatNativeDateModule } from '@angular/material/core';
import { NgChartsModule } from 'ng2-charts';

import { AngularEditorModule } from '@kolkov/angular-editor';
import { SidenavComponent } from './sidenav/sidenav.component';
import { MatAutocompleteModule } from '@angular/material/autocomplete';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { FullCalendarModule } from '@fullcalendar/angular'; // for FullCalendar!
import { FlatpickrModule } from 'angularx-flatpickr';
import { CalendarModule, DateAdapter } from 'angular-calendar';
import { adapterFactory } from 'angular-calendar/date-adapters/date-fns';
import { SublevelMenuComponent } from './sidenav/sublevel-menu/sublevel-menu.component';
import { HeaderComponent } from './header/header.component';
import { OverlayModule } from '@angular/cdk/overlay';
import { CdkMenuModule } from '@angular/cdk/menu';
import { MatTooltipModule } from '@angular/material/tooltip';
import { ApiInterceptor } from './api.interceptor';
import { EditPermissionsDialogComponent } from './pages/administration-management/edit-permissions-dialog/edit-permissions-dialog.component';
import { SystemUserPermissionComponent } from './pages/administration-management/system-user-permission-settings/system-user-permission/system-user-permission.component';

import { UnauthorizedInterceptor } from './unauthorized.interceptor';
import { SpinnerComponent } from './spinner/spinner.component';
import { LoadingInterceptor } from './loading.interceptor';
import { MatSnackBarModule } from '@angular/material/snack-bar';
import { SystemLogTableComponent } from './pages/administration-management/system-log-table/system-log-table.component';
import { ViewTitleComponent } from './pages/master/title-page/title/view-title/view-title.component';

import { EditTitleComponent } from './pages/master/title-page/edit-title/edit-title.component';
import { UserGroupsComponent } from './pages/administration-management/user-groups-page/user-groups/user-groups.component';

import { AddUserGroupsComponent } from './pages/administration-management/user-groups-page/add-user-groups/add-user-groups.component';


import { CapitalizeFirstLetterDirective } from 'src/enviroments/capitalize-first-letter.directive';
import { CapitalizeAfterDirective } from 'src/enviroments/capitalize-after.directive';
import { CapitalizeAllDirective } from 'src/enviroments/capitalize-all.directive';
import { AdminResetPasswordComponent } from './pages/user-login/admin-reset-password/admin-reset-password.component';
import { ModuleGroupsComponent } from './pages/administration-management/module-groups-page/module-groups/module-groups.component';
import { MenuTypesComponent } from './pages/master/menu-types-page/menu-types/menu-types.component';
import { MenuTypesDialogComponent } from './pages/master/menu-types-page/menu-types-dialog/menu-types-dialog.component';
import { EditMenuTypesComponent } from './pages/master/menu-types-page/edit-menu-types/edit-menu-types.component';
import { ReservationTypeComponent } from './pages/master/reservation-type-page/reservation-type/reservation-type.component';
import { ReservationTypeDialogComponent } from './pages/master/reservation-type-page/reservation-type-dialog/reservation-type-dialog.component';



@NgModule({
  declarations: [
    InitialsPipe,
    ShortenPipe,
    AppComponent,
    SublevelMenuComponent,
    BodyComponent,
    DashboardComponent,
    AuthLayoutComponent,
    UserLayoutComponent,
    UserLoginComponent,
    TitleComponent,
    TitleDialogComponent,
    SystemusersComponent,
    SystemusersDialogComponent,
    SidenavComponent,
    HeaderComponent,
    EditPermissionsDialogComponent,
    SystemUserPermissionComponent,
    SpinnerComponent,
    SystemLogTableComponent,
    ViewTitleComponent,
    EditTitleComponent,
    UserGroupsComponent,
    AddUserGroupsComponent,
    CapitalizeFirstLetterDirective,
    CapitalizeAfterDirective,
    CapitalizeAllDirective,
    AdminResetPasswordComponent,
    ModuleGroupsComponent,
    MenuTypesComponent,
    MenuTypesDialogComponent,
    EditMenuTypesComponent,
    ReservationTypeComponent,
    ReservationTypeDialogComponent,

  ],

  imports: [
    ClipboardModule,
    MatSnackBarModule,
    MatProgressSpinnerModule,
    MatAutocompleteModule,
    AngularEditorModule,
    CommonModule,
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    LayoutModule,
    MatToolbarModule,
    MatButtonModule,
    MatSidenavModule,
    MatListModule,
    MatSnackBarModule,
    MatGridListModule,
    MatCardModule,
    MatMenuModule,
    MatToolbarModule,
    MatIconModule,
    MatButtonModule,
    MatDialogModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelectModule,
    ReactiveFormsModule,
    HttpClientModule,
    MatTableModule,
    MatPaginatorModule,
    MatSortModule,
    MatExpansionModule,
    MatDividerModule,
    FontAwesomeModule,
    FormsModule,
    ReactiveFormsModule,
    FlexLayoutModule,
    MatTabsModule,
    MatDatepickerModule,
    MatRadioModule,
    MatCheckboxModule,
    MatNativeDateModule,
    FullCalendarModule,
    DragDropModule,
    MatStepperModule,
    NgbModule,
    OverlayModule,
    CdkMenuModule,
    NgChartsModule,
    FlatpickrModule.forRoot(),
    CalendarModule.forRoot({
      provide: DateAdapter,
      useFactory: adapterFactory,
    }),
    MatTooltipModule,
  ],
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: ApiInterceptor,
      multi: true,
    },
    {
      provide: HTTP_INTERCEPTORS,
      useClass: UnauthorizedInterceptor,
      multi: true,
    },
    // {
    //   provide: HTTP_INTERCEPTORS,
    //   useClass: LoadingInterceptor,
    //   multi: true
    // }

  ],
  bootstrap: [AppComponent],
})
export class AppModule {}
