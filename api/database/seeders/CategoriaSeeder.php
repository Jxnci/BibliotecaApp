<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    $cats = [
      "Aventura",
      "Drama",
      "Terror",
      "Comedia",
      "Fantasia",
      "Ciencia Ficcion",
      "Infantil",
      "Matematicas",
      "Historia",
      "Social",
    ];

    foreach ($cats as $ct) {
      $categoria = new Categoria();
      $categoria->descripcion = $ct;
      $categoria->save();
    }
  }
}
