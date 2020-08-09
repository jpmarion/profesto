import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AccesoDirectoComponent } from './acceso-directo.component';

describe('AccesoDirectoComponent', () => {
  let component: AccesoDirectoComponent;
  let fixture: ComponentFixture<AccesoDirectoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AccesoDirectoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AccesoDirectoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
