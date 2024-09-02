import { Component } from '@angular/core';
interface SideNavToggle{
  screenWidth:number;
  collapsed:boolean;

}
@Component({
  selector: 'app-user-layout',
  templateUrl: './user-layout.component.html',
  styleUrls: ['./user-layout.component.scss']
})
export class UserLayoutComponent {
  isSideNavCollapsed = false;
  screenWidth =0;

  onToggleSideNav(data:SideNavToggle): void{
    this.screenWidth = data.screenWidth;
    this.isSideNavCollapsed = data.collapsed;

  }
}
