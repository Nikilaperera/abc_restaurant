import { Component, ViewChild } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatSnackBar, MatSnackBarHorizontalPosition, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { MatTableDataSource } from '@angular/material/table';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import Swal from 'sweetalert2';
import {MenuTypesService} from "../services/menu-types.service";
import {MenuTypesDialogComponent} from "../menu-types-dialog/menu-types-dialog.component";

@Component({
  selector: 'app-menu-types',
  templateUrl: './menu-types.component.html',
  styleUrls: ['./menu-types.component.scss']
})
export class MenuTypesComponent {
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

  constructor(public dialog: MatDialog, private api: MenuTypesService,private snackBar: MatSnackBar) { }

  ngOnInit(): void {
    // const moduleId = 194;
    // this.api.getModulePermission(moduleId).subscribe((permission) => {
    //   this.hasAddAccess = permission.some((permission:any) => permission.add_access === 'Yes');
    //   this.hasEditAccess = permission.some((permission:any) => permission.edit_access === 'Yes');
    //   this.hasViewAccess = permission.some((permission:any) => permission.view_access === 'Yes');
    //   this.hasDeleteAccess = permission.some((permission:any) => permission.delete_access === 'Yes');
    // });
    this.getAllMenuTypes();
  }

  openDialog() {
    this.dialog.open(MenuTypesDialogComponent, {
      width: '900px',
      height: 'auto',

    }).afterClosed().subscribe(val => {
      if (val === 'save') {
        this.getAllMenuTypes();
      }
    })
  }

  getAllMenuTypes() {
    this.api.getMenuTypes().subscribe({
      next: (res) => {
        this.dataSource = new MatTableDataSource(res);
        this.dataSource.paginator = this.paginator;
        this.dataSource.sort = this.sort;
        console.log(res);
      },
      error: (err) => {
        alert("Error while getting Menu Types!!!");
      }
    })
  }
  editMenuTypes(row: any) {
    this.dialog.open(MenuTypesDialogComponent, {
      width: '900px',
      height: 'auto',
      data: row,
    }).afterClosed().subscribe(val => {
      if (val === 'update') {
        this.getAllMenuTypes();
      }
    })
  }
  deleteMenuTypes(id: number) {
    // Ask for confirmation
    Swal.fire({
      title: 'Are you sure you want to delete ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
    }).then(result=>{
      if (result.isConfirmed) {
        this.api.deleteMenuTypes(id).subscribe({
          next: (res) => {
            this.getAllMenuTypes();
            Swal.fire('Menu Type deleted successfully');
          },
          error:()=>{
            Swal.fire("Menu Type already in a table, you can't delete !");
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
