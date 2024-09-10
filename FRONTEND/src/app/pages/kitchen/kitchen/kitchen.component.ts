import { Component, ViewChild, OnInit } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';
import {KitchenService} from "../services/kitchen.service";
import {KitchenDialogComponent} from "../kitchen-dialog/kitchen-dialog.component";
import Swal from "sweetalert2";

@Component({
  selector: 'app-kitchen',
  templateUrl: './kitchen.component.html',
  styleUrls: ['./kitchen.component.scss']
})
export class KitchenComponent implements OnInit{
  displayedColumns: string[] = ['id','order_id', 'table_code','customer_name','customer_number','menu_type','menu_item','quantity','order_status', 'action'];
  dataSource!: MatTableDataSource<any>;

  // hasAddAccess: boolean = false;
  // hasEditAccess: boolean = false;
  // hasViewAccess: boolean = false;
  // hasDeleteAccess: boolean = false;

  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;

  constructor(public dialog: MatDialog, private api: KitchenService) { }

  ngOnInit(): void {
    // const moduleId = 19;
    // this.api.getModulePermission(moduleId).subscribe((permission) => {
    //   this.hasAddAccess = permission.some((permission:any) => permission.add_access === 'Yes');
    //   this.hasEditAccess = permission.some((permission:any) => permission.edit_access === 'Yes');
    //   this.hasViewAccess = permission.some((permission:any) => permission.view_access === 'Yes');
    //   this.hasDeleteAccess = permission.some((permission:any) => permission.delete_access === 'Yes');
    // });
    this.getAllKitchenDetails();
  }

  openDialog() {
    this.dialog.open(KitchenDialogComponent, {
      disableClose: true,
      width: '900px',
      height: 'auto',

    }).afterClosed().subscribe(val => {
      if (val === 'save') {
        this.getAllKitchenDetails();
      }
    })
  }

  private getAllKitchenDetails() {
    this.api.getKitchenDetails().subscribe({
      next: (res) => {
        this.dataSource = new MatTableDataSource(res);
        this.dataSource.paginator = this.paginator;
        this.dataSource.sort = this.sort;
        console.log(res);
      },
      error: (err) => {
        Swal.fire("Error while getting Kitchen Details!!!");
      }
    })
  }

  editKitchenDetails(row: any) {

  }

  viewKitchenDetails(row: any) {

  }

  deleteKitchenDetails(id: any) {

  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();

    if (this.dataSource.paginator) {
      this.dataSource.paginator.firstPage();
    }
  }
}
