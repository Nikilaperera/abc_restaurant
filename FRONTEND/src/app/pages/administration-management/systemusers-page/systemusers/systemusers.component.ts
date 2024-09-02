import { Component, ViewChild, OnInit, ChangeDetectorRef } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';
import { SystemusersApiService } from '../services/systemusers-api.service';
import { SystemusersDialogComponent } from '../systemusers-dialog/systemusers-dialog.component';
import { EditPermissionsDialogComponent } from '../../edit-permissions-dialog/edit-permissions-dialog.component';

@Component({
  selector: 'app-systemusers',
  templateUrl: './systemusers.component.html',
  styleUrls: ['./systemusers.component.scss']
})
export class SystemusersComponent implements OnInit {

  displayedColumns: string[] = ['id','username','email','active', 'phone', 'action'];
  dataSource!: MatTableDataSource<any>;

  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;

  hasAddAccess: boolean = false;
  hasEditAccess: boolean = false;
  hasViewAccess: boolean = false;
  hasDeleteAccess: boolean = false;

  constructor( private cdr: ChangeDetectorRef,public dialog: MatDialog, private api: SystemusersApiService) { }

  ngOnInit(): void {
    const moduleId = 121;
    this.api.getModulePermission(moduleId).subscribe((permission) => {
      this.hasAddAccess = permission.some((permission:any) => permission.add_access === 'Yes');
      this.hasEditAccess = permission.some((permission:any) => permission.edit_access === 'Yes');
      this.hasViewAccess = permission.some((permission:any) => permission.view_access === 'Yes');
      this.hasDeleteAccess = permission.some((permission:any) => permission.delete_access === 'Yes');
    });
     this.getAllUsers();
   }


   openDialog() {
    this.dialog.open(SystemusersDialogComponent, {
      width: '900px',
      height: 'auto',
    }).afterClosed().subscribe(val => {

        this.getAllUsers();

    })
  }
  getAllUsers() {

    this.api.getAllUsers().subscribe({
      next: (res) => {

        res.forEach((value: any) => {
          if(value.active==='1'){
            value.active='Active'
          }else if(value.active==='0'){
            value.active='Inactive'

          }

        });

        this.dataSource = new MatTableDataSource(res);
        this.dataSource.paginator = this.paginator;
        this.dataSource.sort = this.sort;
      },
      error: (err) => {
        //Swal.fire("Error while getting users!!!");
      }
    })
  }


  editUsers(row: any) {
    this.dialog.open(EditPermissionsDialogComponent, {
      width: '900px',
      height: 'auto',
      data: row,
    }).afterClosed().subscribe(val => {
      this.getAllUsers();
    })
  }


  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();

    if (this.dataSource.paginator) {
      this.dataSource.paginator.firstPage();
    }
  }

}
