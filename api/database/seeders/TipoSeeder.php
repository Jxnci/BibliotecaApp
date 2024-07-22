<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    $tipos = [
      "Estudiante",
      "Administrativo",
      "Docente",
    ];

    foreach ($tipos as $tp) {
      $tipo = new Tipo();
      $tipo->descripcion = $tp;
      $tipo->save();
    }
  }
}
