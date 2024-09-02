import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import {environment} from "../enviroments/enviroment";

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private data: any;
  constructor(private http: HttpClient) { }
  url = environment.apiUrl+"auth/";


  isAuthenticated():  Observable<any>  {
      return this.http.get<any>(this.url + "Auth/isAuthenticate") ;
  }
  logout() {
    // Send a POST request to the CodeIgniter 3 API to logout the user
    return this.http.post(this.url + "Auth/logout", {});
  }

  getLoggedUserGroups(){

    return this.http.get(this.url + "Auth/get_user_groups");
  }
  setData(data: any) {
    this.data = data;
  }

  getDataValue() {
    return this.data.value;
  }
}
