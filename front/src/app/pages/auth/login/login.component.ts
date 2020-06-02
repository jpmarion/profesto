import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';

import { AuthService } from '../_services/auth.service';

import { Router } from '@angular/router';
import { User } from '../user';
import { RequestLogin } from '../request-login';

import { OkDialogComponent } from '../../shared/dialog/ok-dialog/ok-dialog.component';
import { MatDialog } from '@angular/material/dialog';
import { RegisterDialogComponent } from '../register-dialog/register-dialog.component';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  user: User = new User();
  error: any;
  requestLogin = new RequestLogin();
  errorLogin: boolean;

  login = new FormGroup({
    usuario: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', [Validators.required]),
    remember_me: new FormControl('')
  });

  constructor(
    private authServices: AuthService,
    private router: Router,
    public dialog: MatDialog) { }

  ngOnInit(): void {
    this.errorLogin = false;
  }

  onSubmit() {
    // console.warn(this.login.value);

    this.requestLogin.email = this.login.get('usuario').value;
    this.requestLogin.password = this.login.get('password').value;
    this.requestLogin.remember_me = (this.login.get('remember_me').value === "" ? this.login.get('remember_me').value : false);

    this.authServices.onLogin(this.requestLogin)
      .subscribe(
        (response) => {
          this.router.navigate(['home']);
        },
        (response) => {
          switch (response.status) {
            case 422:
              Object.keys(response.error).map((err) => {
                this.error = `${response.error[err]}`;
              })
              break;
            case 401:
              this.errorLogin = true;
              break;
            default:
              this.error = response.error;
              break;
          }
        }
      )
  }

  openOkDialog(titulo: string, mensaje: string): void {
    const dialogRef = this.dialog.open(OkDialogComponent, {
      data: { titulo: titulo, mensaje: mensaje }
    })
  }

  getMensajeErrorUsuario() {
    if (this.login.get('usuario').hasError) {
      if (this.login.get('usuario').hasError('required')) {
        return 'FORMLOGIN.errorUsuarioRequired';
      }
      return this.login.get('usuario').hasError('email') ? 'FORMLOGIN.errorUsuarioEmail' : '';
    }
  }

  getMensajeErrorPassword() {
    if (this.login.get('password').hasError) {
      return this.login.get('password').hasError('required') ? 'FORMLOGIN.errorPasswordRequired' : '';
    }
  }

  openRegisterDialog() {
    const dialogRef = this.dialog.open(RegisterDialogComponent);
    dialogRef.afterClosed().subscribe(
      (result) => {
        console.log(result);
      });
  }

}
