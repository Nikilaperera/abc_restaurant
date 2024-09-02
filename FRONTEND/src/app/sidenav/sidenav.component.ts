import { Component, EventEmitter, Output, OnInit, HostListener } from '@angular/core';
import { navbarData } from './nav-data';
import { trigger, style, transition, animate, keyframes } from '@angular/animations';
import { INavbarData } from './helper';
import { ServiceApiService } from './services/service-api.service';
import { Router } from '@angular/router';

interface SideNavToggle {
  screenWidth: number;
  collapsed: boolean;

}
@Component({
  selector: 'app-sidenav',
  templateUrl: './sidenav.component.html',
  styleUrls: ['./sidenav.component.scss'],
  animations: [
    trigger('fadeInOut', [
      transition(':enter', [
        style({ opacity: 0 }),
        animate('350ms', style({ opacity: 1 })
        )
      ]),
      transition(':leave', [
        style({ opacity: 1 }),
        animate('350ms', style({ opacity: 0 })
        )
      ]),
    ]),
    trigger('rotate', [
      transition(':enter', [
        animate('500ms',
          keyframes([
            style({ transform: 'rotate(0deg)', offset: '0' }),
            style({ transform: 'rotate(1turn)', offset: '1' }),
          ])
        )
      ]),
    ])
  ]
})
export class SidenavComponent implements OnInit {

  constructor(private serviceApiService: ServiceApiService, private router: Router) {}

  @Output() onToggleSideNav: EventEmitter<SideNavToggle> = new EventEmitter();
  collapsed = false;
  screenWidth = 0;
  navData: INavbarData[] = [];
  multiple : boolean= false;

  @HostListener('window:resize', ['$event'])
  onResize(event: any) {
    this.screenWidth = window.innerWidth;
    if (this.screenWidth <= 768) {
      this.collapsed = false;
      this.onToggleSideNav.emit({ collapsed: this.collapsed, screenWidth: this.screenWidth });

    }
  }
  ngOnInit(): void {
    this.screenWidth = window.innerWidth;
    this.serviceApiService.getNavbarData().subscribe((data) => {
      this.navData = data;
    });
  }
  toggleCollapse(): void {
    this.collapsed = !this.collapsed;
    this.onToggleSideNav.emit({ collapsed: this.collapsed, screenWidth: this.screenWidth });


  }
  closeSidenav(): void {
    this.collapsed = false;
    this.onToggleSideNav.emit({ collapsed: this.collapsed, screenWidth: this.screenWidth });

  }
  handleClick(item:INavbarData){
    if(!this.multiple){
      for(let modelItem of this.navData){
        if(item !==modelItem && modelItem.expanded){
          modelItem.expanded = false;

        }
      }
    }

    item.expanded = !item.expanded;
  }

  navigateToDashboardPath(data: INavbarData) {
    if (data.items) {
      const dashboardSubItem = data.items.find(item => item.label === 'Dashboard');
      if (dashboardSubItem) {
        this.router.navigate([dashboardSubItem.routerLink]);
      }
    }
  }

  getDashboardLink(data: INavbarData): string {
    if (data.items) {
      const dashboardSubItem = data.items.find(item => item.label === 'Dashboard');
      if (dashboardSubItem) {
        return dashboardSubItem.routerLink;
      }
    }
    return ''; // Return a default link or empty string if 'Dashboard' subItem not found
  }

}
