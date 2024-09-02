import { Routes } from '@angular/router';

import { DashboardComponent } from '../../pages/user-dashboard/dashboard/dashboard.component';
import { TitleComponent } from '../../pages/master/title-page/title/title/title.component';
import { SystemusersComponent } from 'src/app/pages/administration-management/systemusers-page/systemusers/systemusers.component';


import { SystemUserPermissionComponent } from '../../pages/administration-management/system-user-permission-settings/system-user-permission/system-user-permission.component';
import { SystemLogTableComponent } from '../../pages/administration-management/system-log-table/system-log-table.component';

import { UserGroupsComponent } from 'src/app/pages/administration-management/user-groups-page/user-groups/user-groups.component';

import { ModuleGroupsComponent } from 'src/app/pages/administration-management/module-groups-page/module-groups/module-groups.component';

export const UserLayoutRoutes: Routes = [
  { path: 'dashboard', component: DashboardComponent },

  { path: 'title', component: TitleComponent },



  { path: 'user-groups', component: UserGroupsComponent },
  { path: 'module-groups', component: ModuleGroupsComponent },
  { path: 'SystemUsers', component: SystemusersComponent },
  { path: 'system-user-permissions', component: SystemUserPermissionComponent },
  { path: 'system-log', component: SystemLogTableComponent },


  //  { path: 'class-allocation',component: ClassAllocationComponent },


];
