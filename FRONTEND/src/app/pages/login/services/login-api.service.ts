import {Injectable, OnInit} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Router} from '@angular/router';
import {FormBuilder, FormGroup} from '@angular/forms';
import {environment} from "../../../../enviroments/enviroment";


@Injectable({
  providedIn: 'root'
})
export class LoginApiService implements OnInit {

  loginForm!: FormGroup;
  url = environment.apiUrl + "auth/";

  constructor(
    private http: HttpClient,
    private formBuilder: FormBuilder,
    private router: Router) {
  }

  ngOnInit(): void {
    this.loginForm = this.formBuilder.group({
      email: [''],
      password: [''],
    });
  }

  checkLogin(api: any) {
    console.log(api);
    return this.http.post(this.url + "Auth/login", api);
  }

  //separate  login
  separate(api: any) {
    console.log(api);
    return this.http.post(this.url + "UserRegistrationController/usergroup", api);
  }

  //reset password resetpassword
  updatepassword(data: any) {
    return this.http.post(
      this.url + 'UserRegistrationController/updatepassword/',
      data
    );
  }


}

