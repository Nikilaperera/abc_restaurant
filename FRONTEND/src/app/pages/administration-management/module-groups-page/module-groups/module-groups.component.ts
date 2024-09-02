import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, FormArray, FormControl } from '@angular/forms';
import { ModuleGroupsService } from '../services/module-groups.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-module-groups',
  templateUrl: './module-groups.component.html',
  styleUrls: ['./module-groups.component.scss'],
})
export class ModuleGroupsComponent implements OnInit {
  moduleGroupsForm!: FormGroup;
  isChecked: boolean = false;
  groupsList: any[] = [];
  usersList: any[] = [];
  sectionsList: any[] = [];
  moduleList: any[] = [];
  permissionList: any[] = [];

  hasViewAccess: boolean = false;

  // section = new FormControl('');
  // groups = new FormControl('');
  // module = new FormControl('');
  constructor(private fb: FormBuilder, private api: ModuleGroupsService) {}

  ngOnInit(): void {
    const moduleId = 122;
    this.api.getModulePermission(moduleId).subscribe((permission) => {
      this.hasViewAccess = permission.some((permission: any) => permission.view_access === 'Yes');
    });

    this.getGroups();
    this.getUsers();
    this.getSections();
    this.getModules();
    this.getPermissions();

    this.moduleGroupsForm = this.fb.group({
      groups: [''],
      section: [''],
      module: [''],
    });
  }

  getGroups() {
    this.api.getGroups().subscribe((res) => {
      this.groupsList = res;
    });
  }

  getUsers() {
    this.api.getUsers().subscribe((res) => {
      this.usersList = res;
    });
  }

  getSections() {
    this.api.getSections().subscribe((res) => {
      this.sectionsList = res;
    });
  }

  getModules() {
    this.api.getModules().subscribe((res) => {
      this.moduleList = res;
    });
  }

  getPermissions() {
    this.api.getPermissions().subscribe({
      next: (res) => {
        this.permissionList = res;
      },
      error: (err) => {},
    });
  }

  getCheckboxState(groupId: number, moduleId: number): boolean {
    const permission = this.permissionList.find((i) => i.group_id === groupId && i.module_id === moduleId);
    if (permission) {
      return true;
    }
    return false;
  }

  onCheckboxChange(event: any, group: number, module: number) {
    var formData: any = new FormData();
    formData.append('event', event.checked);
    formData.append('group', group);
    formData.append('module', module);
    this.api.updatePermissions(formData).subscribe({
      next: (res) => {
        this.getPermissions();
      },
      error: (res) => {
        this.getPermissions();
        Swal.fire('Error while changing permissions.');
      },
    });
  }
}
