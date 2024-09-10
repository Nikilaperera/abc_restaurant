import { ComponentFixture, TestBed } from '@angular/core/testing';

import { KitchenDialogComponent } from './kitchen-dialog.component';

describe('KitchenDialogComponent', () => {
  let component: KitchenDialogComponent;
  let fixture: ComponentFixture<KitchenDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ KitchenDialogComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(KitchenDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
