import { Component, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatSnackBar, MatSnackBarHorizontalPosition, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import Swal from 'sweetalert2';
import { ChefMasterService } from '../services/chef-master.service';

@Component({
  selector: 'app-chef-dialog',
  templateUrl: './chef-dialog.component.html',
  styleUrls: ['./chef-dialog.component.scss'],
})
export class ChefDialogComponent {
  chefForm!: FormGroup;
  formTitle: string = 'Add';
  actionBtn: string = 'Save';

  horizontalPosition: MatSnackBarHorizontalPosition = 'center';
  verticalPosition: MatSnackBarVerticalPosition = 'top';

  constructor(
    private formBuilder: FormBuilder,
    private snackBar: MatSnackBar,
    private api: ChefMasterService,
    @Inject(MAT_DIALOG_DATA) public editData: any,
    private dialogRef: MatDialogRef<ChefDialogComponent>
  ) {}

  ngOnInit(): void {
    this.chefForm = this.formBuilder.group({

      Name: ['', Validators.required],
      Email: ['', [Validators.required, Validators.email]],
      Status: ['', Validators.required],

    });
    console.log(this.editData);
    if (this.editData) {
      this.formTitle = 'Edit';
      this.actionBtn = 'Update';
      this.chefForm.controls['Name'].setValue(this.editData.Name);
      this.chefForm.controls['Email'].setValue(this.editData.Email);
      this.chefForm.controls['Status'].setValue(this.editData.Status);
    }
  }

  addChef() {
    if (!this.editData) {
      if (this.chefForm.valid) {
        var formData: any = new FormData();
        formData.append('Name', this.chefForm.controls['Name'].value);
        formData.append('Email', this.chefForm.controls['Email'].value);
        formData.append('Status', this.chefForm.controls['Status'].value);

        for (var pair of formData.entries()) {
          console.log(pair[0] + ', ' + pair[1]);
        }

        this.api.postChef(formData).subscribe({
          next: (res) => {
            Swal.fire('Chef Details added successfully.');
            this.chefForm.reset();
            this.dialogRef.close('save');
          },
          error: (res) => {
            Swal.fire("Chef Details already exist...");
          }
        });
      } else {
        Swal.fire('Please fill required fields.');
      }
    } else {
      this.updateChef();
    }
  }

  updateChef() {
    if (this.chefForm.valid) {
      var formData: any = new FormData();
      formData.set('Name', this.chefForm.controls['Name'].value);
      formData.set('Email', this.chefForm.controls['Email'].value);
      formData.set('Status', this.chefForm.controls['Status'].value);

      this.api.updateChef(formData, this.editData.ID).subscribe({
        next: (res) => {
          Swal.fire('Chef Details updated successfully.');
          this.chefForm.reset();
          this.dialogRef.close('update');
          for (var pair of formData.entries()) {
            console.log(pair[0] + ', ' + pair[1]);
          }
        },
        error: (res) => {
          Swal.fire('Chef Details already exist.');
        },
      });
    } else {
      Swal.fire('Please fill required fields.');
    }
  }
}
