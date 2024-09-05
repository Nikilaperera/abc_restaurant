import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/enviroments/enviroment';
import { Observable, map } from 'rxjs';
import { INavbarData } from '../helper';

@Injectable({
  providedIn: 'root'
})
export class ServiceApiService {

  constructor(private http: HttpClient) { }

  url = environment.apiUrl;

  getNavbarData(): Observable<INavbarData[]> {
    return this.http.get<any[]>(
      this.url + 'navbar/NavbarDataController/fetch_data_endpoint/'
      ).pipe( map(data => this.mapToNavbarData(data)) );
  }

  private mapToNavbarData(data: any[]): INavbarData[] {
    const groupedData: INavbarData[] = [];

    data.forEach((item) => {
      const group: INavbarData = {
        routerLink: '',
        icon: item.icon,
        label: item.title,
        items: [],
      };

      // const programGroup: INavbarData = {
      //   routerLink: '',
      //   icon: '',
      //   label: 'Program Master',
      //   items: [],
      // };

      const mortgageGroup: INavbarData = {
        routerLink: '',
        icon: '',
        label: 'Master',
        items: [],
      };

      item.items.forEach((subItem: any) => {
        const includedItems = [
          'Title','Menu Types','Reservation Types'
        ];



        if (includedItems.includes(subItem.name)) {
          if (!mortgageGroup.items) {
            mortgageGroup.items = [];
          }
          mortgageGroup.items.push({
            routerLink: subItem.path,
            label: subItem.name,
          });
        } else {
          if (!group.items) {
            group.items = [];
          }
          group.items.push({
            routerLink: subItem.path,
            label: subItem.name,
          });
        }

        if (subItem.name === 'Dashboard' && item.title === 'Dashboard') {
          group.routerLink = subItem.path;
        }
      });

      if (mortgageGroup.items && mortgageGroup.items.length > 0) {
        group.items?.unshift(mortgageGroup);
      }

      groupedData.push(group);
    });

    return groupedData;
  }

}
