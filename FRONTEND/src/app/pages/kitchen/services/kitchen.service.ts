import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../../../enviroments/enviroment';

@Injectable({
  providedIn: 'root'
})
export class KitchenService {
  constructor(private http: HttpClient) {}

  url = environment.apiUrl;


  getKitchenDetails() {
    return this.http.get<any>(this.url + 'kitchen/KitchenController');
  }
}
