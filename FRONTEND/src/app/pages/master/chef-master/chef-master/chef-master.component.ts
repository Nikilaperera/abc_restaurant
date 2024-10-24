import { Component, OnInit, ViewChild } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatSnackBar, MatSnackBarHorizontalPosition, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { MatTableDataSource } from '@angular/material/table';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import Swal from 'sweetalert2';
import { ChefMasterService } from '../services/chef-master.service';
import { ChefDialogComponent } from '../chef-dialog/chef-dialog.component';

@Component({
  selector: 'app-chef-master',
  templateUrl: './chef-master.component.html',
  styleUrls: ['./chef-master.component.scss']
})
export class ChefMasterComponent implements OnInit {
  displayedColumns: string[] = ['id', 'name', 'email', 'status', 'action'];
  dataSource!: MatTableDataSource<any>;
  horizontalPosition: MatSnackBarHorizontalPosition = 'center';
  verticalPosition: MatSnackBarVerticalPosition = 'top';

  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;

  constructor(
    public dialog: MatDialog,
    private api: ChefMasterService,
    private snackBar: MatSnackBar
  ) {}

  ngOnInit(): void {
    this.getAllChefDetails();
  }

  openDialog() {
    this.dialog.open(ChefDialogComponent, {
      width: '900px',
      height: 'auto',
    }).afterClosed().subscribe(val => {
      if (val === 'save') {
        this.getAllChefDetails();
      }
    });
  }

  getAllChefDetails() {
    this.api.getChef().subscribe({
      next: (res) => {
        this.dataSource = new MatTableDataSource(res);
        this.dataSource.paginator = this.paginator;
        this.dataSource.sort = this.sort;
        console.log(res);
      },
      error: (err) => {
        alert('Error while getting Chef Details!!!');
      },
    });
  }

  editChef(row: any) {
    this.dialog.open(ChefDialogComponent, {
      width: '900px',
      height: 'auto',
      data: row,
    }).afterClosed().subscribe(val => {
      if (val === 'update') {
        this.getAllChefDetails();
      }
    });
  }

  deleteChef(id: number) {
    Swal.fire({
      title: 'Are you sure you want to delete ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
    }).then(result => {
      if (result.isConfirmed) {
        this.api.deleteChef(id).subscribe({
          next: (res) => {
            this.getAllChefDetails();
            Swal.fire('Chef Details deleted successfully');
          },
          error: () => {
            Swal.fire("Chef Details already in a table, you can't delete!");
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
