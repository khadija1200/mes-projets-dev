import { Component } from '@angular/core';
import { MatCardModule } from '@angular/material/card';

@Component({
  selector: 'app-candidature-detail',
  standalone: true,
  imports: [MatCardModule],
  templateUrl: './candidature-detail.component.html',
  styleUrls: ['./candidature-detail.component.scss']
})
export class CandidatureDetailComponent {}
