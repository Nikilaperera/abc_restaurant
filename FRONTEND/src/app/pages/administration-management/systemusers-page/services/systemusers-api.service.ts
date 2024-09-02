import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/enviroments/enviroment';
@Injectable({
  providedIn: 'root'
})
export class SystemusersApiService {

  constructor(private http: HttpClient) {

  };


  url = environment.apiUrl;

  registerUsers(api: SystemusersApiService) {
    console.log(api);
    return this.http.post(this.url + "auth/Auth/create_user", api);
  }
  getAllUsers() {
    return this.http.get<any>(this.url + "auth/Auth");
  }
  editUsers(api:any,id:number){
    return this.http.post(this.url + "auth/Auth/edit_user/" + id, api);
  }
  getAllGroups(){
    return this.http.get<any>(this.url + "systemUsers/SystemUserPermissions/get_all_groups");
  }
  getAllPermissionUsers(){
    return this.http.get<any>(this.url + "systemUsers/SystemUserPermissions/get_all_users");
  }
  getAllSections(){
    return this.http.get<any>(this.url+ "systemUsers/SystemUserPermissions/get_all_sections");
  }
  getAllModules(){
    return this.http.get<any>(this.url + "systemUsers/SystemUserPermissions/get_all_modules");
  }
  getAllpermissions(){
    return this.http.get<any>(this.url + "systemUsers/SystemUserPermissions/");
  }
  add_permission_list(api:any){
    return this.http.post(this.url + "systemUsers/SystemUserPermissions/addPermissions/", api);

  }

  getModulePermission( moduleId: number) {
    return this.http.get<any>(
      this.url + 'navbar/NavbarDataController/permissions/' + moduleId
    )
  }
}
