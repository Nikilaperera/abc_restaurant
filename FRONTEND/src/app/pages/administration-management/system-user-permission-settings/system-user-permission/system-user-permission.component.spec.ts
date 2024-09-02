import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SystemUserPermissionComponent } from './system-user-permission.component';

describe('SystemUserPermissionComponent', () => {
  let component: SystemUserPermissionComponent;
  let fixture: ComponentFixture<SystemUserPermissionComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SystemUserPermissionComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SystemUserPermissionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
