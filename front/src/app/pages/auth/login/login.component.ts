import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl } from '@angular/forms';

import { AuthService } from '../_services/auth.service';
import { Router } from '@angular/router';
import { User } from '../user';
import { RequestLogin } from '../request-login';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  user: User = new User();
  error: any;
  requestLogin = new RequestLogin();

  login = new FormGroup({
    usuario: new FormControl(''),
    password: new FormControl(''),
    remember_me: new FormControl('')
  });

  constructor(private authServices: AuthService, private router: Router) { }

  ngOnInit(): void {
  }

  onSubmit() {
    // console.warn(this.login.value);

    this.requestLogin.email = this.login.get('usuario').value;
    this.requestLogin.password = this.login.get('password').value;
    this.requestLogin.remember_me = this.login.get('remember_me').value;

    this.authServices.onLogin(this.requestLogin)
      .subscribe(
        (response) => {
          this.router.navigate(['home']);
        },
        (response) => {
          if (response.status === 422) {
            Object.keys(response.error).map((err) => {
              this.error = `${response.error[err]}`;
            })
          } else {
            this.error = response.error;
          }
        }
      )
  }

}
