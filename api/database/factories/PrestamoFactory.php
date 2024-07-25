<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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

    $today = Carbon::now();
    $sixMonthsAgo = Carbon::now()->subMonths(6);
    $fechaInicio = $this->faker->dateTimeBetween($sixMonthsAgo, $today);
    $randomDays = $this->faker->numberBetween(0, 19);
    $fechaFin = (clone $fechaInicio)->modify("+$randomDays days");

    return [
      'estado' => $this->faker->randomElement([1, 2, 3]),
      'fecha_inicio' => $fechaInicio->format('Y-m-d'),
      'fecha_fin' => $fechaFin->format('Y-m-d'),
      'user_id' => $this->faker->randomElement([1, 2, 3]),
      'persona_id' => $this->faker->numberBetween(1, 60),
      'multa_id' => $this->faker->numberBetween(1, 20),
    ];
  }
}
