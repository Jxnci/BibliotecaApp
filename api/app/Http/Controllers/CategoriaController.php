<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request) {
    $descripcion = $request->input('descripcion');
    $query = Categoria::query();

    if ($descripcion) {
      $query->where('descripcion', 'like', "%{$descripcion}%");
    }
    $categorias = $query->get();
    return response()->json($categorias, 200);
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
      'descripcion' => 'required|string|max:255',
    ], [
      'required' => 'La :attribute es requerida',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'error' => true,
        'mensaje' => 'Errores de validación',
        'errors' => $validator->errors()
      ], 422);
    }

    $categoria = new Categoria();
    $categoria->descripcion = $request->input('descripcion');

    if ($categoria->save()) {
      return response()->json([
        'data' => $categoria,
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
  public function show(Categoria $categoria) {
    $res = Categoria::where('id', $categoria->id)->get();
    if (isset($res)) {
      return response()->json([
        'data' => $res,
        'mensaje' => "Categoria encontrado"
      ]);
    } else {
      return response()->json([
        'error' => true,
        'mensaje' => "Categoria no encontrado"
      ]);
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Categoria $categoria) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Categoria $categoria) {
    $validator = Validator::make($request->all(), [
      'descripcion' => 'required|string|max:255',
    ], [
      'required' => 'La :attribute es requerido',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'error' => true,
        'mensaje' => 'Errores de validación',
        'errors' => $validator->errors()
      ], 422);
    }
    $categoria->descripcion = $request->input('descripcion');

    if ($categoria->save()) {
      return response()->json([
        'data' => $categoria,
        'mensaje' => 'Actualizado exitosamente'
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
  public function destroy(Categoria $categoria) {
    try {
      $res = $categoria->delete();
      if ($res) {
        return response()->json([
          'data' => $categoria,
          'mensaje' => "Eiminado correctamente"
        ]);
      } else {
        return response()->json([
          'error' => true,
          'mensaje' => "Error al eliminar"
        ]);
      }
    } catch (\Illuminate\Database\QueryException $e) {
      if ($e->getCode() == "23000") {
        return response()->json([
          'error' => true,
          'mensaje' => "Hay libros relacionados a esta categoria",
          'detalle' => $e->getMessage()
        ]);
      }
      return response()->json([
        'error' => true,
        'mensaje' => "Error al eliminar"
      ]);
    }
  }
}
