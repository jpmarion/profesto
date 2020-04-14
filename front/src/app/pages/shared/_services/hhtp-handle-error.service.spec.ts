import { TestBed } from '@angular/core/testing';

import { HhtpHandleErrorService } from './hhtp-handle-error.service';

describe('HhtpHandleErrorService', () => {
  let service: HhtpHandleErrorService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(HhtpHandleErrorService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
