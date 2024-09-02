
import { Component, ViewChild, OnInit, ChangeDetectorRef } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';
import { SystemLogService } from './service/system-log.service';

@Component({
  selector: 'app-system-log-table',
  templateUrl: './system-log-table.component.html',
  styleUrls: ['./system-log-table.component.scss']
})
export class SystemLogTableComponent implements OnInit {

  displayedColumns: string[] = ['id','user_Id','ip_address','action', 'log_message', 'timestamp', 'status'];
  dataSource!: MatTableDataSource<any>;

  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;

  constructor( private cdr: ChangeDetectorRef,public dialog: MatDialog, private api: SystemLogService) { }

  ngOnInit(): void {
     this.getAllUsers();
   }



  getAllUsers() {

    this.api.getAllLogs().subscribe({
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



  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();

    if (this.dataSource.paginator) {
      this.dataSource.paginator.firstPage();
    }
  }

}
