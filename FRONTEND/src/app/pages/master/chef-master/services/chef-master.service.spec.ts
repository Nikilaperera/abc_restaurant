import { TestBed } from '@angular/core/testing';

import { ChefMasterService } from './chef-master.service';

describe('ChefMasterService', () => {
  let service: ChefMasterService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ChefMasterService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
