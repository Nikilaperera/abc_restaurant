
import { Component, OnInit, Inject } from '@angular/core';
import { FormGroup, FormBuilder, Validators, FormControl, AbstractControl } from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { SystemusersApiService } from '../services/systemusers-api.service';
import { MatSnackBarHorizontalPosition, MatSnackBarVerticalPosition, MatSnackBar } from '@angular/material/snack-bar';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-systemusers-dialog',
  templateUrl: './systemusers-dialog.component.html',
  styleUrls: ['./systemusers-dialog.component.scss']
})
export class SystemusersDialogComponent implements OnInit {
  horizontalPosition: MatSnackBarHorizontalPosition = 'center';
  verticalPosition: MatSnackBarVerticalPosition = 'top';
  hide = true;
  hidec = true;
  systemUserForm!: FormGroup;
  actionBtn: string = "Save";
  groupsList: any[] = [];
  userGroupsList: any[] = [];
  groups = new FormControl('');

  constructor(
    private snackBar: MatSnackBar,
    private formBuilder: FormBuilder,
    private api: SystemusersApiService,
    @Inject(MAT_DIALOG_DATA) public editData: any,
    private dialogRef: MatDialogRef<SystemusersDialogComponent>,
  ) { }

  ngOnInit(): void {
    this.systemUserForm = this.formBuilder.group({

      username: [''],
      password: ['', Validators.required],
      password_confirm: ['', Validators.required],
      email: ['', Validators.required],
      activation_selector: [''],
      activation_code: [''],
      frogotten_password_selector: [''],
      frogotten_password_code: [''],
      frogotten_password_time: [''],
      remember_selector: [''],
      remember_code: [''],
      last_login: [''],
      active: [''],
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      company: ['',Validators.required],
      phone: ['', [Validators.required,this.validatePhoneNumberPrefix]],
      status: [''],
      groups: ['',Validators.required],
    });
    // console.log(this.editData);

    // const groups=this.editData.groups;
    // groups.forEach((element:any) => {
    //   this.userGroupsList.push(element.id)


    // });
    this.get_all_groups();
  }

  get_all_groups() {
    this.api.getAllGroups().subscribe(res => {
      this.groupsList = res
    })
  }


  registerUsers() {



    if (this.systemUserForm.valid) {
      var formData: any = new FormData();

      formData.append('first_name', this.systemUserForm.controls['first_name'].value);
      formData.append('last_name', this.systemUserForm.controls['last_name'].value);
      formData.append('email', this.systemUserForm.controls['email'].value);
      formData.append('company', this.systemUserForm.controls['company'].value);
      formData.append('username', this.systemUserForm.controls['username'].value);
      formData.append('phone', this.systemUserForm.controls['phone'].value);
      formData.append('status', this.systemUserForm.controls['status'].value);
      formData.append('password', this.systemUserForm.controls['password'].value);
      formData.append('password_confirm', this.systemUserForm.controls['password_confirm'].value);
      // formData.append('groups', JSON.stringify(this.systemUserForm.controls['groups'].value));
      formData.append('groups', this.systemUserForm.controls['groups'].value);


      for (var pair of formData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
      }

      console.log(this.systemUserForm.value);


      this.api.registerUsers(formData).subscribe({

        next: (res) => {
          Swal.fire('User Registered successfully..')
          this.dialogRef.close();

        },
        error: (res) => {
          Swal.fire('User Registered unsuccessful..');
        }
      })
    }
    else{
      Swal.fire('Please fill required fields !');
    }

  }

  validatePhoneNumberPrefix(control: AbstractControl): { [key: string]: any } | null {
    const phoneNumber = control.value;
    if (phoneNumber && !phoneNumber.startsWith('+94')) {
      return { invalidPrefix: true };
    }
    return null;
  }
  
}
