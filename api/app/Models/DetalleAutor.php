<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAutor extends Model {
  use HasFactory;
  protected $fillable = [
    'autor_id',
    'libro_id',
  ];

  public function autor() {
    return $this->belongsTo(Autor::class);
  }
  public function libro() {
    return $this->belongsTo(Libro::class);
  }
}
