import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SystemusersComponent } from './systemusers.component';

describe('SystemusersComponent', () => {
  let component: SystemusersComponent;
  let fixture: ComponentFixture<SystemusersComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SystemusersComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SystemusersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
