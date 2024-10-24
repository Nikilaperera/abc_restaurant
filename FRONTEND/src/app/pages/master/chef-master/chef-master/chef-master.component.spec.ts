import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ChefMasterComponent } from './chef-master.component';

describe('ChefMasterComponent', () => {
  let component: ChefMasterComponent;
  let fixture: ComponentFixture<ChefMasterComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ChefMasterComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ChefMasterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
