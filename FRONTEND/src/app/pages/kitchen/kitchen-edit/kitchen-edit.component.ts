import { Component, Inject, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import Swal from 'sweetalert2';
import {KitchenService} from "../services/kitchen.service";

@Component({
  selector: 'app-kitchen-edit',
  templateUrl: './kitchen-edit.component.html',
  styleUrls: ['./kitchen-edit.component.scss']
})
export class KitchenEditComponent implements OnInit{

  KitchenForm!: FormGroup;
  actionBtn: string = 'Save';
  MenuTypeList: any[] = [];
  MenuItemList: any[] = [];
  ActiveChefs: any[] = [];

  constructor(
    private formBuilder: FormBuilder,
    private api: KitchenService,
    @Inject(MAT_DIALOG_DATA) public editData: any,
    private dialogRef: MatDialogRef<KitchenEditComponent>
  ) {}

  ngOnInit(): void {
    this.get_all_menu_types();
    this.getActiveChefs();

    this.KitchenForm = this.formBuilder.group({
      order_id: [''],
      customer_name: [''],
      customer_number: [''],
      customer_email: [''],
      table_code: [''],
      menu_type: [''],
      menu_item: [''],
      extra_note: [''],
      quantity: [''],
      order_status: [''],
      chef_id : [''],
      orders: this.formBuilder.array([]),
    });


    console.log(this.editData);
    if (this.editData) {
      this.actionBtn = 'Update';
      this.KitchenForm.controls['order_id'].setValue(this.editData.order_id);
      this.KitchenForm.controls['customer_name'].setValue(this.editData.customer_name);
      this.KitchenForm.controls['customer_number'].setValue(this.editData.customer_number);
      this.KitchenForm.controls['customer_email'].setValue(this.editData.customer_email);
      this.KitchenForm.controls['table_code'].setValue(this.editData.table_name);
      this.KitchenForm.controls['order_status'].setValue(this.editData.order_status);
      this.KitchenForm.controls['menu_type'].setValue(this.editData.menu_type);
      this.KitchenForm.controls['menu_item'].setValue(this.editData.menu_item);
      this.KitchenForm.controls['extra_note'].setValue(this.editData.extra_note);
      this.KitchenForm.controls['quantity'].setValue(this.editData.quantity);
      this.KitchenForm.controls['chef_id'].setValue(this.editData.chef_id);
    }
  }

  orders(): FormArray {
    return this.KitchenForm.get('orders') as FormArray;
  }

  private getActiveChefs() {
    this.api.getActiveChefs().subscribe((data) => {
      this.ActiveChefs = data;
    })
  };

  private get_all_menu_types() {
    this.api.getAllMenuTypes().subscribe((res) => {
      this.MenuTypeList = res;
      console.log(res);
    });
  }

  updateOrder() {
    if (this.KitchenForm.valid) {
      var formData: any = new FormData();

      const order_status = this.KitchenForm.controls['order_status'].value;
      const chef_name = this.KitchenForm.controls['chef_id'].value;

      formData.append('order_status', order_status);
      formData.append('chef_id', chef_name);

      this.api.updateOrder(formData, this.editData.id).subscribe({
        next: (res) => {
          Swal.fire('Status updated successfully..');
          this.KitchenForm.reset();
          this.dialogRef.close('update');
          for (var pair of formData.entries()) {
            console.log(pair[0] + ', ' + pair[1]);
          }
        },
        error: (res) => {
          Swal.fire('Error while updating the Status');
        },
      });
    } else {
      Swal.fire('Please fill required fields !');
    }
  }
}
