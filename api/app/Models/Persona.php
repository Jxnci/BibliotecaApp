<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model {
  use HasFactory;
  protected $fillable = [
    'nombres',
    'apellidos',
    'celular',
    'tipo_id'
  ];
  public function tipo() {
    return $this->belongsTo(Tipo::class);
  }
}
