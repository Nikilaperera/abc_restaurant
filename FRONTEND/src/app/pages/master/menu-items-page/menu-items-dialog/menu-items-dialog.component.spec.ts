import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MenuItemsDialogComponent } from './menu-items-dialog.component';

describe('MenuItemsDialogComponent', () => {
  let component: MenuItemsDialogComponent;
  let fixture: ComponentFixture<MenuItemsDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MenuItemsDialogComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MenuItemsDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
