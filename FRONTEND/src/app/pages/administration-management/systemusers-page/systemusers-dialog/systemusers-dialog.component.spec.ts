import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SystemusersDialogComponent } from './systemusers-dialog.component';

describe('SystemusersDialogComponent', () => {
  let component: SystemusersDialogComponent;
  let fixture: ComponentFixture<SystemusersDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SystemusersDialogComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SystemusersDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
