import { TestBed } from '@angular/core/testing';

import { UserGroupsApiService } from './user-groups-api.service';

describe('UserGroupsService', () => {
  let service: UserGroupsApiService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(UserGroupsApiService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
