<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model {
  use HasFactory;
  protected $fillable = [
    'estado',
    'fecha_inicio',
    'fecha_fin',
    'user_id',
    'persona_id',
    'multa_id',
  ];
  public function user() {
    return $this->belongsTo(User::class);
  }
  public function persona() {
    return $this->belongsTo(Persona::class);
  }
  public function multa() {
    return $this->belongsTo(Multa::class);
  }
}
