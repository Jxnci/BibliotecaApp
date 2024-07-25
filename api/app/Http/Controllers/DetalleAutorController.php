<?php

namespace App\Http\Controllers;

use App\Models\DetalleAutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetalleAutorController extends Controller {
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
      'autor_id' => 'required|integer',
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

    $detAutor = new DetalleAutor();
    $detAutor->autor_id = $request->input('autor_id');
    $detAutor->libro_id = $request->input('libro_id');

    if ($detAutor->save()) {
      return response()->json([
        'data' => $detAutor,
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
  public function show(DetalleAutor $detalleAutor) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(DetalleAutor $detalleAutor) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, DetalleAutor $detalleAutor) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(DetalleAutor $detalleAutor) {
    //
  }
  public function destroyDetalleAutor(Request $request) {
    $autor_id = $request->input('autor_id');
    $libro_id = $request->input('libro_id');

    $detAutor = DetalleAutor::where('autor_id', $autor_id)
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
