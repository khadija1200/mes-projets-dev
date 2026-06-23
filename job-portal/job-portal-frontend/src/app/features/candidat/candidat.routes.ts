import { Routes } from '@angular/router';
import { CandidatureListComponent } from './candidature-list/candidature-list.component';
import { CandidatureCreateComponent } from './candidature-create/candidature-create.component';

export const CANDIDAT_ROUTES: Routes = [
  { path: '', redirectTo: 'list', pathMatch: 'full' },
  { path: 'list', component: CandidatureListComponent },
  { path: 'create', component: CandidatureCreateComponent }
];
