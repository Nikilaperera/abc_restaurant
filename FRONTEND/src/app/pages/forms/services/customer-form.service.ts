import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from '../../../../enviroments/enviroment';

@Injectable({
  providedIn: 'root'
})
export class CustomerFormService {

  constructor(private http: HttpClient) {}

  url = environment.apiUrl;

  getAllTables() {
    return this.http.get<any>(this.url + 'forms/CustomerFormController/getAllTables/');
  }

  getAllMenuTypes() {
    return this.http.get<any>(this.url + 'forms/CustomerFormController/getAllMenuTypes/');
  }

  getAllMenuItems(data: any) {
    return this.http.post(this.url + 'forms/CustomerFormController/getAllMenuItems/', data);
  }

  postOrder(api: CustomerFormService) {
    console.log(api);
    return this.http.post(this.url + 'forms/CustomerFormController/add', api);
  }
}
