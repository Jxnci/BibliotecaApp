<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PrestamoFactory extends Factory {
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array {
    return [
      'estado' => $this->faker->randomElement([1, 2, 3]),
      'fecha_inicio' => $this->faker->date(),
      'fecha_fin' => $this->faker->date(),
      'user_id' => $this->faker->randomElement([1, 2, 3]),
      'persona_id' => $this->faker->numberBetween(1, 60),
      'multa_id' => $this->faker->numberBetween(1, 20),
    ];
  }
}
