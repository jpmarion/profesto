import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { HomeRoutingModule } from './home-routing.module';
import { HomeComponent } from './home.component';
import { EmpleadosComponent } from './empleados/empleados.component';
import { JornadaLaboralComponent } from './jornada-laboral/jornada-laboral.component';
import { MensajesComponent } from './mensajes/mensajes.component';

import { LayoutModule } from '../../layout/layout.module';
import { AccesoDirectoComponent } from './acceso-directo/acceso-directo.component';

import { MatMenuModule } from '@angular/material/menu';
import { MatIconModule } from '@angular/material/icon';
import { MatCardModule } from '@angular/material/card';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatGridListModule } from '@angular/material/grid-list';
import { MatButtonModule } from '@angular/material/button';
import { MatButtonToggleModule } from '@angular/material/button-toggle';

import { TranslateLoader, TranslateModule } from '@ngx-translate/core';
import { TranslateHttpLoader } from '@ngx-translate/http-loader';
import { HttpClient } from '@angular/common/http';

export function HttpLoaderFactory(http: HttpClient) {
  return new TranslateHttpLoader(http);
}

@NgModule({
  declarations: [
    HomeComponent,
    AccesoDirectoComponent,
    EmpleadosComponent,
    JornadaLaboralComponent,
    MensajesComponent
  ],
  imports: [
    CommonModule,
    HomeRoutingModule,
    MatMenuModule,
    MatIconModule,
    MatCardModule,
    MatToolbarModule,
    LayoutModule,
    MatGridListModule,
    MatButtonModule,
    MatButtonToggleModule,
    TranslateModule.forRoot({
      loader: {
        provide: TranslateLoader,
        useFactory: HttpLoaderFactory,
        deps: [HttpClient]
      }
    })
  ],
  exports: [
    EmpleadosComponent

  ]
})
export class HomeModule { }
