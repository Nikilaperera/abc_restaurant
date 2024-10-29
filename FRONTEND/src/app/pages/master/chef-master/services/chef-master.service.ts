import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { environment } from "src/enviroments/enviroment";

@Injectable({
  providedIn: "root"
})
export class ChefMasterService {

  constructor(private http: HttpClient) {}

  url = environment.apiUrl;

  postChef(api: ChefMasterService) {
    console.log(api);
    return this.http.post(
      this.url + "master/ChefMasterController/add", api);
  }

  getChef() {
    return this.http.get<any>(
      this.url + "master/ChefMasterController/");
  }

  updateChef(api: ChefMasterService, ID: number) {
    return this.http.post(
      this.url + "master/ChefMasterController/update/" + ID,
      api
    );
  }

  deleteChef(ID: number) {
    return this.http.delete(
      this.url + "master/ChefMasterController/delete/" + ID
    );
  }

  getModulePermission( moduleId: number) {
    return this.http.get<any>(
      this.url + "navbar/NavbarDataController/permissions/" + moduleId
    )
  }
}
