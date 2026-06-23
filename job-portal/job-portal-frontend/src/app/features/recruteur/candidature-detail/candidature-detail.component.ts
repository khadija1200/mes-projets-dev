import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute } from '@angular/router';

import { MatCardModule } from '@angular/material/card';
import { MatButtonModule } from '@angular/material/button';

import { CandidatureService } from '../../../core/services/candidature.service';

@Component({
  selector: 'app-candidature-detail-recruteur',
  standalone: true,
  imports: [
    CommonModule,
    MatCardModule,
    MatButtonModule
  ],
  templateUrl: './candidature-detail.component.html',
  styleUrls: ['./candidature-detail.component.scss']
})
export class CandidatureDetailComponent implements OnInit {

  candidature: any;

  constructor(
    private route: ActivatedRoute,
    private candidatureService: CandidatureService
  ) {}

  ngOnInit(): void {

    const id = Number(
      this.route.snapshot.paramMap.get('id')
    );

    this.candidatureService.getById(id)
      .subscribe({
        next: (data) => {
          this.candidature = data;
        },
        error: (err) => {
          console.error(err);
        }
      });
  }

  accept() {

    this.candidatureService
      .updateStatus(this.candidature.id, 'ACCEPTE')
      .subscribe(() => {
        this.candidature.status = 'ACCEPTE';
      });
  }

  reject() {

    this.candidatureService
      .updateStatus(this.candidature.id, 'REFUSE')
      .subscribe(() => {
        this.candidature.status = 'REFUSE';
      });
  }

}
