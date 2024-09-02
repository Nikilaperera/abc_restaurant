import { Component, Input, HostListener, OnInit } from '@angular/core';
import { userItems } from './header-dummy-data';
import { Router } from '@angular/router';
import { LoginApiService } from '../pages/login/services/login-api.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit {

  ngOnInit(): void {
    this.checkCanShowSearchAsOverlay(window.innerWidth)
  }
  constructor(

    private api: LoginApiService,
    private router:Router

  ) { }
  @Input() collapsed = false;
  @Input() screenWidth = 0;

  userItems = userItems;

  canShowSearchAsOverlay = false;

  @HostListener('window:resize', ['$event'])
  onResize(event: any) {
    this.checkCanShowSearchAsOverlay(window.innerWidth)

  }
  getHeadClass(): string {
    let styleClass = '';
    if (this.collapsed && this.screenWidth > 768) {
      styleClass = 'head-trimmed';

    } else {
      styleClass = 'head-md-screen';
    }
    return styleClass;

  }
  checkCanShowSearchAsOverlay(innserWidth: number) {
    if (innserWidth < 845) {
      this.canShowSearchAsOverlay = true;
    } else {
      this.canShowSearchAsOverlay = false;
    }
  }

  logout(){

      localStorage.removeItem('token');
      this.router.navigateByUrl('auth/login');

  }

}
