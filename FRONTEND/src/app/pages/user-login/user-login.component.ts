import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { LoginApiService } from '../login/services/login-api.service';
import { Router } from '@angular/router';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-user-login',
  templateUrl: './user-login.component.html',
  styleUrls: ['./user-login.component.scss'],
})
export class UserLoginComponent implements OnInit {
  loginForm!: FormGroup;
  token = '';
  isPasswordVisible = false;

  constructor(
    private formBuilder: FormBuilder,
    private api: LoginApiService,
    private router: Router
  ) {}

  ngOnInit(): void {
    this.loginForm = this.formBuilder.group({
      identity: ['', Validators.required],
      password: ['', Validators.required],
    });
  }

  showWarning: boolean = false;
warningText: string = '';

checkLogin() {
  const email = this.loginForm.controls['identity'].value;
  const password = this.loginForm.controls['password'].value;

  if (!email || !password) {
    this.showWarning = true;
    this.warningText = 'Please fill both username & password!';
    return;
  }

  if (this.loginForm.valid) {
    var formData: any = new FormData();
    formData.append('identity', email);
    formData.append('password', password);

    this.api.separate(formData).subscribe({
      next: (res: any) => {
        if (res != '') {
          this.api.checkLogin(formData).subscribe({
            next: (res: any) => {
              console.log('res_grp', res.group);

              const timestamp = Date.now();
              console.log('res', res);
              localStorage.setItem('token', res.token);
              localStorage.setItem('timestamp', timestamp.toString());
              this.router.navigateByUrl('abc_restaurant/dashboard');
            },
            error: (res) => {
              console.log(res);
              this.showWarning = true;
              this.warningText = 'Invalid email address or password!';
              this.loginForm.reset();
            },
          });
        } else {
          this.showWarning = true;
          this.warningText = 'Invalid email address or password!';
          this.loginForm.reset();
        }
      },
      error: (res) => {
        console.log(res);
        this.showWarning = true;
        this.warningText = 'Error while login';
        this.loginForm.reset();
      },
    });
  }
}
  togglePasswordVisibility() {
    this.isPasswordVisible = !this.isPasswordVisible;
  }


}
