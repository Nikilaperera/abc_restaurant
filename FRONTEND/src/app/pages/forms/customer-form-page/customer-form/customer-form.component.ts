import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CustomerFormService} from "../../services/customer-form.service";

@Component({
  selector: 'app-customer-form',
  templateUrl: './customer-form.component.html',
  styleUrls: ['./customer-form.component.scss']
})
export class CustomerFormComponent implements OnInit{

  customerOrderForm!: FormGroup;
  actionBtn: string = "Save";
  tablesList: any[] =[];
  menuTypeList: any[] =[];
  menuItemList: any[] =[];

  constructor(
    private formBuilder: FormBuilder,
    private api: CustomerFormService,
    // @Inject(MAT_DIALOG_DATA) public editData: any
  ) { }

  ngOnInit(): void {

  this.get_all_tables();
  this.get_all_menu_types();
  this.get_all_menu_items();

    this.customerOrderForm = this.formBuilder.group({

      applicationcode: ['', Validators.required],
      programname: ['', Validators.required],
      fdate: ['', Validators.required],
      tdate: ['', Validators.required],

      title: ['', Validators.required],
      namewithini: ['', Validators.required],
      fullname: ['', Validators.required],
      nic: ['', Validators.required],

      address: ['', Validators.required],
      phone: ['', Validators.required],
      mobile: ['', Validators.required],
      email: [''],

      reason: [''],

    });
  }

  private get_all_tables() {
    this.api.getAllTables().subscribe((res) => {
      this.tablesList = res;
      console.log(res);
    });
  }

  private get_all_menu_types() {
    this.api.getAllMenuTypes().subscribe((res) => {
      this.menuTypeList = res;
      console.log(res);
    });
  }

  private get_all_menu_items() {
    this.api.getAllMenuItems().subscribe((res) => {
      this.menuItemList = res;
      console.log(res);
    });
  }
}
