<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DetallePrestamoFactory extends Factory {
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array {
    return [
      'observacion'=> $this->faker->paragraph(2),
      'prestamo_id' => $this->faker->numberBetween(1, 60),
      'libro_id' => $this->faker->numberBetween(1, 100),
    ];
  }
}
