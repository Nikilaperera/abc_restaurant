import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ReservationTypeDialogComponent } from './reservation-type-dialog.component';

describe('ReservationTypeDialogComponent', () => {
  let component: ReservationTypeDialogComponent;
  let fixture: ComponentFixture<ReservationTypeDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ReservationTypeDialogComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ReservationTypeDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
