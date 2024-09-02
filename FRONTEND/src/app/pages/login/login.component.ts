import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {LoginApiService} from './services/login-api.service';
import {Router} from '@angular/router';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
  loginForm!: FormGroup;
  token = '';
  isPasswordVisible = false;
  showWarning: boolean = false;
  warningText: string = '';

  constructor(
    private formBuilder: FormBuilder,
    private api: LoginApiService,
    private router: Router
  ) {
  }

  ngOnInit(): void {
    this.loginForm = this.formBuilder.group({
      identity: ['', Validators.required],
      password: ['', Validators.required],
    });

    Swal.fire({
      html: `<img src="assets/uploads/Web_banner_for_open_exam_application_31.01.2024-01-01.jpg" alt="Image" style="width: 100%; height: auto; border:none;  padding: 0; margin: 0;">`,
      showCloseButton: true,
      showConfirmButton: false,
    });
  }

  checkLogin() {
    if (this.loginForm.valid) {
      var formData: any = new FormData();
      formData.append('identity', this.loginForm.controls['identity'].value);
      formData.append('password', this.loginForm.controls['password'].value);

      for (var pair of formData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
      }

      this.api.separate(formData).subscribe({
        next: (res: any) => {
          console.log(res);
          if (res == 'Student') {
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
                this.router.navigateByUrl('auth/user-login');
              },
            });
          } else {

            this.showWarning = true;
            this.warningText = 'Invalid email address or password!';
            this.loginForm.reset();
            this.router.navigateByUrl('auth/user-login');
          }
        },
        error: (res) => {
          console.log(res);

          this.showWarning = true;
          this.warningText = 'Error while login!';
          this.loginForm.reset();
        },
      });
    } else {


      this.showWarning = true;
      this.warningText = 'Please fill both username & password!';
      this.loginForm.reset();
    }
  }

  togglePasswordVisibility() {
    this.isPasswordVisible = !this.isPasswordVisible;
  }


}
