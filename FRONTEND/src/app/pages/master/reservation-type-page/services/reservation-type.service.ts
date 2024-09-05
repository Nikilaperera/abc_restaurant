import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs/internal/Observable';
import { environment } from 'src/enviroments/enviroment';

@Injectable({
  providedIn: 'root'
})
export class ReservationTypeService {

  constructor(private http: HttpClient) {}

  url = environment.apiUrl;

  getReservationTypes() {
    return this.http.get<any>(
      this.url + 'master/ReservationTypeController/'
    );
  }

  deleteReservationTypes(id: number) {
    return this.http.delete(
      this.url + 'master/ReservationTypeController/delete/' + id
    );
  }

  postReservationType(api: ReservationTypeService) {
    console.log(api);
    return this.http.post(
      this.url + 'master/ReservationTypeController/add',
      api
    );
  }
}
