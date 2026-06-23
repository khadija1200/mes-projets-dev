import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatCardModule } from '@angular/material/card';
import { MatButtonModule } from '@angular/material/button';

import { CandidatureService } from '../../../core/services/candidature.service';
import { AuthService } from '../../../core/services/auth.service';

@Component({
  selector: 'app-candidature-list',
  standalone: true,
  imports: [
    CommonModule,
    MatCardModule,
    MatButtonModule
  ],
  templateUrl: './candidature-list.component.html',
  styleUrls: ['./candidature-list.component.scss']
})
export class CandidatureListComponent implements OnInit {

  candidatures: any[] = [];

  constructor(
    private service: CandidatureService,
    private authService: AuthService
  ) {}

  ngOnInit() {
    const user = this.authService.getUser();

    if (!user) return;

    this.service.getMyCandidatures(user.id).subscribe({
      next: (data) => {
        this.candidatures = data;
        console.log('Candidatures:', data);
      },
      error: (err) => {
        console.error('Erreur chargement candidatures', err);
      }
    });
  }

  getStatusClass(status: string) {
    return {
      'pending': status === 'EN_ATTENTE',
      'accepted': status === 'ACCEPTE',
      'rejected': status === 'REFUSE'
    };
  }
}
