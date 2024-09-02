import { Component, OnInit, ViewChild } from '@angular/core';
import { MatTableDataSource } from '@angular/material/table';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { MatDialog } from '@angular/material/dialog';
import { UserGroupsApiService } from '../services/user-groups-api.service';
import {
  MatSnackBar,
  MatSnackBarHorizontalPosition,
  MatSnackBarVerticalPosition,
} from '@angular/material/snack-bar';
import { AddUserGroupsComponent } from '../add-user-groups/add-user-groups.component';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-user-groups',
  templateUrl: './user-groups.component.html',
  styleUrls: ['./user-groups.component.scss'],
})
export class UserGroupsComponent implements OnInit {
  value = 'Clear me';
  displayedColumns: string[] = ['id', 'name', 'description'];
  dataSource!: MatTableDataSource<any>;
  apiResponse: any = [];
  horizontalPosition: MatSnackBarHorizontalPosition = 'center';
  verticalPosition: MatSnackBarVerticalPosition = 'top';

  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;

  constructor(
    private snackBar: MatSnackBar,
    public dialog: MatDialog,
    private api: UserGroupsApiService
  ) {}

  ngOnInit(): void {
    this.getAllUserGroups();
  }

  openDialog() {
    this.dialog.open(AddUserGroupsComponent, {
      width: '700px',
      height: 'auto',

    }).afterClosed().subscribe(val => {
      if (val === 'save') {
        this.getAllUserGroups();
      }
    })
  }

  getAllUserGroups() {
    this.api.getUserGroups().subscribe({
      next: (res) => {
        this.dataSource = new MatTableDataSource(res);
        this.dataSource.paginator = this.paginator;
        this.dataSource.sort = this.sort;
        this.apiResponse = res;
        console.log(res);
      },
      error: (err) => {
        Swal.fire('Error occurred while showing user groups.');
      },
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
