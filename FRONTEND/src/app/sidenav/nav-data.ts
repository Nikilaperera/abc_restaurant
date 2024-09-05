import { INavbarData } from './helper';
export const navbarData: INavbarData[] = [
  {
    routerLink: '',
    icon: 'fa-sharp fa-solid fa-house',
    label: 'Dashboard',
    items: [
      {
        routerLink: 'dashboard',
        label: 'Dashboard',
      },
    ],
  },
  {
    routerLink: '',
    icon: 'fa-solid fa-database',
    label: ' Master',
    items: [
      {
        routerLink: 'title',
        label: 'Title',
      },{
        routerLink: 'menu-types',
        label: 'Menu Types',
      },{
        routerLink: 'reservation-types',
        label: 'Reservation Types',
      },{
        routerLink: 'tables',
        label: 'Tables',
      },

    ],
  }
];
