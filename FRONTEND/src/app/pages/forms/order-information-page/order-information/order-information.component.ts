import { Component, ViewChild, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators, FormControl } from '@angular/forms';
import { MatDialog } from '@angular/material/dialog';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';
import { MatSnackBar, MatSnackBarHorizontalPosition, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import * as _moment from 'moment';
import { default as _rollupMoment, Moment } from 'moment';
import Swal from 'sweetalert2';
import {CustomerFormService} from "../../services/customer-form.service";

@Component({
  selector: 'app-order-information',
  templateUrl: './order-information.component.html',
  styleUrls: ['./order-information.component.scss']
})
export class OrderInformationComponent implements OnInit {

  orderInformationForm!: FormGroup;
  displayedColumns: string[] = ['order_id', 'customer_name', 'customer_email', 'table_code', 'order_status', 'action'];
  dataSource!: MatTableDataSource<any>;
  apiResponse: any = [];

  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;

  horizontalPosition: MatSnackBarHorizontalPosition = 'center';
  verticalPosition: MatSnackBarVerticalPosition = 'top';

  constructor(
    private formBuilder: FormBuilder,
    private snackBar: MatSnackBar,
    public dialog: MatDialog,
    private api: CustomerFormService
  ) {}

  ngOnInit(): void {
    this.orderInformationForm = this.formBuilder.group({
      order_id: ['', Validators.required],
    });
  }


  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();

    if (this.dataSource.paginator) {
      this.dataSource.paginator.firstPage();
    }
  }

  getOrderDetails() {
    if (this.orderInformationForm.valid) {
      var formData: any = new FormData();
      formData.append('order_id',this.orderInformationForm.controls['order_id'].value);

      this.api.getOrderDetails(formData).subscribe({
        next: (res: any) => {
          this.dataSource = new MatTableDataSource(res);
          this.dataSource.paginator = this.paginator;
          this.dataSource.sort = this.sort;
          this.apiResponse = res;
          console.log(res);
        },
        error: (err) => {
          Swal.fire('Error occurred while showing Order Details.');
        },
      });
    } else {
      Swal.fire('Please fill all the required fields.');
    }
  }

  cancelOrder(id: any) {
    Swal.fire({
      title: 'Are you sure you want to cancel the order?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
    }).then((result) => {
      if (result.isConfirmed) {
        // Properly pass the 'id' as a parameter in the API call
        this.api.cancelOrder({ id: id }).subscribe({
          next: (res) => {
            Swal.fire("Order Canceled Successfully");
            // Optional: Reload order details or list here if necessary
            // this.getOrderDetails();
          },
          error: () => {
            Swal.fire("Error while canceling the order!!!!");
          }
        });
      }
    });
  }

}
