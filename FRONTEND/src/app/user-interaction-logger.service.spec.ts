import { TestBed } from '@angular/core/testing';

import { UserInteractionLoggerService } from './user-interaction-logger.service';

describe('UserInteractionLoggerService', () => {
  let service: UserInteractionLoggerService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(UserInteractionLoggerService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
