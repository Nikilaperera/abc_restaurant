import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/enviroments/enviroment';
import { BehaviorSubject } from 'rxjs';
import { ChartDataset as CustomChartDataset } from 'chart.js';

interface ChartDataset {
  data: number[];
  backgroundColor?: string | string[];
  borderColor?: string | string[];
  borderWidth?: number;
  label?: string;
}

@Injectable({
  providedIn: 'root'
})
export class DashboardService {

  constructor(private http: HttpClient) { }
  url = environment.apiUrl;

  getMembershipData() {
    return this.http.get<any[]>(
      this.url + 'dashboard/DashboardController/getMembershipData/'
    );
  }

  getProgramApplicationData() {
    return this.http.get<any[]>(
      this.url + 'dashboard/DashboardController/getProgramApplicationData/'
    );
  }

  getRegisterdStudentData() {
    return this.http.get<any[]>(
      this.url + 'dashboard/DashboardController/getRegisterdStudentData/'
    );
  }

  private pieChartDatasetsSource = new BehaviorSubject<CustomChartDataset[]>([]);
  private pieChartLabelsSource = new BehaviorSubject<string[]>([]);

  pieChartDatasets$ = this.pieChartDatasetsSource.asObservable();
  pieChartLabels$ = this.pieChartLabelsSource.asObservable();

  updateChartData(datasets: CustomChartDataset[], labels: string[]) {
    this.pieChartDatasetsSource.next(datasets);
    this.pieChartLabelsSource.next(labels);
  }

  // barchart
  private barChartDatasetsSource = new BehaviorSubject<CustomChartDataset[]>([]);
  private barChartLabelsSource = new BehaviorSubject<string[]>([]);

  barChartDatasets$ = this.barChartDatasetsSource.asObservable();
  barChartLabels$ = this.barChartLabelsSource.asObservable();

  updateBarChartData(datasets: CustomChartDataset[], labels: string[]) {
    this.barChartDatasetsSource.next(datasets);
    this.barChartLabelsSource.next(labels);
  }

  // barchart1
  private barChartDatasetsSource1 = new BehaviorSubject<CustomChartDataset[]>([]);
  private barChartLabelsSource1 = new BehaviorSubject<string[]>([]);

  barChartDatasets1$ = this.barChartDatasetsSource1.asObservable();
  barChartLabels1$ = this.barChartLabelsSource1.asObservable();

  updateBarChartData1(datasets: CustomChartDataset[], labels: string[]) {
    this.barChartDatasetsSource1.next(datasets);
    this.barChartLabelsSource1.next(labels);
  }
}
