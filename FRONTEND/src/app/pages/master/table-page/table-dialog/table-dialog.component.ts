import { Component, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatSnackBar, MatSnackBarHorizontalPosition, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import Swal from 'sweetalert2';
import {TableService} from "../services/table.service";

@Component({
  selector: 'app-table-dialog',
  templateUrl: './table-dialog.component.html',
  styleUrls: ['./table-dialog.component.scss']
})
export class TableDialogComponent {

  tableForm!: FormGroup;
  formTitle: string = 'Add';
  actionBtn: string = 'Save';

  horizontalPosition: MatSnackBarHorizontalPosition = 'center';
  verticalPosition: MatSnackBarVerticalPosition = 'top';

  constructor(
    private formBuilder: FormBuilder,
    private snackBar: MatSnackBar,
    private api: TableService,
    @Inject(MAT_DIALOG_DATA) public editData: any,
    private dialogRef: MatDialogRef<TableDialogComponent>
  ) {}

  ngOnInit(): void {

    this.tableForm = this.formBuilder.group({

      code: ['', Validators.required],
      name: ['', Validators.required],
      status: ['', Validators.required],

    });
    console.log(this.editData);
    if (this.editData) {
      this.formTitle = 'Edit';
      this.actionBtn = 'Update';
      this.tableForm.controls['code'].setValue(this.editData.code);
      this.tableForm.controls['name'].setValue(this.editData.name);
      this.tableForm.controls['status'].setValue(this.editData.status);
    }
  }

  addTable() {
    if (!this.editData) {
      if (this.tableForm.valid) {
        var formData: any = new FormData();
        formData.append('code', this.tableForm.controls['code'].value);
        formData.append('name', this.tableForm.controls['name'].value);
        formData.append(
          'status',
          this.tableForm.controls['status'].value
        );

        for (var pair of formData.entries()) {
          console.log(pair[0] + ', ' + pair[1]);
        }

        this.api.postTable(formData).subscribe({
          next: (res) => {
            Swal.fire('Table added successfully.');
            this.tableForm.reset();
            this.dialogRef.close('save');
          },
          error: (res=null) => {
            Swal.fire("Table already exists...");
          }
        });
      } else {
        Swal.fire('Please fill required fields.');
      }
    } else {
      this.updateTable();
    }
  }


  private updateTable() {
    if (this.tableForm.valid) {
      var formData: any = new FormData();
      formData.set('code', this.tableForm.controls['code'].value);
      formData.set('name', this.tableForm.controls['name'].value);
      formData.set('status', this.tableForm.controls['status'].value);

      this.api.updateTable(formData, this.editData.id).subscribe({
        next: (res) => {
          Swal.fire('Table updated successfully');
          this.tableForm.reset();
          this.dialogRef.close('update');
        },
        error: (res) => {
          Swal.fire("Table already exists");
        },
      });
    }
  }
}
