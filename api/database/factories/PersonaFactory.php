<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PersonaFactory extends Factory {
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array {
    return [
      'nombres' => fake()->name(),
      'apellidos' => fake()->lastName(),
      'celular' => fake()->phoneNumber(),
      'tipo_id' => $this->faker->randomElement([1, 2, 3]),
    ];
  }
}
