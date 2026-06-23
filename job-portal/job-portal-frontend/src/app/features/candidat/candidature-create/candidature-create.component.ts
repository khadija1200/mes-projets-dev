import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { MatCardModule } from '@angular/material/card';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from '@angular/material/input';
import { MatButtonModule } from '@angular/material/button';
import { MatSelectModule } from '@angular/material/select';
import { CandidatureService } from '../../../core/services/candidature.service';
import { AuthService } from '../../../core/services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-candidature-create',
  standalone: true,
  imports: [
    CommonModule,
    FormsModule,
    MatCardModule,
    MatFormFieldModule,
    MatInputModule,
    MatButtonModule,
    MatSelectModule
  ],
  templateUrl: './candidature-create.component.html',
  styleUrls: ['./candidature-create.component.scss']
})
export class CandidatureCreateComponent implements OnInit {

  recruteurId: number | null = null;
  poste = '';
  message = '';
  cvFile: File | null = null;

  recruteurs: any[] = [];

  constructor(
    private service: CandidatureService,
    private authService: AuthService,
    private router: Router   // ✅ FIX ICI
  ) {}

  ngOnInit() {
    this.service.getRecruteurs().subscribe(data => {
      this.recruteurs = data;
    });
  }

  onFileSelected(event: any) {
    this.cvFile = event.target.files[0];
  }

  submit() {
    const user = this.authService.getUser();

    const formData = new FormData();

    formData.append('poste', this.poste);
    formData.append('message', this.message);
    formData.append('recruiterId', this.recruteurId?.toString() || '');
    formData.append('candidatId', user.id.toString());

    if (this.cvFile) {
      formData.append('file', this.cvFile);
    }

    this.service.createCandidature(formData).subscribe({
      next: (res) => {
        console.log('Candidature envoyée', res);

        this.router.navigate(['/candidat/candidatures']);
      },
      error: (err) => {
        console.error(err);
        alert('Erreur lors de l’envoi');
      }
    });
  }
}
