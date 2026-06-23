import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { Router, RouterLink } from '@angular/router';

import { MatCardModule } from '@angular/material/card';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatButtonModule } from '@angular/material/button';
import { MatSelectModule } from '@angular/material/select';

import { AuthService } from '../../../core/services/auth.service';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [
    FormsModule,
    CommonModule,
    RouterLink,
    MatCardModule,
    MatFormFieldModule,
    MatInputModule,
    MatButtonModule,
    MatSelectModule
  ],
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent {

  email = '';
  password = '';
  role = 'CANDIDAT';

  companyName = '';
  address = '';

  showRecruiterFields = false;

  constructor(
    private authService: AuthService,
    private router: Router
  ) {}

  onRoleChange() {
    this.showRecruiterFields = this.role === 'RECRUTEUR';
  }

  register() {

    const data: any = {
      email: this.email,
      password: this.password,
      role: this.role
    };

    if (this.role === 'RECRUTEUR') {
      data.companyName = this.companyName;
      data.address = this.address;
    }

    this.authService.register(data).subscribe({
      next: (res) => {
        console.log('REGISTER OK', res);

        alert('Compte créé avec succès');

        // redirect login
        this.router.navigate(['/login']);
      },
      error: (err) => {
        console.error(err);
        alert('Erreur lors de l’inscription');
      }
    });
  }
}
