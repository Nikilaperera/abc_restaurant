import { Component } from '@angular/core';
import { map } from 'rxjs/operators';
import { Breakpoints, BreakpointObserver } from '@angular/cdk/layout';
import { MatDialog } from '@angular/material/dialog';
import { ChartDataset, ChartType, ChartOptions } from 'chart.js';
import { DashboardService } from '../services/dashboard.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss'],
})
export class DashboardComponent {
  /** Based on the screen size, switch from standard to one column per row */
  cards = this.breakpointObserver.observe(Breakpoints.Handset).pipe(
    map(({ matches }) => {
      if (matches) {
        return [
          { title: 'Card 1', cols: 1, rows: 1 },
          { title: 'Card 2', cols: 1, rows: 1 },
          { title: 'Card 3', cols: 1, rows: 2 },
          { title: 'Card 4', cols: 1, rows: 1 },
        ];
      }

      return [
        { title: 'Card 1', cols: 2, rows: 1 },
        { title: 'Card 2', cols: 1, rows: 1 },
        { title: 'Card 3', cols: 1, rows: 2 },
        { title: 'Card 4', cols: 1, rows: 1 },
      ];
    })
  );

  public pieChartLabels: string[] = ['Pending Orders', 'Preparing Orders', 'Complted Orders', 'Canceled Orders '];
  public pieChartData: ChartDataset[] = [
    {
      data: [300, 500, 100, 200],
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#FF4500'],
    },
  ];
  public pieChartType: ChartType = 'pie';
  public filteredPieChartLabels: string[] = this.pieChartLabels;
  public filteredPieChartData: ChartDataset[] = this.pieChartData;

  public BarChartLabels: string[] = ['January', 'February', 'March', 'April'];
  public BarChartData: ChartDataset[] = [
    {
      data: [65, 59, 80, 81],
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
    },
  ];
  public filteredbarChartLabels: string[] = this.BarChartLabels;
  public filteredBarChartData: ChartDataset[] = this.BarChartData;

  public BarChartLabels1: string[] = ['2020', '2021', '2022', '2023'];
  public BarChartData1: ChartDataset[] = [
    {
      data: [50, 100, 150, 200],
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
    },
  ];
  public filteredbarChartLabels1: string[] = this.BarChartLabels1;
  public filteredBarChartData1: ChartDataset[] = this.BarChartData1;

  constructor(private breakpointObserver: BreakpointObserver, public dialog: MatDialog, private api: DashboardService) {}

  ngOnInit(): void {
    // You can fetch dynamic data here if needed.
    // For static data, it has already been set in the variables above.
  }

  public pieChartOptions: ChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'right',
        labels: {
          boxWidth: 12,
          font: {
            size: 10,
          },
        },
      },
    },
  };

  public barChartOptions: ChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false,
      },
    },
    scales: {
      x: {
        grid: {
          display: false,
        },
        ticks: {
          font: {
            size: 14,
            weight: 'bold',
          },
        },
      },
      y: {
        beginAtZero: true,
        grid: {
          color: 'rgba(0, 0, 0, 0.1)',
        },
        ticks: {
          font: {
            size: 14,
            weight: 'bold',
          },
          stepSize: 5,
        },
      },
    },
  };

  public barChartOptions1: ChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false,
      },
    },
    scales: {
      x: {
        grid: {
          display: false,
        },
        ticks: {
          font: {
            size: 14,
            weight: 'bold',
          },
        },
      },
      y: {
        beginAtZero: true,
        grid: {
          color: 'rgba(0, 0, 0, 0.1)',
        },
        ticks: {
          font: {
            size: 14,
            weight: 'bold',
          },
          stepSize: 5,
        },
      },
    },
  };
}
