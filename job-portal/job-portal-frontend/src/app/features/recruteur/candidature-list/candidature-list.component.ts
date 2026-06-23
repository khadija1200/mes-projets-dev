import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatCardModule } from '@angular/material/card';
import { MatButtonModule } from '@angular/material/button';
import { Router } from '@angular/router';
import { CandidatureService } from '../../../core/services/candidature.service';
import { AuthService } from '../../../core/services/auth.service';

@Component({
  selector: 'app-candidature-list-recruteur',
  standalone: true,
  imports: [CommonModule, MatCardModule, MatButtonModule],
  templateUrl: './candidature-list.component.html',
  styleUrls: ['./candidature-list.component.scss']
})
export class CandidatureListComponent implements OnInit {

  candidatures: any[] = [];

  constructor(
    private service: CandidatureService,
    private authService: AuthService,
    private router: Router
  ) {}

  ngOnInit() {
    const user = this.authService.getUser();

    if (user) {

      // 🔥 IMPORTANT : conversion user.id → recruiter.id
      this.service.getRecruiterByUserId(user.id)
        .subscribe({
          next: (recruiter) => {
            this.loadCandidatures(recruiter.id);
          },
          error: (err) => console.error('Recruiter not found', err)
        });

    }
  }

  loadCandidatures(recruiterId: number) {
    this.service.getCandidaturesByRecruiter(recruiterId)
      .subscribe({
        next: (data) => this.candidatures = data,
        error: (err) => console.error(err)
      });
  }

  view(c: any) {
    this.router.navigate(['/recruteur/detail', c.id]);
  }

  accept(c: any) {
    this.service.updateStatus(c.id, 'ACCEPTE').subscribe(() => {
      c.status = 'ACCEPTE';
    });
  }

  reject(c: any) {
    this.service.updateStatus(c.id, 'REFUSE').subscribe(() => {
      c.status = 'REFUSE';
    });
  }
}
