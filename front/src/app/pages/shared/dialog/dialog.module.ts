import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatDialogModule } from '@angular/material/dialog';
import { MatButtonModule } from '@angular/material/button';
import { TranslateLoader, TranslateModule } from '@ngx-translate/core';
import { TranslateHttpLoader } from '@ngx-translate/http-loader';
import { HttpClient } from '@angular/common/http';
import { OkDialogComponent } from './ok-dialog/ok-dialog.component';
import { YesNoDialogComponent } from './yes-no-dialog/yes-no-dialog.component';

export function HttpLoaderFactory(http: HttpClient) {
  return new TranslateHttpLoader(http);
}

@NgModule({
  declarations: [OkDialogComponent, YesNoDialogComponent],
  imports: [
    CommonModule,
    MatDialogModule,
    MatButtonModule,
    TranslateModule.forRoot({
      loader: {
        provide: TranslateLoader,
        useFactory: HttpLoaderFactory,
        deps: [HttpClient]
      }
    })
  ],
  exports: [OkDialogComponent, YesNoDialogComponent],
  entryComponents: [],
  providers: []
})
export class DialogModule { }
