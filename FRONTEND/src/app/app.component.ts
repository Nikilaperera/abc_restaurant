import { Component, HostListener, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = 'abc_restaurant';
  lastActivityTime!: number;
  constructor( private router: Router) { }

  ngOnInit() {
    this.lastActivityTime = Date.now();
    setInterval(() => {
      this.checkTokenTimeout();
    }, 10000); // Check every 10 seconds
  }

  @HostListener('document:mousemove', ['$event'])
  @HostListener('document:keypress', ['$event'])
  onUserActivity() {
    this.lastActivityTime = Date.now();
  }
  checkTokenTimeout() {

    const token = localStorage.getItem('token');
    const timestamp = localStorage.getItem('timestamp');

    if (token && timestamp) {
      const currentTime = Date.now();
      const timeout = 3600000; // 1 hour

     if (
        currentTime - parseInt(timestamp, 10) > timeout &&
        currentTime - this.lastActivityTime > timeout
      ) {
        localStorage.removeItem('token');
        localStorage.removeItem('timestamp');
        this.router.navigate(['/login']);
      }
    }
  }
}

