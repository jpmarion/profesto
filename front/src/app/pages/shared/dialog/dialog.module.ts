import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatDialogModule } from '@angular/material/dialog';
import { MatButtonModule } from '@angular/material/button';
import { OkDialogComponent } from './ok-dialog/ok-dialog.component';

@NgModule({
  declarations: [OkDialogComponent],
  imports: [
    CommonModule,
    MatDialogModule,
    MatButtonModule
  ],
  exports: [OkDialogComponent],
  entryComponents: [],
  providers: []
})
export class DialogModule { }
