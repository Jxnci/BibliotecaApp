import { inject, Injectable } from "@angular/core";
import { Libro } from "../../shared/interfaces/libro.interface";
import { signalSlice } from 'ngxtension/signal-slice';
import { LibrosService } from "./libros.service";
import { map } from "rxjs";

interface State {
  libros: Libro[];
  status: 'Cargando' | 'Exito' | 'Error';
}

@Injectable()
export class LibrosStateService {
  private librosService = inject(LibrosService)

  private initialState: State = {
    libros: [],
    status: 'Cargando' as const,
  }

  state = signalSlice({
    initialState: this.initialState,
    sources: [
      this.librosService
        .getLibros()
        .pipe(map((libros) => ({ libros, status: 'Exito' as const })))
    ]
  })

  // constructor(){
  //   this.state.libros()
  // }

}