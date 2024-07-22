<?php

namespace Database\Seeders;

use App\Models\Autor;
use App\Models\DetalleAutor;
use App\Models\DetallePrestamo;
use App\Models\Libro;
use App\Models\Multa;
use App\Models\Persona;
use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(3)->create();
        $this->call(CategoriaSeeder::class); // 10
        $this->call(TipoSeeder::class); // 3

        Persona::factory(60)->create();
        Autor::factory(110)->create();
        Multa::factory(20)->create();
        Prestamo::factory(60)->create();
        Libro::factory(100)->create();
        DetalleAutor::factory(100)->create();
        DetallePrestamo::factory(100)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
