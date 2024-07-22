<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LibroFactory extends Factory {
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array {
    $titulo = $this->faker->sentence();
    return [
      'titulo' => $titulo,
      'imagen' => "libro.jpg",
      'codigo' => $this->faker->numberBetween(1, 100) . '_' . $this->primeraLetra($titulo),
      'paginas' => $this->faker->numberBetween(100, 600),
      'resena' => $this->faker->sentence(10),
      'categoria_id' => $this->faker->numberBetween(1, 10),
    ];
  }
  function primeraLetra($oracion) {
    $palabras = explode(' ', $oracion);
    $primerasLetras = [];
    foreach ($palabras as $palabra) {
      if (!empty($palabra)) {
        $primerasLetras[] = $palabra[0];
      }
    }
    return implode('', $primerasLetras);
  }
}
