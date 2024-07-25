<?php

namespace App\Http\Controllers;

use App\Models\DetallePrestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetallePrestamoController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    $validator = Validator::make($request->all(), [
      'prestamo_id' => 'required|integer',
      'libro_id' => 'required|integer',
    ], [
      'required' => ':attribute es requerido',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'error' => true,
        'mensaje' => 'Errores de validación',
        'errors' => $validator->errors()
      ], 422);
    }

    $detPrestamo = new DetallePrestamo();
    $detPrestamo->observacion = 's/o';
    $detPrestamo->prestamo_id = $request->input('prestamo_id');
    $detPrestamo->libro_id = $request->input('libro_id');

    if ($detPrestamo->save()) {
      return response()->json([
        'data' => $detPrestamo,
        'mensaje' => 'Creado exitosamente'
      ]);
    } else {
      return response()->json([
        'error' => true,
        'mensaje' => 'Error al crear'
      ], 500);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(DetallePrestamo $detallePrestamo) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(DetallePrestamo $detallePrestamo) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, DetallePrestamo $detallePrestamo) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroyDetallelibro(Request $request) {
    $prestamo_id = $request->input('prestamo_id');
    $libro_id = $request->input('libro_id');

    $detAutor = DetallePrestamo::where('prestamo_id', $prestamo_id)
      ->where('libro_id', $libro_id)
      ->first();

    if ($detAutor) {
      $detAutor->delete();
      return response()->json([
        'mensaje' => 'Eliminado correctamente'
      ]);
    } else {
      return response()->json([
        'error' => true,
        'mensaje' => 'Registro no encontrado'
      ], 404);
    }
  }
}
