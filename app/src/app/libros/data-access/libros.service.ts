import { Injectable } from "@angular/core";
import { BaseHttpService } from "../../shared/data-access/base-http.service";
import { Observable } from "rxjs";
import { Libro } from "../../shared/interfaces/libro.interface";

@Injectable({
  providedIn:'root'
})
export class LibrosService extends BaseHttpService {

  getLibros(): Observable<Libro[]> {
    return this.http.get<any[]>(`${this.apiUrl}/libros`);
  }
}