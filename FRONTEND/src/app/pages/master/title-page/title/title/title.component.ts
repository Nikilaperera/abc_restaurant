import {Component, OnInit, ViewChild} from '@angular/core';
import {MatTableDataSource} from "@angular/material/table";
import {MatPaginator} from "@angular/material/paginator";
import {MatSort} from "@angular/material/sort";
import {MatDialog} from "@angular/material/dialog";
import {TitleService} from "../../services/title.service";
import {TitleDialogComponent} from "../../title-dialog/title-dialog/title-dialog.component";
import {ViewTitleComponent} from "../view-title/view-title.component";
import {EditTitleComponent} from "../../edit-title/edit-title.component";
import Swal from 'sweetalert2';

@Component({
  selector: 'app-title',
  templateUrl: './title.component.html',
  styleUrls: ['./title.component.scss']
})
export class TitleComponent implements OnInit {

  value = 'Clear me';
  displayedColumns: string[] = ['id', 'name', 'action'];
  dataSource!: MatTableDataSource<any>;
  apiResponse: any = [];

  hasAddAccess: boolean = false;
  hasEditAccess: boolean = false;
  hasViewAccess: boolean = false;
  hasDeleteAccess: boolean = false;

  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;

  constructor(public dialog: MatDialog, private api: TitleService) {
  }

  ngOnInit(): void {
    const moduleId = 4;
    this.api.getModulePermission(moduleId).subscribe((permission) => {
      this.hasAddAccess = permission.some((permission: any) => permission.add_access === 'Yes');
      this.hasEditAccess = permission.some((permission: any) => permission.edit_access === 'Yes');
      this.hasViewAccess = permission.some((permission: any) => permission.view_access === 'Yes');
      this.hasDeleteAccess = permission.some((permission: any) => permission.delete_access === 'Yes');
    });
    this.getAllTitles();
  }

  openDialog() {
    this.dialog.open(TitleDialogComponent, {
      width: '40%',
      height: 'auto',

    }).afterClosed().subscribe(val => {
      if (val === 'save') {
        this.getAllTitles();
      }
    })
  }

  getAllTitles() {

    this.api.getTitle().subscribe({
      next: (res) => {
        this.dataSource = new MatTableDataSource(res);
        this.dataSource.paginator = this.paginator;
        this.dataSource.sort = this.sort;
        this.apiResponse = res
        //console.log(res);
      },
      error: (err) => {
        Swal.fire("No permission to get title list !");
      }
    })
  }

  editTitle(row: any) {
    this.dialog.open(EditTitleComponent, {
      width: '30%',

      data: row,
    }).afterClosed().subscribe(val => {
      if (val === 'update') {
        this.getAllTitles();
      }
    })
  }

  viewTitle(row: any) {
    this.dialog.open(ViewTitleComponent, {
      width: '40%',
      height: 'auto',
      data: row,
    }).afterClosed().subscribe(val => {
      if (val === 'update') {
        this.getAllTitles();
      }
    })
  }

  deleteTitle(id: any) {
    Swal.fire({
      title: 'Are you sure you want to delete ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes',
    }).then((result) => {
      if (result.isConfirmed) {
        this.api.deletetitle(id).subscribe({
          next: (res) => {
            this.getAllTitles();
            Swal.fire("Title deleted successfully");
          },
          error: () => {
            Swal.fire("Title already applied, you can't delete !");
          }

        })
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
