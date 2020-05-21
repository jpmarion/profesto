import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { RequestRegister } from '../request-register';
import { AuthService } from '../_services/auth.service';
import { OkDialogComponent } from '../../shared/dialog/ok-dialog/ok-dialog.component';
import { MatDialog, MatDialogRef } from '@angular/material/dialog';

@Component({
  selector: 'app-register-dialog',
  templateUrl: './register-dialog.component.html',
  styleUrls: ['./register-dialog.component.scss']
})
export class RegisterDialogComponent implements OnInit {

  register = new FormGroup({
    usuario: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', [Validators.required])
  });
  errorRegister: boolean;
  requestRegister = new RequestRegister;
  loading = false;


  constructor(
    private authServices: AuthService,
    public dialogRef: MatDialogRef<RegisterDialogComponent>,
    public dialog: MatDialog) { }

  ngOnInit(): void {
    this.errorRegister = false;
  }

  onSubmit() {
    this.loading = true;
    this.errorRegister = false;
    this.requestRegister.email = this.register.get('usuario').value;
    this.requestRegister.password = this.register.get('password').value;

    this.authServices.onRigster(this.requestRegister)
      .subscribe(
        (response) => {
          this.dialogRef.close();
          this.openOkDialog("FORMREGISTER.tituloDialogOk","FORMREGISTER.mensajeDialogOk");
        },
        (response) => {
          switch (response.status) {
            case 422:
              this.errorRegister = true;
              this.loading = false;
              break;
            default:
              console.log(response.error);
              break;
          }
        }
      );
    // this.loading = false;
  }

  getMensajeErrorUsuario() {
    if (this.register.get('usuario').hasError) {
      if (this.register.get('usuario').hasError('required')) {
        return 'FORMREGISTER.errorUsuarioRequired';
      }
      return this.register.get('usuario').hasError('email') ? 'FORMREGISTER.errorUsuarioEmail' : '';
    }
  }

  getMensajeErrorPassword() {
    if (this.register.get('password').hasError) {
      return this.register.get('password').hasError('required') ? 'FORMREGISTER.errorPasswordRequired' : '';
    }
  }

  openOkDialog(titulo: string, mensaje: string): void {
    const dialogRef = this.dialog.open(OkDialogComponent, {
      data: { titulo: titulo, mensaje: mensaje }
    })
  }

}
