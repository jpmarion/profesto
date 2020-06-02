import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../pages/auth/_services/auth.service';
import { Router } from '@angular/router';
import { MatDialog } from '@angular/material/dialog';
import { YesNoDialogComponent } from 'src/app/pages/shared/dialog/yes-no-dialog/yes-no-dialog.component';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.scss']
})
export class NavComponent implements OnInit {

  constructor(
    private authServices: AuthService,
    private router: Router,
    public dialogSalir: MatDialog
  ) { }

  ngOnInit(): void {
  }

  onLogout(): void {
    this.dialogSalir.open(YesNoDialogComponent, {
      data: { titulo: "LOGOUT.tituloDialogYesNo", mensaje: "LOGOUT.mensajeDialogYesNo" }
    })
      .afterClosed()
      .subscribe((confirmado: Boolean) => {
        if (confirmado) {
          this.authServices.onLogout().subscribe();
          this.router.navigate(['']);
        }
      });
  }
}
