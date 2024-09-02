import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/enviroments/enviroment';

@Injectable({
  providedIn: 'root',
})
export class UserGroupsApiService {
  constructor(private http: HttpClient) {}

  url = environment.apiUrl;
  getUserGroups() {
    return this.http.get<any>(this.url + 'master/UserGroupsController/');
  }

  postUserGroup(api: UserGroupsApiService) {
    return this.http.post(this.url + 'master/UserGroupsController/add/', api);
  }

  updateUserGroup(api: UserGroupsApiService, id: number) {
    return this.http.post(
      this.url + 'master/UserGroupsController/update/' + id,
      api
    );
  }
}
