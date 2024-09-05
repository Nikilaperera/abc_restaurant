import { Component, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatSnackBar, MatSnackBarHorizontalPosition, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import Swal from 'sweetalert2';
import {MenuTypesService} from "../services/menu-types.service";

@Component({
  selector: 'app-menu-types-dialog',
  templateUrl: './menu-types-dialog.component.html',
  styleUrls: ['./menu-types-dialog.component.scss']
})
export class MenuTypesDialogComponent {

  menuTypeForm!: FormGroup;
  formTitle: string = 'Add';
  actionBtn: string = 'Save';

  horizontalPosition: MatSnackBarHorizontalPosition = 'center';
  verticalPosition: MatSnackBarVerticalPosition = 'top';

  constructor(
    private formBuilder: FormBuilder,
    private snackBar: MatSnackBar,
    private api: MenuTypesService,
    @Inject(MAT_DIALOG_DATA) public editData: any,
    private dialogRef: MatDialogRef<MenuTypesDialogComponent>
  ) {}

  ngOnInit(): void {

    this.menuTypeForm = this.formBuilder.group({

      code: ['', Validators.required],
      name: ['', Validators.required],
      status: ['', Validators.required],

    });
    console.log(this.editData);
    if (this.editData) {
      this.formTitle = 'Edit';
      this.actionBtn = 'Update';
      this.menuTypeForm.controls['code'].setValue(this.editData.code);
      this.menuTypeForm.controls['name'].setValue(this.editData.name);
      this.menuTypeForm.controls['status'].setValue(this.editData.status);
    }
  }

  addMenuType() {
    if (!this.editData) {
      if (this.menuTypeForm.valid) {
        var formData: any = new FormData();
        formData.append('code', this.menuTypeForm.controls['code'].value);
        formData.append('name', this.menuTypeForm.controls['name'].value);
        formData.append(
          'status',
          this.menuTypeForm.controls['status'].value
        );

        for (var pair of formData.entries()) {
          console.log(pair[0] + ', ' + pair[1]);
        }

        this.api.postMenuTypes(formData).subscribe({
          next: (res) => {
            Swal.fire('Menu Type added successfully.');
            this.menuTypeForm.reset();
            this.dialogRef.close('save');
          },
          error: (res) => {
            Swal.fire("Menu Type already exist...");


          }
        });
      } else {
        Swal.fire('Please fill required fields.');
      }
    } else {
      this.updateMenuType();
    }
  }

  updateMenuType() {
    if (this.menuTypeForm.valid) {
      var formData: any = new FormData();
      formData.set('code', this.menuTypeForm.controls['code'].value);
      formData.set('name', this.menuTypeForm.controls['name'].value);
      formData.set('status', this.menuTypeForm.controls['status'].value);

      this.api.updateMenuTypes(formData, this.editData.id).subscribe({
        next: (res) => {
          Swal.fire('Menu Type updated successfully.');
          this.menuTypeForm.reset();
          this.dialogRef.close('update');
          for (var pair of formData.entries()) {
            console.log(pair[0] + ', ' + pair[1]);
          }
        },
        error: (res) => {
          Swal.fire('Menu Type already exist.');
        },
      });
    } else {
      Swal.fire('Please fill required fields.');
    }
  }
}
