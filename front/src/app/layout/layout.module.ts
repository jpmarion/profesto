import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NavComponent } from './nav/nav.component';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatMenuModule } from '@angular/material/menu';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';

@NgModule({
  declarations: [NavComponent],
  imports: [
    CommonModule,
    MatToolbarModule,
    MatMenuModule,
    MatButtonModule,
    MatIconModule
  ],
  exports: [
    NavComponent
  ]
})
export class LayoutModule { }
