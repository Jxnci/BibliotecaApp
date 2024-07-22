<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post("register", [AuthController::class, 'register']);
Route::post("login", [AuthController::class, 'login']);

Route::get('testAPI', function () {
  return 'Api funcionando Correctamente';
});

Route::middleware(['auth:sanctum'])->group(function () {
  // Route::apiResource("usuarios", UserController::class);
  // Route::apiResource("productos", ProductController::class);
  // Route::apiResource("categorias", CategoryController::class);


  Route::post("logout", [AuthController::class, 'logout']);
});

