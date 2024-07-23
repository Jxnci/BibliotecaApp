import { Routes } from '@angular/router';

export const routes: Routes = [
  {
    path: 'libros',
    loadChildren: () => import('./libros/features/libros-shell/libros.route'),
  }, {
    path: '**',
    redirectTo: 'libros'
  }
];
