import { Component, ViewChild, OnInit } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';
import Swal from 'sweetalert2';
import {MenuItemsService} from "../services/menu-items.service";
import {MenuItemsDialogComponent} from "../menu-items-dialog/menu-items-dialog.component";

@Component({
  selector: 'app-menu-items',
  templateUrl: './menu-items.component.html',
  styleUrls: ['./menu-items.component.scss']
})
export class MenuItemsComponent implements OnInit {

  displayedColumns: string[] = ['id' ,'code','menu_type', 'name','status','action'];
  dataSource!: MatTableDataSource<any>;

  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;

  constructor(public dialog: MatDialog, private api: MenuItemsService) { }

  ngOnInit(): void {
    // const moduleId = 20;
    // this.api.getModulePermission(moduleId).subscribe((permission) => {
    //   this.hasAddAccess = permission.some((permission: any) => permission.add_access === 'Yes');
    //   this.hasEditAccess = permission.some((permission: any) => permission.edit_access === 'Yes');
    //   this.hasViewAccess = permission.some((permission: any) => permission.view_access === 'Yes');
    //   this.hasDeleteAccess = permission.some((permission: any) => permission.delete_access === 'Yes');
    //   this.hasApproveAccess = permission.some((permission: any) => permission.approve_access === 'Yes');
    //   this.hasApproveAccess2 = permission.some((permission: any) => permission.approve_access_2 === 'Yes');
    //   this.hasApproveAccess3 = permission.some((permission: any) => permission.approve_access_3 === 'Yes');
    //   this.hasRejectAccess = permission.some((permission: any) => permission.reject_access === 'Yes');
    // });
    this.getAllMenuItems();
  }

  private getAllMenuItems() {
    this.api.getMenuItems().subscribe({
      next: (res) => {
        this.dataSource = new MatTableDataSource(res);
        this.dataSource.paginator = this.paginator;
        this.dataSource.sort = this.sort;
        console.log(res);
      },
      error: (err) => {
        Swal.fire("Error while getting intakes!!!");
      }
    })
  }

  openDialog() {
    this.dialog.open(MenuItemsDialogComponent, {
      width: '900px',
      height: 'auto',
    }).afterClosed().subscribe(val => {
      if (val === 'save') {
        this.getAllMenuItems();
      }
    })
  }

  editMenuItems(row: any) {
    this.dialog.open(MenuItemsDialogComponent, {
      width: '900px',
      height: 'auto',
      data: row,
    }).afterClosed().subscribe(val => {
      if (val === 'update') {
        this.getAllMenuItems();
      }
    })
  }

  deleteMenuItems(id: any) {
    Swal.fire({
      title: 'Are you sure you want to delete?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
    }).then((result) => {
      if (result.isConfirmed) {
        this.api.deleteMenuItems(id).subscribe({
          next: (res) => {
            this.getAllMenuItems();
            Swal.fire(
              'Deleted',
              'Menu Items deleted successfully.',
              'success'
            );
          },
          error: () => {
            Swal.fire("Menu Items already exists, You can't delete !");
          },
        });
      }
    });
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();

    if (this.dataSource.paginator) {
      this.dataSource.paginator.firstPage();
    }
  }
}
