import { Component, inject } from '@angular/core';
import { LibrosStateService } from '../../data-access/libros-state.service';

@Component({
  selector: 'app-libros-list',
  standalone: true,
  imports: [],
  templateUrl: './libros-list.component.html',
  styles: ``,
  providers:[LibrosStateService]
})
export default class LibrosListComponent {
  librosState=inject(LibrosStateService)
}
