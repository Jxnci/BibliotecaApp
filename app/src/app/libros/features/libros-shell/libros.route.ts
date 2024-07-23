import { Routes } from "@angular/router";

export default [
  {
    path: '',
    loadComponent: () => import('../libros-list/libros-list.component')
  }
] as Routes