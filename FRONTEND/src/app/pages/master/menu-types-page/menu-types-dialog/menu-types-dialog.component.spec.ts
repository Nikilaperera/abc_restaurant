import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MenuTypesDialogComponent } from './menu-types-dialog.component';

describe('MenuTypesDialogComponent', () => {
  let component: MenuTypesDialogComponent;
  let fixture: ComponentFixture<MenuTypesDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MenuTypesDialogComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MenuTypesDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
