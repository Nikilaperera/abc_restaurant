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
      name: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      status: ['', Validators.required],
    });

    if (this.editData) {
      this.formTitle = 'Edit';
      this.actionBtn = 'Update';
      this.chefForm.patchValue(this.editData); 
    }
  }

  addChef(): void {
    if (this.chefForm.valid) {
      if (!this.editData) {
        this.api.postChef(this.chefForm.value).subscribe({
          next: () => {
            Swal.fire('Chef Details added successfully.');
            this.chefForm.reset();
            this.dialogRef.close('save');
          },
          error: () => {
            Swal.fire('Chef Details already exist...');
          },
        });
      } else {
        this.updateChef();
      }
    } else {
      Swal.fire('Please fill required fields.');
    }
  }

  // Update method to handle edit cases
  updateChef(): void {
    if (this.chefForm.valid) {
      this.api.updateChef(this.chefForm.value, this.editData.id).subscribe({
        next: () => {
          Swal.fire('Chef Details updated successfully.');
          this.chefForm.reset();
          this.dialogRef.close('update');
        },
        error: () => {
          Swal.fire('Chef Details already exist.');
        },
      });
    } else {
      Swal.fire('Please fill required fields.');
    }
  }
}
