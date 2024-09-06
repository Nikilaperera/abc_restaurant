import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/enviroments/enviroment';

@Injectable({
  providedIn: 'root'
})
export class MenuItemsService {

  constructor(private http: HttpClient) {};

  url = environment.apiUrl;

  postMenuItem(api: MenuItemsService) {
    console.log(api);
    return this.http.post(this.url + "master/MenuItemController/add/", api);
  }

  getAllMenuTypes() {
    return this.http.get<any>(this.url + "master/MenuItemController/getMenuTypes/");
  }

  updateMenuItem(api: MenuItemsService, id: number) {
    return this.http.post(this.url + "master/MenuItemController/update/" + id, api);
  }

  getMenuItems() {
    return this.http.get<any>(this.url + "master/MenuItemController/");
  }

  deleteMenuItems(id: number) {
    return this.http.delete(this.url + "master/MenuItemController/delete/" + id);
  }
}
