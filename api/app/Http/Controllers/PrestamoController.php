<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrestamoController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request) {
    $limit = $request->input('limit', 1) * 10;
    $fechaInicio = $request->input('fecha_inicio');
    $fechaFin = $request->input('fecha_fin');
    $nombres = $request->input('nombres');

    $query = Prestamo::query()->join('personas', 'personas.id', '=', 'prestamos.persona_id')
      ->with('persona:id,nombres,apellidos,celular,tipo_id', 'persona.tipo:id,descripcion', 'user:id,name', 'multa:id,asunto,monto')->select('prestamos.*');

    if ($nombres) {
      $query->where('personas.nombres', 'like', "%{$nombres}%");
    }
    if ($fechaInicio && $fechaFin) {
      $query->whereBetween('prestamos.fecha_inicio', [$fechaInicio, $fechaFin]);
    }

    $prestamos = $query->orderBy('id', 'desc')->paginate($limit);

    return response()->json($prestamos, 200);
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
      'fecha_inicio' => 'nullable|date',
      'fecha_fin' => 'required|date',
      'user_id' => 'required|integer',
      'persona_id' => 'required|integer',
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

    $prestamo = new Prestamo();
    $prestamo->estado = 1;
    $prestamo->fecha_inicio = $request->input('fecha_inicio');
    $prestamo->fecha_fin = $request->input('fecha_fin');
    $prestamo->user_id = $request->input('user_id');
    $prestamo->persona_id = $request->input('persona_id');

    if ($prestamo->save()) {
      return response()->json([
        'data' => $prestamo,
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
  public function show(Prestamo $prestamo) {
    $res = Prestamo::with('persona:id,nombres,apellidos,celular,tipo_id', 'persona.tipo:id,descripcion', 'user:id,name', 'multa:id,asunto,monto', 'libros:id,titulo,codigo')
      ->where('id', $prestamo->id)
      ->get();

    if ($res->isNotEmpty()) {
      return response()->json([
        'data' => $res,
        'mensaje' => "Préstamo encontrado"
      ]);
    } else {
      return response()->json([
        'error' => true,
        'mensaje' => "Préstamo no encontrado"
      ]);
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Prestamo $prestamo) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Prestamo $prestamo) {
    $validator = Validator::make($request->all(), [
      'fecha_inicio' => 'required|date',
      'fecha_fin' => 'nullable|date',
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

    $prestamo->fecha_inicio = $request->input('fecha_inicio');
    $prestamo->fecha_fin = $request->input('fecha_fin');

    if ($prestamo->save()) {
      return response()->json([
        'data' => $prestamo,
        'mensaje' => 'Aactualizado exitosamente'
      ]);
    } else {
      return response()->json([
        'error' => true,
        'mensaje' => 'Error al actualizar'
      ], 500);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, Prestamo $prestamo) {
    $validated = $request->validate([
      'estado' => 'required|integer',
    ]);
    $prestamo->estado = $validated['estado'];

    try {
      $res = $prestamo->save();

      if ($res) {
        return response()->json([
          'data' => $prestamo,
          'mensaje' => "Prestamo anulado"
        ]);
      } else {
        return response()->json([
          'error' => true,
          'mensaje' => "Error al anular préstamo"
        ]);
      }
    } catch (\Illuminate\Database\QueryException $e) {
      return response()->json([
        'error' => true,
        'mensaje' => "Error al actualizar el estado del préstamo",
        'detalle' => $e->getMessage()
      ]);
    }
  }
}
