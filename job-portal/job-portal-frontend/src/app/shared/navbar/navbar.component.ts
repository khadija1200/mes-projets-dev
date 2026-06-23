import { Component } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatButtonModule } from '@angular/material/button';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../core/services/auth.service';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [
    CommonModule,
    RouterLink,
    MatToolbarModule,
    MatButtonModule
  ],
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss']
})
export class NavbarComponent {

  constructor(
    private authService: AuthService,
    private router: Router
  ) {}

  get user() {
    return this.authService.getUser();
  }

  isLoggedIn(): boolean {
    return this.authService.isLoggedIn();
  }

  isCandidat(): boolean {
    return this.user?.role === 'CANDIDAT';
  }

  isRecruteur(): boolean {
    return this.user?.role === 'RECRUTEUR';
  }

  logout() {
    this.authService.logout();
    this.router.navigate(['/login']);
  }
}
