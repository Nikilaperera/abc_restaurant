import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/enviroments/enviroment';

@Injectable({
  providedIn: 'root'
})
export class UserInteractionLoggerService {
  data:any;
  url = environment.apiUrl;
  constructor(private http: HttpClient) {
  }
  get_logged_user() {
    this.data =this.http.get<any>(this.url + "auth/Auth/get_login_user");
   // Swal.fire(JSON.stringify(this.data));
    return this.data;
  }

  logAction(action: string,) {
    // const data=JSON.stringify(this.get_logged_user());
    const message = {
      username:'admin',
      action,

      timestamp: new Date().toISOString()
    };

    console.log("system log :" + (JSON.stringify(message)));
    // Send the message to the backend via an HTTP request
    // this.http.post('/api/log', message).subscribe(
    //   () => console.log(`Logged action: ${action}`),
    //   (error) => console.error(`Error logging action: ${action}`, error)
    // );
  }
}
