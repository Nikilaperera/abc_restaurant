import { Component, Input, OnInit } from '@angular/core';
import { INavbarData } from '../helper';
import { trigger, style, state, transition, animate } from '@angular/animations';
import { ServiceApiService } from '../services/service-api.service';

@Component({
  selector: 'app-sublevel-menu',
  templateUrl: './sublevel-menu.component.html',

  styleUrls: ['./sublevel-menu.component.scss'],
  animations: [
    trigger('submenu',[
      state('hidden',style({
        height:'0',
        overflow:'hidden'
      })),
      state('visible',style({
        height:'*'
      })),
      transition('visible <=> hidden',[style({overflow:'hidden'}),
      animate('{{transitionParams}}')]),
      transition('* => void',animate(0))
    ]),
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
  ]
})
export class SublevelMenuComponent implements OnInit{

  @Input() data: INavbarData = {
    routerLink: '',
    icon: '',
    label: '',
    items: [],

  }

  navData: INavbarData[] = [];

  constructor(private serviceApiService: ServiceApiService) {}

  ngOnInit(): void {
    this.serviceApiService.getNavbarData().subscribe((data) => {
      this.navData = data;
    });
  }

  @Input() collapsed = false;
  @Input() animating!: boolean;
  @Input() expanded?: boolean;
  @Input() multiple: boolean =false;


  handleClick(item:any):void{
    if(!this.multiple){
      if(this.data.items && this.data.items.length> 0){
        for(let modelItem of this.data.items){
          if(item !==modelItem && modelItem.expanded){
            modelItem.expanded = false;

          }
        }
      }
    }
    item.expanded = !item.expanded;
  }

}
