import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs/internal/Observable';
import { environment } from 'src/enviroments/enviroment';

@Injectable({
  providedIn: 'root'
})
export class TableService {

  constructor(private http: HttpClient) {}

  url = environment.apiUrl;

  getAllTables() {
    return this.http.get<any>(
      this.url + 'master/TableController/'
    );
  }

  postTable(api: TableService) {
    console.log(api);
    return this.http.post(this.url + 'master/TableController/add', api);
  }

  updateTable(api: TableService, id: number) {
    return this.http.post(
      this.url + 'master/TableController/update/' + id,
      api
    );
  }

  deleteTable(id: number) {
    return this.http.delete(
      this.url + 'master/TableController/delete/' + id
    );
  }
}
