<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DetalleAutorController;
use App\Http\Controllers\DetallePrestamoController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\MultaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TipoController;
use Illuminate\Support\Facades\Route;

Route::post("register", [AuthController::class, 'register']);
Route::post("login", [AuthController::class, 'login']);

Route::get('testAPI', function () {
  return 'Api funcionando Correctamente';
});

// Route::middleware(['auth:sanctum'])->group(function () {
  Route::apiResource("libros", LibroController::class);
  Route::apiResource("autores", AutorController::class);
  Route::apiResource("prestamos", PrestamoController::class);
  Route::apiResource("personas", PersonaController::class);
  Route::apiResource("multas", MultaController::class);
  Route::apiResource("reportes", ReporteController::class);
  
  Route::apiResource("detalleautores", DetalleAutorController::class);
  Route::delete("detalleautores", [DetalleAutorController::class, 'destroyDetalleAutor']);
  Route::apiResource("detalleprestamo", DetallePrestamoController::class);
  Route::delete("detalleprestamo", [DetallePrestamoController::class, 'destroyDetallelibro']);
  
  Route::apiResource("tipos", TipoController::class);
  Route::apiResource("categorias", CategoriaController::class);

//   Route::post("logout", [AuthController::class, 'logout']);
// });
