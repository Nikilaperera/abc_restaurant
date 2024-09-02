import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { LoginApiService } from '../../login/services/login-api.service';
import { Router } from '@angular/router';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-admin-reset-password',
  templateUrl: './admin-reset-password.component.html',
  styleUrls: ['./admin-reset-password.component.scss']
})
export class AdminResetPasswordComponent implements OnInit{

  loginForm!: FormGroup;
  token = '';
  isPasswordVisible = false;
  isPasswordVisible1 = false;
  isPasswordVisible2 = false;


  constructor(
    private formBuilder: FormBuilder,
    private api: LoginApiService,
    private router: Router
  ) {}

  ngOnInit(): void {
    this.loginForm = this.formBuilder.group({
      identity: [''],
      password: [''],
      passwordnew: [''],
      passwordnewcomfirm: [''],
    });
  }

  resetLogin() {
    // if (this.loginForm.valid) {
      var formData: any = new FormData();
      formData.append('identity', this.loginForm.controls['identity'].value);
      formData.append('password', this.loginForm.controls['password'].value);
      formData.append('passwordnew', this.loginForm.controls['passwordnew'].value);
      formData.append('passwordnewcomfirm', this.loginForm.controls['passwordnewcomfirm'].value);
  
      for (var pair of formData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
      }
  
      this.api.separate(formData).subscribe({
        next: (res: any) => {
          console.log(res);
          if (res != 'Student') {
            this.api.checkLogin(formData).subscribe({
              next: (res: any) => {
                // Swal.fire('yes!');
                console.log(this.loginForm.controls['passwordnew'].value);
                if(this.loginForm.controls['passwordnew'].value==this.loginForm.controls['passwordnewcomfirm'].value){
                  //  Swal.fire('yes!');
                  this.api.updatepassword(formData).subscribe({
                    next: (res: any) => {  
                      Swal.fire('Password reset request was success!');
                      this.router.navigateByUrl('auth/login');
                     },
                    error: (res) => {
                      console.log(res);
                     
                      Swal.fire('Invalid email address or password!');
                    },
                  });

                }else{
                  Swal.fire('New passwords does not match.Try again!');
                }
               
              },
              error: (res) => {
                console.log(res);
               
                Swal.fire('Invalid email address or password!');
              },
            });
          } 
        },
        error: (res) => {
          console.log(res);
          Swal.fire('Invalid email address or old password!');
        },
      });
    // } else {
     
    //   Swal.fire('Please fill both username & password');
    // }
  }

  togglePasswordVisibility() {
    this.isPasswordVisible = !this.isPasswordVisible;
  }

  togglePasswordVisibility1() {
    this.isPasswordVisible1 = !this.isPasswordVisible1;
  }

  togglePasswordVisibility2() {
    this.isPasswordVisible2 = !this.isPasswordVisible2;
  }

}
