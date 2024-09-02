import { TestBed } from '@angular/core/testing';

import { SystemusersApiService } from './systemusers-api.service';

describe('SystemusersApiService', () => {
  let service: SystemusersApiService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(SystemusersApiService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
