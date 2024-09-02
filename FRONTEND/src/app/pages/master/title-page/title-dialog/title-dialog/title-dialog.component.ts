import {Component, Inject, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import {TitleService} from "../../services/title.service";
import Swal from 'sweetalert2';

@Component({
  selector: 'app-title-dialog',
  templateUrl: './title-dialog.component.html',
  styleUrls: ['./title-dialog.component.scss']
})
export class TitleDialogComponent implements OnInit {
  titleForm!: FormGroup;
  actionBtn: string = "Save";

  constructor(
    private formBuilder: FormBuilder,
    private api: TitleService,
    @Inject(MAT_DIALOG_DATA) public editData: any,
    private dialogRef: MatDialogRef<TitleDialogComponent>,
  ) {
  }

  ngOnInit(): void {
    this.titleForm = this.formBuilder.group({

      name: ['', Validators.required]

    });

    console.log(this.editData);
    if (this.editData) {
      this.actionBtn = "Update";
      this.titleForm.controls['name'].setValue(this.editData.name);
    }

  }

  updateTitle() {
    //console.log('test');
    var formData: any = new FormData();
    formData.append('name', this.titleForm.controls['name'].value);

    this.api.updateTitle(formData, this.editData.id).subscribe({
      next: (res) => {

        Swal.fire("Title updated successfully..");
        this.titleForm.reset();
        this.dialogRef.close('update');
        for (var pair of formData.entries()) {
          console.log(pair[0] + ', ' + pair[1]);
        }

      },
      error: (res) => {
        Swal.fire("Title already exists !");
      }
    })
  }

  addTitle() {
    if (!this.editData) {
      if (this.titleForm.valid) {
        var formData: any = new FormData();
        formData.append('name', this.titleForm.controls['name'].value);

        for (var pair of formData.entries()) {
          console.log(pair[0] + ', ' + pair[1]);
        }

        this.api.postTitle(formData).subscribe({
          next: (res) => {
            Swal.fire("Title added successfully..");
            this.titleForm.reset();
            this.dialogRef.close('save');

          },
          error: (res) => {
            Swal.fire("Title Already Exists !");

          }
        })
      } else {

      }
    } else {
      this.updateTitle();
    }
  }
}
