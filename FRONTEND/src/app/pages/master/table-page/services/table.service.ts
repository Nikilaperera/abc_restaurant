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
}
