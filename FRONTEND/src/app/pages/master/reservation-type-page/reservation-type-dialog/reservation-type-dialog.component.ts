import { Component, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatSnackBar, MatSnackBarHorizontalPosition, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import Swal from 'sweetalert2';
import {ReservationTypeService} from "../services/reservation-type.service";

@Component({
  selector: 'app-reservation-type-dialog',
  templateUrl: './reservation-type-dialog.component.html',
  styleUrls: ['./reservation-type-dialog.component.scss']
})
export class ReservationTypeDialogComponent {

  reservationTypeForm!: FormGroup;
  formTitle: string = 'Add';
  actionBtn: string = 'Save';

  horizontalPosition: MatSnackBarHorizontalPosition = 'center';
  verticalPosition: MatSnackBarVerticalPosition = 'top';

  constructor(
    private formBuilder: FormBuilder,
    private snackBar: MatSnackBar,
    private api: ReservationTypeService,
    @Inject(MAT_DIALOG_DATA) public editData: any,
    private dialogRef: MatDialogRef<ReservationTypeDialogComponent>
  ) {}

  ngOnInit(): void {

    this.reservationTypeForm = this.formBuilder.group({

      code: ['', Validators.required],
      name: ['', Validators.required],
      status: ['', Validators.required],

    });
    console.log(this.editData);
    if (this.editData) {
      this.formTitle = 'Edit';
      this.actionBtn = 'Update';
      this.reservationTypeForm.controls['code'].setValue(this.editData.code);
      this.reservationTypeForm.controls['name'].setValue(this.editData.name);
      this.reservationTypeForm.controls['status'].setValue(this.editData.status);
    }
  }

  addReservationType() {
    if (!this.editData) {
      if (this.reservationTypeForm.valid) {
        var formData: any = new FormData();
        formData.append('code', this.reservationTypeForm.controls['code'].value);
        formData.append('name', this.reservationTypeForm.controls['name'].value);
        formData.append(
          'status',
          this.reservationTypeForm.controls['status'].value
        );

        for (var pair of formData.entries()) {
          console.log(pair[0] + ', ' + pair[1]);
        }

        this.api.postReservationType(formData).subscribe({
          next: (res) => {
            Swal.fire('Reservation Type added successfully.');
            this.reservationTypeForm.reset();
            this.dialogRef.close('save');
          },
          error: (res) => {
            Swal.fire("Reservation Type already exist...");


          }
        });
      } else {
        Swal.fire('Please fill required fields.');
      }
    } else {
      this.updateReservationType();
    }
  }

  private updateReservationType() {

  }
}
