import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs/internal/Observable';
import { environment } from 'src/enviroments/enviroment';

@Injectable({
  providedIn: 'root'
})
export class MenuTypesService {

  constructor(private http: HttpClient) {}

  url = environment.apiUrl;

  postMenuTypes(api: MenuTypesService) {
    console.log(api);
    return this.http.post(
      this.url + 'master/MenuTypeController/add',
      api
    );
  }

  getMenuTypes() {
    return this.http.get<any>(
      this.url + 'master/MenuTypeController/'
    );
  }

  updateMenuTypes(api: MenuTypesService, id: number) {
    return this.http.post(
      this.url + 'master/MenuTypeController/update/' + id,
      api
    );
  }

  deleteMenuTypes(id: number) {
    return this.http.delete(
      this.url + 'master/MenuTypeController/delete/' + id
    );
  }

  getModulePermission( moduleId: number) {
    return this.http.get<any>(
      this.url + 'navbar/NavbarDataController/permissions/' + moduleId
    )
  }
}
