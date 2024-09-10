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

  deleteKitchenDetails(id: number) {
    return this.http.delete(this.url + 'kitchen/KitchenController/delete/' + id);
  }

  getAllMenuItems(data: any) {
    return this.http.post(this.url + 'kitchen/KitchenController/getAllMenuItems/', data);
  }

  getAllMenuTypes() {
    return this.http.get<any>(this.url + 'kitchen/KitchenController/getAllMenuTypes/');
  }

  updateOrder(api: KitchenService, id: number) {
    return this.http.post(this.url + 'kitchen/KitchenController/update/' + id, api);
  }
}
