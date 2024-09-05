import { TestBed } from '@angular/core/testing';

import { MenuTypesService } from './menu-types.service';

describe('MenuTypesService', () => {
  let service: MenuTypesService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MenuTypesService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
