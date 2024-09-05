import { TestBed } from '@angular/core/testing';

import { ReservationTypeService } from './reservation-type.service';

describe('ReservationTypeService', () => {
  let service: ReservationTypeService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ReservationTypeService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
