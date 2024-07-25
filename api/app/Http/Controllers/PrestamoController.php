<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use Illuminate\Http\Request;

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

    $prestamos = $query->paginate($limit);

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
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Prestamo $prestamo) {
    $res = Prestamo::with('persona:id,nombres,apellidos,celular,tipo_id', 'persona.tipo:id,descripcion', 'user:id,name', 'multa:id,asunto,monto')
      ->where('id', $prestamo->id)->get();
    if (isset($res)) {
      return response()->json([
        'data' => $res,
        'mensaje' => "Prestamo encontrado"
      ]);
    } else {
      return response()->json([
        'error' => true,
        'mensaje' => "Prestamo no encontrado"
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
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Prestamo $prestamo) {
    try {
      // Cambiar el estado a 3 en lugar de eliminar
      $prestamo->estado = 2;
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
