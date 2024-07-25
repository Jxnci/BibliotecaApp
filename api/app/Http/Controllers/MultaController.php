<?php

namespace App\Http\Controllers;

use App\Models\DetallePrestamo;
use App\Models\Multa;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MultaController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request) {
    $limit = $request->input('limit', 1) * 10;
    $asunto = $request->input('asunto');

    $query = Multa::query();
    if ($asunto) {
      $query->where('asunto', 'like', "%{$asunto}%");
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
    $validator = Validator::make($request->all(), [
      'asunto' => 'required|string',
      'monto' => 'required|numeric',
      'prestamo_id' => 'required|integer',
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

    $multa = new Multa();
    $multa->asunto = $request->input('asunto');
    $multa->monto = $request->input('monto');

    //actualizar detalle prestamos actualizando la multa_id

    if ($multa->save()) {

      $multaId = $multa->id;
      $prestamoId = $request->input('prestamo_id');
      $prestamo = Prestamo::where('id', $prestamoId)->first();
      if ($prestamo) {
          $prestamo->multa_id = $multaId;
          $prestamo->save();
      }

      return response()->json([
        'data' => $multa,
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
  public function show(Multa $multa) {
    $res = Multa::where('id', $multa->id)->get();
    if (isset($res)) {
      return response()->json([
        'data' => $res,
        'mensaje' => "Multa encontrado"
      ]);
    } else {
      return response()->json([
        'error' => true,
        'mensaje' => "Multa no encontrado"
      ]);
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Multa $multa) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Multa $multa) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Multa $multa) {
    //
  }
}
