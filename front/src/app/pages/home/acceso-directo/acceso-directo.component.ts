import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-acceso-directo',
  templateUrl: './acceso-directo.component.html',
  styleUrls: ['./acceso-directo.component.scss']
})
export class AccesoDirectoComponent implements OnInit {

  constructor(
    private router: Router
  ) { }

  ngOnInit(): void {
  }
}
