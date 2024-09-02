import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/enviroments/enviroment';

@Injectable({
  providedIn: 'root',
})
export class ModuleGroupsService {
  constructor(private http: HttpClient) {}

  url = environment.apiUrl;

  getModulePermission(moduleId: number) {
    return this.http.get<any>(this.url + 'navbar/NavbarDataController/permissions/' + moduleId);
  }

  getPermissions() {
    return this.http.get<any>(this.url + 'systemUsers/ModuleGroupsController/');
  }

  getGroups() {
    return this.http.get<any>(this.url + 'systemUsers/ModuleGroupsController/getGroups');
  }

  getUsers() {
    return this.http.get<any>(this.url + 'systemUsers/ModuleGroupsController/getUsers');
  }

  getSections() {
    return this.http.get<any>(this.url + 'systemUsers/ModuleGroupsController/getSections');
  }

  getModules() {
    return this.http.get<any>(this.url + 'systemUsers/ModuleGroupsController/getModules');
  }

  updatePermissions(data: any) {
    return this.http.post(this.url + 'systemUsers/ModuleGroupsController/updatePermissions', data);
  }
}
