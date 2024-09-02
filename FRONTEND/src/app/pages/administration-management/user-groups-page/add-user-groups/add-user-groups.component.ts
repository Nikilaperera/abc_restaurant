import { Component, OnInit, Inject } from '@angular/core';
import { FormGroup, FormBuilder, Validators, FormControl } from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { UserGroupsApiService } from '../services/user-groups-api.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-add-user-groups',
  templateUrl: './add-user-groups.component.html',
  styleUrls: ['./add-user-groups.component.scss']
})
export class AddUserGroupsComponent {

  userGroupForm!: FormGroup;
  actionBtn: string = "Save";

  constructor(
    private formBuilder: FormBuilder,
    private api: UserGroupsApiService,
    @Inject(MAT_DIALOG_DATA) public editData: any,
    private dialogRef: MatDialogRef<AddUserGroupsComponent>,
  ) { }

  ngOnInit(): void {

    this.userGroupForm = this.formBuilder.group({
      name: ['', Validators.required],
      description: ['', Validators.required],

    });
    console.log(this.editData);
    if (this.editData) {
      this.actionBtn = "Update";
      this.userGroupForm.controls['name'].setValue(this.editData.name);
      this.userGroupForm.controls['description'].setValue(this.editData.description);
    }
  }

  updateUserGroup() {
    var formData: any = new FormData();
    formData.append('name', this.userGroupForm.controls['name'].value);
    formData.append('description', this.userGroupForm.controls['description'].value);

    this.api.updateUserGroup(formData, this.editData.id).subscribe({
      next: (res) => {

        Swal.fire("User Group updated successfully..");
        this.userGroupForm.reset();
        this.dialogRef.close('update');
        for (var pair of formData.entries()) {
          console.log(pair[0] + ', ' + pair[1]);
        }


      },
      error: (res) => {
        Swal.fire("Error while updating the User Group");

      }
    })
  }

  addUserGroup() {
    if (!this.editData) {
      if (this.userGroupForm.valid) {
        var formData: any = new FormData();
        const name = this.userGroupForm.controls['name'].value;
        const description = this.userGroupForm.controls['description'].value;

        formData.append('name', name);
        formData.append('description', description);

        this.api.postUserGroup(formData).subscribe({
          next: (res) => {
            console.log(res);
            Swal.fire("User Group added successfully..");
            this.userGroupForm.reset();
            this.dialogRef.close('save');
          },
          error: (res) => {
            Swal.fire("Error while adding the User Group");
          }
        })
      }
    } else {
      this.updateUserGroup();
    }
  }

}
