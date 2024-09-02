import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SystemLogTableComponent } from './system-log-table.component';

describe('SystemLogTableComponent', () => {
  let component: SystemLogTableComponent;
  let fixture: ComponentFixture<SystemLogTableComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SystemLogTableComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SystemLogTableComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
