import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditMenuTypesComponent } from './edit-menu-types.component';

describe('EditMenuTypesComponent', () => {
  let component: EditMenuTypesComponent;
  let fixture: ComponentFixture<EditMenuTypesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ EditMenuTypesComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EditMenuTypesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
