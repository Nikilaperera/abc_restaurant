import { Component, OnInit, Inject } from '@angular/core';
import {
  FormGroup,
  FormBuilder,
  Validators,
  FormControl,
} from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import Swal from 'sweetalert2';
import {MenuItemsService} from "../services/menu-items.service";

@Component({
  selector: 'app-menu-items-dialog',
  templateUrl: './menu-items-dialog.component.html',
  styleUrls: ['./menu-items-dialog.component.scss']
})
export class MenuItemsDialogComponent implements OnInit {
  menuItemForm!: FormGroup;
  formTitle: string = 'Add';
  actionBtn: string = 'Save';
  MenuTypeList: any[] = [];

  constructor(
    private formBuilder: FormBuilder,
    private api: MenuItemsService,
    @Inject(MAT_DIALOG_DATA) public editData: any,
    private dialogRef: MatDialogRef<MenuItemsDialogComponent>
  ) {}
  ngOnInit(): void {
    this.get_all_menu_types();

    this.menuItemForm = this.formBuilder.group({
      code: ['', Validators.required],
      menu_type: ['', Validators.required],
      name: ['', Validators.required],
      remarks: ['', Validators.required],
      status: ['', Validators.required],
    });

    console.log(this.editData);

    if (this.editData) {
      this.formTitle = 'Edit';
      this.actionBtn = 'Update';
      this.menuItemForm.controls['code'].setValue(this.editData.code);
      this.menuItemForm.controls['menu_type'].setValue(
        this.editData.menu_type
      );
      this.menuItemForm.controls['name'].setValue(this.editData.name);
      this.menuItemForm.controls['remarks'].setValue(this.editData.remarks);
      this.menuItemForm.controls['status'].setValue(this.editData.status);
    }
  }

  private get_all_menu_types() {
    this.api.getAllMenuTypes().subscribe((res) => {
      this.MenuTypeList = res;
      console.log(res);
    });
  }

  addMenuItem() {
    if (!this.editData) {
      // if (this.intakeForm.valid) {
      var formData: any = new FormData();
      formData.append('code', this.menuItemForm.controls['code'].value);
      formData.append('menu_type',this.menuItemForm.controls['menu_type'].value);
      formData.append('name', this.menuItemForm.controls['name'].value);
      formData.append('remarks', this.menuItemForm.controls['remarks'].value);
      formData.append('status', this.menuItemForm.controls['status'].value);

      if(!formData.get('code') || !formData.get('menu_type') || !formData.get('name') || !formData.get('remarks') || !formData.get('status') ) {
        Swal.fire("Please fill required Fields !");
      } else {

        for (var pair of formData.entries()) {
          console.log(pair[0] + ', ' + pair[1]);
        }
        // console.log(this.programForm.controls['thumbnail'].value);

        this.api.postMenuItem(formData).subscribe({
          next: (res) => {
            if(res == null) {
              Swal.fire("Menu Item Already Exists !");
              this.menuItemForm.reset();
              this.dialogRef.close('save');
            }
            Swal.fire('Menu Item added successfully !');
            this.menuItemForm.reset();
            this.dialogRef.close('save');
          },
          error: (res) => {
            Swal.fire("Menu Item Already Exists !");
          },
        });
      }

    } else {
      this.updateMenuItem();
    }
  }

  private updateMenuItem() {
    var formData: any = new FormData();
    formData.append('code', this.menuItemForm.controls['code'].value);
    formData.append('menu_type',this.menuItemForm.controls['menu_type'].value);
    formData.append('name', this.menuItemForm.controls['name'].value);
    formData.append('remarks', this.menuItemForm.controls['remarks'].value);
    formData.append('status', this.menuItemForm.controls['status'].value);

    if(!formData.get('code') || !formData.get('menu_type') || !formData.get('name') || !formData.get('remarks') || !formData.get('status') ) {
      Swal.fire("Please fill required Fields !");
    } else {

      this.api.updateMenuItem(formData, this.editData.id).subscribe({
        next: (res) => {
          Swal.fire('Menu Item updated successfully..');
          this.menuItemForm.reset();
          this.dialogRef.close('update');
          for (var pair of formData.entries()) {
            console.log(pair[0] + ', ' + pair[1]);
          }
        },
        error: (res) => {
          Swal.fire("Menu Item Already Exists !");
        },
      });
    }
  }
}
