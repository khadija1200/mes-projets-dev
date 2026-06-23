import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { MatCardModule } from '@angular/material/card';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatButtonModule } from '@angular/material/button';
import { AuthService } from '../../../core/services/auth.service';
import { CommonModule } from '@angular/common';
import { Router, RouterLink } from '@angular/router';


@Component({
  selector: 'app-login',
  standalone: true,
  imports: [
    FormsModule,
    CommonModule,
    RouterLink,
    MatCardModule,
    MatFormFieldModule,
    MatInputModule,
    MatButtonModule
  ],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent {

  email = '';
  password = '';

  constructor(
    private authService: AuthService,
    private router: Router
  ) {}

  login() {
    this.authService.login({
      email: this.email,
      password: this.password
    }).subscribe({
      next: (user: any) => {

        console.log('LOGIN OK', user);

        // 👉 stocker utilisateur globalement
        this.authService.setUser(user);

        // 👉 redirection selon rôle
        if (user.role === 'RECRUTEUR') {
          this.router.navigate(['/recruteur/candidatures']);
        } else if (user.role === 'CANDIDAT') {
          this.router.navigate(['/candidat/create']);
        }

      },
      error: (err) => {
        console.error(err);
        alert('Login failed');
      }
    });
  }
}
