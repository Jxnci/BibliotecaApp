<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model {
  use HasFactory;
  protected $fillable = [
    'titulo',
    'imagen',
    'codigo',
    'paginas',
    'resena',
    'categoria_id'
  ];
  public function categoria() {
    return $this->belongsTo(Categoria::class);
  }
  public function autores() {
    return $this->belongsToMany(Autor::class, 'detalle_autors', 'libro_id', 'autor_id');
  }
  public function prestamos() {
    return $this->belongsToMany(Prestamo::class, 'detalle_prestamos', 'libro_id', 'prestamo_id');
}
}
