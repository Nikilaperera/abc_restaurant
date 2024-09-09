import { Component, OnInit, Inject } from '@angular/core';
import {FormArray, FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CustomerFormService} from "../../services/customer-form.service";
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import Swal from "sweetalert2";

@Component({
  selector: 'app-customer-form',
  templateUrl: './customer-form.component.html',
  styleUrls: ['./customer-form.component.scss']
})
export class CustomerFormComponent implements OnInit{

  customerOrderForm!: FormGroup;
  actionBtn: string = "Save";
  tablesList: any[] =[];
  menuTypeList: any[] =[];
  menuItemList: any[] =[];

  constructor(
    private formBuilder: FormBuilder,
    private api: CustomerFormService,
  ) { }

  ngOnInit(): void {

  this.get_all_tables();
  this.get_all_menu_types();

    this.customerOrderForm = this.formBuilder.group({

      customerName: ['', Validators.required],
      customerEmail: ['', Validators.required],
      customerNumber: ['', Validators.required],
      Table_code: ['', Validators.required],
      note: ['', Validators.required],
      orders: this.formBuilder.array([]),
    });

    this.addRow();

  }

  orders(): FormArray {
    return this.customerOrderForm.get('orders') as FormArray;
  }

  newRow(): FormGroup {
    return this.formBuilder.group({
      menu_type: [''],
      menu_item: [''],
      quantity: [''],
    });
  }

  genOrderForm() {
    let i = 1;
    i++;

    if (i <= 5) {
      this.addRow();
    } else {
    }

    i = +1;
  }

  addRow() {
    const ordersArray = this.customerOrderForm.get('orders') as FormArray;
    const newOrder = this.newRow();

    // Check if 'menu_type' control exists before subscribing
    const menuTypeControl = newOrder.get('menu_type');
    if (menuTypeControl) {
      // Subscribe to valueChanges for menu_type for this row
      menuTypeControl.valueChanges.subscribe((value) => {
        const formData: any = new FormData();
        formData.append('menu_type', value); // Use 'value' instead of accessing the form control directly
        this.api.getAllMenuItems(formData).subscribe((res) => {
          this.menuItemList = [res];
          console.log(res);
        });
      });
    }

    ordersArray.push(newOrder);
  }

  private get_all_tables() {
    this.api.getAllTables().subscribe((res) => {
      this.tablesList = res;
      console.log(res);
    });
  }

  get_all_menu_types() {
    this.api.getAllMenuTypes().subscribe((res) => {
      this.menuTypeList = res;
      console.log(res);
    });
  }
  removeRow(orderIndex: number) {
    this.orders().removeAt(orderIndex);
  }


  addOrder() {
    if (this.customerOrderForm.valid) {

      var formData: any = new FormData();

      const customerName = this.customerOrderForm.controls['customerName'].value;
      const customerEmail = this.customerOrderForm.controls['customerEmail'].value;
      const customerNumber = this.customerOrderForm.controls['customerNumber'].value;
      const Table_code = this.customerOrderForm.controls['Table_code'].value;
      const orders = this.customerOrderForm.controls['orders'].value;

      formData.append('customerName', customerName);
      formData.append('customerEmail', customerEmail);
      formData.append('customerNumber', customerNumber);
      formData.append('Table_code', Table_code);

      formData.append('orders', JSON.stringify(orders));

      console.log(this.customerOrderForm.value);

      this.api.postOrder(formData).subscribe({
        next: (res) => {
          Swal.fire('Order added successfully..');
          this.customerOrderForm.reset();
          // this.dialogRef.close('save');
        },
        error: (res) => {
          Swal.fire('Order already exist..');
        },
      });
    } else {
      Swal.fire('Please fill required fields !');
    }
  }
}
