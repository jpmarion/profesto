import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { JornadaLaboralComponent } from './jornada-laboral.component';

describe('JornadaLaboralComponent', () => {
  let component: JornadaLaboralComponent;
  let fixture: ComponentFixture<JornadaLaboralComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ JornadaLaboralComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(JornadaLaboralComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
