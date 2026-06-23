import { Routes } from '@angular/router';
import { CandidatureListComponent } from './candidature-list/candidature-list.component';
import { CandidatureDetailComponent } from './candidature-detail/candidature-detail.component';

export const RECRUTEUR_ROUTES: Routes = [
  { path: '', redirectTo: 'list', pathMatch: 'full' },

  { path: 'list', component: CandidatureListComponent },

  { path: 'detail/:id', component: CandidatureDetailComponent }
];
