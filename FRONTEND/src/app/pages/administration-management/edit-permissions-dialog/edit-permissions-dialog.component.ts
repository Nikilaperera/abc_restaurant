import { Component, OnInit, Inject, ChangeDetectorRef } from '@angular/core';
import { FormGroup, FormBuilder, Validators, FormControl, AbstractControl } from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { SystemusersApiService } from '../systemusers-page/services/systemusers-api.service';
import { MatSnackBarHorizontalPosition, MatSnackBarVerticalPosition, MatSnackBar } from '@angular/material/snack-bar';
import Swal from 'sweetalert2';
import { id } from 'date-fns/locale';

@Component({
  selector: 'app-edit-permissions-dialog',
  templateUrl: './edit-permissions-dialog.component.html',
  styleUrls: ['./edit-permissions-dialog.component.scss'],
})
export class EditPermissionsDialogComponent implements OnInit {
  actionBtn: string = 'Save';
  actiontitle: string = 'Add';
  horizontalPosition: MatSnackBarHorizontalPosition = 'center';
  verticalPosition: MatSnackBarVerticalPosition = 'top';
  hide = true;
  // hide = true;
  hidec = true;
  hidecc = true;

  systemUserForm!: FormGroup;
  groupsList: any[] = [];
  userGroupsList: any[] = [];
  groups = new FormControl('');

  constructor(
    private snackBar: MatSnackBar,
    private cdr: ChangeDetectorRef,
    private formBuilder: FormBuilder,
    private api: SystemusersApiService,
    @Inject(MAT_DIALOG_DATA) public editData: any,
    private dialogRef: MatDialogRef<EditPermissionsDialogComponent>
  ) {}

  ngOnInit(): void {
    this.systemUserForm = this.formBuilder.group({
      username: ['', Validators.required],
      email: ['', [Validators.required, this.emailFormatValidator]],
      first_name: ['', Validators.required],
      last_name: ['', Validators.required],
      groups: ['', Validators.required],
      phone: ['', Validators.required],
      company: ['', Validators.required],
      password: [''],
      password_confirm: [''],
      status: [''],
      passwordnow: [''],
    });
    const groups = this.editData.groups;
    groups.forEach((element: any) => {
      this.userGroupsList.push(element.id);
    });

    console.log(this.editData);
    console.log(this.editData.active);

    console.log(this.editData.groups[0].name);

    if (this.editData) {
      this.actionBtn = 'Update';
      this.actiontitle = 'Edit';
      this.systemUserForm.controls['first_name'].setValue(this.editData.first_name);
      this.systemUserForm.controls['last_name'].setValue(this.editData.last_name);
      this.systemUserForm.controls['email'].setValue(this.editData.email);
      this.systemUserForm.controls['groups'].setValue(this.editData.groups[0].id);
      
    
      this.systemUserForm.controls['username'].setValue(this.editData.username);
      this.systemUserForm.controls['phone'].setValue(this.editData.phone);
      this.systemUserForm.controls['company'].setValue(this.editData.company);
      // this.systemUserForm.controls['status'].setValue(this.editData.active);
      if(this.editData.active=='Active'){
        this.systemUserForm.controls['status'].setValue('1');
      }else{
        this.systemUserForm.controls['status'].setValue('0');

      }
      this.systemUserForm.controls['passwordnow'].setValue(this.editData.password);

    }

    this.get_all_groups();
  }

  get_all_groups() {
    this.api.getAllGroups().subscribe((res) => {
      this.groupsList = res;
    });
  }

  updateUsers() {
    var formData: any = new FormData();
    formData.append('first_name', this.systemUserForm.controls['first_name'].value);
    formData.append('phone', this.systemUserForm.controls['phone'].value);
    formData.append('last_name', this.systemUserForm.controls['last_name'].value);
    formData.append('email', this.systemUserForm.controls['email'].value);
    // formData.append('groups', JSON.stringify(this.systemUserForm.controls['groups'].value));
    formData.append('groups', this.systemUserForm.controls['groups'].value);

    formData.append('username', this.systemUserForm.controls['username'].value);
    formData.append('company', this.systemUserForm.controls['company'].value);
    formData.append('password', this.systemUserForm.controls['password'].value);
    formData.append('password_confirm', this.systemUserForm.controls['password_confirm'].value);
    formData.append('status', this.systemUserForm.controls['status'].value);
    console.log('val', this.systemUserForm.value);

    if (this.systemUserForm.valid) {
      this.api.editUsers(formData, this.editData.id).subscribe({
        next: (res) => {
          Swal.fire('User updated successfully..');
          this.systemUserForm.reset();
          this.dialogRef.close();
        },
        error: (res) => {
          Swal.fire('User already exists !');
        },
      });
    } else {
      Swal.fire('Please fill required fields !');
    }
  }

  emailFormatValidator(control: AbstractControl): { [key: string]: boolean } | null {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailPattern.test(control.value)) {
      return { invalidEmailFormat: true };
    }
    return null;
  }
}
