import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ChefDialogComponent } from './chef-dialog.component';

describe('ChefDialogComponent', () => {
  let component: ChefDialogComponent;
  let fixture: ComponentFixture<ChefDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ChefDialogComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ChefDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
