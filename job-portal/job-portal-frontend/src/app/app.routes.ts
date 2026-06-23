import { Routes } from '@angular/router';

export const routes: Routes = [

  { path: '', redirectTo: 'register', pathMatch: 'full' },

  {
    path: 'login',
    loadComponent: () =>
      import('./features/auth/login/login.component')
        .then(m => m.LoginComponent)
  },

  {
    path: 'register',
    loadComponent: () =>
      import('./features/auth/register/register.component')
        .then(m => m.RegisterComponent)
  },

  {
    path: 'candidat/candidatures',
    loadComponent: () =>
      import('./features/candidat/candidature-list/candidature-list.component')
        .then(m => m.CandidatureListComponent)
  },

  {
    path: 'candidat/create',
    loadComponent: () =>
      import('./features/candidat/candidature-create/candidature-create.component')
        .then(m => m.CandidatureCreateComponent)
  },

  {
    path: 'candidat/detail',
    loadComponent: () =>
      import('./features/candidat/candidature-detail/candidature-detail.component')
        .then(m => m.CandidatureDetailComponent)
  },

  {
    path: 'recruteur/candidatures',
    loadComponent: () =>
      import('./features/recruteur/candidature-list/candidature-list.component')
        .then(m => m.CandidatureListComponent)
  },

  {
    path: 'recruteur/detail/:id',
    loadComponent: () =>
      import('./features/recruteur/candidature-detail/candidature-detail.component')
        .then(m => m.CandidatureDetailComponent)
  }

];
