import { Component } from '@angular/core';
import { map } from 'rxjs/operators';
import { Breakpoints, BreakpointObserver } from '@angular/cdk/layout';
import { FormControl } from '@angular/forms';
import { MatDatepickerInputEvent } from '@angular/material/datepicker';
import { MatDialog } from '@angular/material/dialog';
import { ChartDataset, ChartType, ChartOptions } from 'chart.js';
import { DashboardService } from '../services/dashboard.service';
import { hide } from '@popperjs/core';

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
          { title: 'Card 3', cols: 1, rows: 1 },
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

  public pieChartLabels: string[] = [];
  public pieChartData: ChartDataset[] = [];
  public pieChartType: ChartType = 'pie';
  public filteredPieChartLabels: string[] = [];
  public filteredPieChartData: ChartDataset[] = [];

  // barchart1
  public BarChartLabels: string[] = [];
  public BarChartData: ChartDataset[] = [];
  public barChartType: ChartType = 'bar';
  public filteredbarChartLabels: string[] = [];
  public filteredBarChartData: ChartDataset[] = [];

  // barchart1
  public BarChartLabels1: string[] = [];
  public BarChartData1: ChartDataset[] = [];
  public barChartType1: ChartType = 'bar';
  public filteredbarChartLabels1: string[] = [];
  public filteredBarChartData1: ChartDataset[] = [];

  constructor(private breakpointObserver: BreakpointObserver, public dialog: MatDialog, private api: DashboardService) {}

  ngOnInit(): void {
    this.api.pieChartDatasets$.subscribe((datasets: ChartDataset[]) => {
      // this.pieChartData = datasets;
      this.filteredPieChartData = datasets;
    });

    this.api.pieChartLabels$.subscribe((labels: string[]) => {
      // this.pieChartLabels = labels;
      this.filteredPieChartLabels = labels;
    });

    this.api.getMembershipData().subscribe(
      (data: any[]) => {
        console.log(data);
        this.pieChartLabels = data.map((item) => item.name);
        const chartData: number[] = data.map((item) => item.count);
        // this.filteredPieChartLabels = data.map((item) => item.name);
        // const createdDates: Date[] = data.map((item) => new Date(item.created_at));
        // const updatedDates: Date[] = data.map((item) => new Date(item.updated_at));

        // Filter the chart data based on the start and end dates
        // const filteredChartData = this.filterChartDataByDate(chartData);

        this.pieChartData = [
          {
            data: chartData,
            backgroundColor: ['#0091ea', '#00b0ff', '#40c4ff', '#80d8ff', '#01579b','#0277bd','#0288d1','#039be5','#03a9f4','#29b6f6'],
          },
        ];

        // Initialize filtered chart data with all data
        this.filteredPieChartLabels = this.pieChartLabels;
        this.filteredPieChartData = this.pieChartData;
      },
      (error: any) => {
        console.error('Error retrieving student registration data:', error);
      }
    );

    this.filteredPieChartLabels = this.pieChartLabels;
    this.filteredPieChartData = this.pieChartData;

    // barchart
    this.api.barChartDatasets$.subscribe((datasets: ChartDataset[]) => {
      // this.barChartData = datasets;
      this.filteredBarChartData = datasets;
    });

    this.api.barChartLabels$.subscribe((labels: string[]) => {
      // this.barChartLabels = labels;
      this.filteredbarChartLabels = labels;
    });

    this.api.getProgramApplicationData().subscribe(
      (data: any[]) => {
        console.log(data);
        this.BarChartLabels = data.map((item) => item.date);
        const chartData: number[] = data.map((item) => item.count);
        // this.filteredbarChartLabels = data.map((item) => item.name);
        // const createdDates: Date[] = data.map((item) => new Date(item.created_at));
        // const updatedDates: Date[] = data.map((item) => new Date(item.updated_at));

        // Filter the chart data based on the start and end dates
        // const filteredChartData = this.filterChartDataByDate(chartData);

        this.BarChartData = [
          {
            data: chartData,
            backgroundColor: ['#0091ea', '#00b0ff', '#40c4ff', '#80d8ff', '#01579b','#0277bd','#0288d1','#039be5','#03a9f4','#29b6f6'],
          },
        ];

        // Initialize filtered chart data with all data
        this.filteredbarChartLabels = this.BarChartLabels;
        this.filteredBarChartData = this.BarChartData;
      },
      (error: any) => {
        console.error('Error retrieving student registration data:', error);
      }
    );

    this.filteredbarChartLabels = this.BarChartLabels;
    this.filteredBarChartData = this.BarChartData;
    // barchart end

    // barchart1
    this.api.barChartDatasets1$.subscribe((datasets: ChartDataset[]) => {
      // this.barChartData = datasets;
      this.filteredBarChartData1 = datasets;
    });

    this.api.barChartLabels1$.subscribe((labels: string[]) => {
      // this.barChartLabels = labels;
      this.filteredbarChartLabels1 = labels;
    });

    this.api.getRegisterdStudentData().subscribe(
      (data: any[]) => {
        console.log(data);
        this.BarChartLabels1 = data.map((item) => item.date);
        const chartData: number[] = data.map((item) => item.count);
        // this.filteredbarChartLabels1 = data.map((item) => item.name);
        // const createdDates: Date[] = data.map((item) => new Date(item.created_at));
        // const updatedDates: Date[] = data.map((item) => new Date(item.updated_at));

        // Filter the chart data based on the start and end dates
        // const filteredChartData = this.filterChartDataByDate(chartData);

        this.BarChartData1 = [
          {
            data: chartData,
            backgroundColor: ['#0091ea', '#00b0ff', '#40c4ff', '#80d8ff', '#01579b','#0277bd','#0288d1','#039be5','#03a9f4','#29b6f6'],
          },
        ];

        // Initialize filtered chart data with all data
        this.filteredbarChartLabels1 = this.BarChartLabels1;
        this.filteredBarChartData1 = this.BarChartData1;
      },
      (error: any) => {
        console.error('Error retrieving student registration data:', error);
      }
    );

    this.filteredbarChartLabels1 = this.BarChartLabels1;
    this.filteredBarChartData1 = this.BarChartData1;
    // barchart end
  }

  // getMembershipData() {
  //   this.api.getMembershipData().subscribe(
  //     (response: any[]) => {
  //       this.districts = response.map((district) => ({
  //         ...district,
  //         province: district.province // Add the 'province' property
  //       }));
  //     },
  //     (error: any) => {
  //       console.error('Error retrieving district data:', error);
  //     }
  //   );
  // }
  public pieChartOptions: ChartOptions = {
    responsive: true,
    maintainAspectRatio: false,

    plugins: {
      legend: {
        position: 'right', // Position the legend on the right side

        align: 'center', // Align the legend to the start of the specified position
        labels: {
          boxWidth: 12, // fontSize:20,// Adjust the box width of the legend items
          font: {
            size: 10, // Set the font size of the labels on the chart
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
          // callback: (value: any) => Math.round(value),
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
