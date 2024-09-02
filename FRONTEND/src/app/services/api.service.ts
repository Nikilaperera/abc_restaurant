import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import {environment} from "../../enviroments/enviroment";

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  constructor(private http: HttpClient) {};



  url = environment.apiUrl+"index.php/AuthController/";

  userlogin(api: any) {
    return this.http.post(this.url + "login/", {
      email: api[0],
      password: api[1]
    }, {
      responseType: 'text'
    });
  }
}
