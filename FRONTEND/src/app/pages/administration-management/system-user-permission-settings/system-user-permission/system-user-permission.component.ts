import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { SystemusersApiService } from '../../systemusers-page/services/systemusers-api.service';
import { UserInteractionLoggerService } from '../../../../user-interaction-logger.service';
import { Observable, of } from 'rxjs';
import { map, startWith } from 'rxjs/operators';

@Component({
  selector: 'app-system-user-permission',
  templateUrl: './system-user-permission.component.html',
  styleUrls: ['./system-user-permission.component.scss'],
})
export class SystemUserPermissionComponent implements OnInit {
  myForm!: FormGroup;
  groupsList: any[] = [];
  filteredGroups: Observable<any[]> = new Observable<any[]>();
  usersList: any[] = [];
  sectionsList: any[] = [];
  moduleList: any[] = [];
  permissionList: any[] = [];
  hasViewAccess: boolean = false;

  constructor(
    private fb: FormBuilder,
    private api: SystemusersApiService,
    private logger: UserInteractionLoggerService
  ) {}

  ngOnInit(): void {
    const moduleId = 122;
    this.api.getModulePermission(moduleId).subscribe((permission) => {
      this.hasViewAccess = permission.some((permission: any) => permission.view_access === 'Yes');
    });

    this.get_all_groups();
    this.get_all_users();
    this.get_all_sections();
    this.get_all_modules();
    this.get_all_permissions();

    this.myForm = this.fb.group({
      groups: [''],
      section: [''],
      module: [''],
      view_access: [''],
      add_access: [''],
      edit_access: [''],
      delete_access: [''],
      approve_access: [''],
      approve_access_2: [''],
      approve_access_3: [''],

    });

    const groupsControl = this.myForm.get('groups');
    if (groupsControl) {
      this.filteredGroups = groupsControl.valueChanges.pipe(
        startWith(''),
        map(value => this._filter(value))
      );

      groupsControl.valueChanges.subscribe((selectedGroup) => {
        this.updateCheckboxValues(selectedGroup);
        // Dynamically update the filteredGroups based on the selectedGroup
        const filteredGroupsArray = this._filter(selectedGroup);
        this.filteredGroups = of(filteredGroupsArray);
      });
    }
  }

  private _filter(value: string): any[] {
    const filterValue = value.toLowerCase();
    return this.groupsList.filter(group => group.name.toLowerCase().includes(filterValue));
  }

  get_all_groups() {
    this.api.getAllGroups().subscribe((res) => {
      this.groupsList = res;
    });
  }

  get_all_users() {
    this.api.getAllPermissionUsers().subscribe((res) => {
      this.usersList = res;
    });
  }

  get_all_sections() {
    this.api.getAllSections().subscribe((res) => {
      this.sectionsList = res;
    });
  }

  get_all_modules() {
    this.api.getAllModules().subscribe((res) => {
      this.moduleList = res;
    });
  }

  get_all_permissions() {
    this.api.getAllpermissions().subscribe({
      next: (res) => {
        this.permissionList = res;
      },
      error: (err) => {},
    });
  }

  getCheckboxState(group: any, moduleId: string, permissionType: string): boolean {
    if (group) {
      const permission = this.permissionList.find((p) => p.group_id === group.id && p.module_id === moduleId);
      if (permission) {
        return permission[`${permissionType}_access`] === 'Yes';
      }
    }
    return false;
  }

  updateCheckboxValues(selectedGroup: any) {
    const groupId = selectedGroup ? selectedGroup.id : null;

    // Reset checkboxes to false
    this.myForm.patchValue({
      view_access: false,
      add_access: false,
      edit_access: false,
      delete_access: false,
      approve_access: false,
      approve_access_2: false,
      approve_access_3: false,
    });

    // Update checkboxes based on selected group
    this.permissionList.forEach((permission) => {
      if (permission.group_id === groupId) {
        this.myForm.patchValue({
          [`${permission.permission_type}_access`]: permission.access === 'Yes',
        });
      }
    });
  }

  onCheckboxChange(event: any, group: any, moduleId: string, access: any) {
    if (group && event.checked) {
      var formData: any = new FormData();
      formData.append('group', group.id);
      formData.append('module', moduleId);
      formData.append(`${access}_access`, 'Yes');

      this.api.add_permission_list(formData).subscribe({
        next: (res) => {},
        error: (res) => {
          this.get_all_permissions();
        },
      });
    } else if (group && !event.checked) {
      var formData: any = new FormData();
      formData.append('group', group.id);
      formData.append('module', moduleId);
      formData.append(`${access}_access`, 'No');

      this.api.add_permission_list(formData).subscribe({
        next: (res) => {},
        error: (res) => {
          this.get_all_permissions();
        },
      });
    }
  }

  _displayFn(group: any): string {
    return group && typeof group === 'object' ? group.name : group;
  }
}





