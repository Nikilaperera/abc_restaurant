import {Component, Inject, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {TitleService} from "../../services/title.service";
import {MAT_DIALOG_DATA, MatDialogRef} from "@angular/material/dialog";
import Swal from 'sweetalert2';

@Component({
  selector: 'app-view-title',
  templateUrl: './view-title.component.html',
  styleUrls: ['./view-title.component.scss']
})
export class ViewTitleComponent implements OnInit {
  titleForm!: FormGroup;
  actionBtn: string = "Save";

  constructor(
    private formBuilder: FormBuilder,
    private api: TitleService,
    @Inject(MAT_DIALOG_DATA) public editData: any,
    private dialogRef: MatDialogRef<ViewTitleComponent>,
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
        Swal.fire("Can't Update the title");
      }
    })
  }
}
