import { Component, ViewChild } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatSnackBar, MatSnackBarHorizontalPosition, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { MatTableDataSource } from '@angular/material/table';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import Swal from 'sweetalert2';
import {TableService} from "../services/table.service";
import {TableDialogComponent} from "../table-dialog/table-dialog.component";


@Component({
  selector: 'app-table',
  templateUrl: './table.component.html',
  styleUrls: ['./table.component.scss']
})
export class TableComponent {

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

  constructor(public dialog: MatDialog, private api: TableService,private snackBar: MatSnackBar) { }

  ngOnInit(): void {
    // const moduleId = 194;
    // this.api.getModulePermission(moduleId).subscribe((permission) => {
    //   this.hasAddAccess = permission.some((permission:any) => permission.add_access === 'Yes');
    //   this.hasEditAccess = permission.some((permission:any) => permission.edit_access === 'Yes');
    //   this.hasViewAccess = permission.some((permission:any) => permission.view_access === 'Yes');
    //   this.hasDeleteAccess = permission.some((permission:any) => permission.delete_access === 'Yes');
    // });
    this.getAllTables();
  }

  openDialog() {
    this.dialog.open(TableDialogComponent, {
      width: '900px',
      height: 'auto',

    }).afterClosed().subscribe(val => {
      if (val === 'save') {
        this.getAllTables();
      }
    })
  }

  private getAllTables() {
    this.api.getAllTables().subscribe({
      next: (res) => {
        this.dataSource = new MatTableDataSource(res);
        this.dataSource.paginator = this.paginator;
        this.dataSource.sort = this.sort;
        console.log(res);
      },
      error: (err) => {
        alert("Error while getting Tables!!!");
      }
    })
  }

  deleteTable(id: number) {

  }

  editTable(row: any) {

  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();

    if (this.dataSource.paginator) {
      this.dataSource.paginator.firstPage();
    }
  }
}
