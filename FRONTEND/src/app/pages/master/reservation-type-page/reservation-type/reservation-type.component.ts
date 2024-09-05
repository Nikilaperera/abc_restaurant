import { Component, ViewChild } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatSnackBar, MatSnackBarHorizontalPosition, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { MatTableDataSource } from '@angular/material/table';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import Swal from 'sweetalert2';
import {ReservationTypeService} from "../services/reservation-type.service";
import {ReservationTypeDialogComponent} from "../reservation-type-dialog/reservation-type-dialog.component";

@Component({
  selector: 'app-menu-types',
  templateUrl: './reservation-type.component.html',
  styleUrls: ['./reservation-type.component.scss']
})
export class ReservationTypeComponent {
  displayedColumns: string[] = ['id','code', 'name','status', 'action'];
  dataSource!: MatTableDataSource<any>;
  horizontalPosition: MatSnackBarHorizontalPosition = 'center';
  verticalPosition: MatSnackBarVerticalPosition = 'top';

  // hasAddAccess: boolean = false;
  // hasEditAccess: boolean = false;
  // hasViewAccess: boolean = false;
  // hasDeleteAccess: boolean = false;

  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;

  constructor(public dialog: MatDialog, private api: ReservationTypeService,private snackBar: MatSnackBar) { }

  ngOnInit(): void {
    // const moduleId = 194;
    // this.api.getModulePermission(moduleId).subscribe((permission) => {
    //   this.hasAddAccess = permission.some((permission:any) => permission.add_access === 'Yes');
    //   this.hasEditAccess = permission.some((permission:any) => permission.edit_access === 'Yes');
    //   this.hasViewAccess = permission.some((permission:any) => permission.view_access === 'Yes');
    //   this.hasDeleteAccess = permission.some((permission:any) => permission.delete_access === 'Yes');
    // });
    this.getReservationTypes();
  }

  openDialog() {
    this.dialog.open(ReservationTypeDialogComponent, {
      width: '900px',
      height: 'auto',

    }).afterClosed().subscribe(val => {
      if (val === 'save') {
        this.getReservationTypes();
      }
    })
  }

  getReservationTypes() {
    this.api.getReservationTypes().subscribe({
      next: (res) => {
        this.dataSource = new MatTableDataSource(res);
        this.dataSource.paginator = this.paginator;
        this.dataSource.sort = this.sort;
        console.log(res);
      },
      error: (err) => {
        alert("Error while getting Reservation Types!!!");
      }
    })
  }

  editReservationType(row: any) {
    this.dialog.open(ReservationTypeDialogComponent, {
      width: '900px',
      height: 'auto',
      data: row,
    }).afterClosed().subscribe(val => {
      if (val === 'update') {
        this.getReservationTypes();
      }
    })
  }

  deleteReservationType(id: number) {
    // Ask for confirmation
    Swal.fire({
      title: 'Are you sure you want to delete ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
    }).then(result=>{
      if (result.isConfirmed) {
        this.api.deleteReservationTypes(id).subscribe({
          next: (res) => {
            this.getReservationTypes();
            Swal.fire('Reservation Type deleted successfully');
          },
          error:()=>{
            Swal.fire("Reservation Type already in a table, you can't delete !");
          }
        })}})
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();

    if (this.dataSource.paginator) {
      this.dataSource.paginator.firstPage();
    }
  }

}
