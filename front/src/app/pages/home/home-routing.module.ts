import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { HomeComponent } from './home.component';

import { AuthGuard } from '../auth/_guards/auth.guard';
import { EmpleadosComponent } from './empleados/empleados.component';
import { JornadaLaboralComponent } from './jornada-laboral/jornada-laboral.component';
import { MensajesComponent } from './mensajes/mensajes.component';

const routes: Routes = [
  {
    path: 'home',
    component: HomeComponent,
    canActivate: [AuthGuard],
    children: [
      { path: '', redirectTo: 'empleados', pathMatch: 'full' },
      { path: 'empleados', component: EmpleadosComponent },
      { path: 'jornada-laboral', component: JornadaLaboralComponent },
      { path: 'mensajes', component: MensajesComponent }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class HomeRoutingModule { }
