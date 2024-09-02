
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/enviroments/enviroment';
@Injectable({
  providedIn: 'root'
})
export class SystemLogService {

  constructor(private http: HttpClient) {
    
  };


  url = environment.apiUrl;


  getAllLogs() {
    return this.http.get<any>(this.url + "systemLog/SystemLog/");
  }


}
