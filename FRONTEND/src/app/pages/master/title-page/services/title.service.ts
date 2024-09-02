import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {environment} from 'src/enviroments/enviroment';

@Injectable({
  providedIn: 'root'
})
export class TitleService {

  url = environment.apiUrl;

  constructor(private http: HttpClient) {
  };

  postTitle(api: TitleService) {
    console.log(api);
    return this.http.post(this.url + "master/TitleController/add", api);
  }

  getTitle() {
    return this.http.get<any>(this.url + "master/TitleController/");
  }

  updateTitle(api: TitleService, id: number) {
    return this.http.post(this.url + "master/TitleController/update/" + id, api);
  }

  deletetitle(id: number) {
    return this.http.delete(this.url + "master/TitleController/delete/" + id);
  }

  getModulePermission(moduleId: number) {
    return this.http.get<any>(
      this.url + 'navbar/NavbarDataController/permissions/' + moduleId
    )
  }

}
