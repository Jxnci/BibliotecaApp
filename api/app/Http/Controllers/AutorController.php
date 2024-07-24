<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AutorController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request) {
    $limit = $request->input('limit', 1) * 10;
    $nombreApellido = $request->input('nombreApellido');

    $query = Autor::query();

    if ($nombreApellido) {
      $query->where(function ($q) use ($nombreApellido) {
        $q->where('nombres', 'like', "%{$nombreApellido}%")
          ->orWhere('apellidos', 'like', "%{$nombreApellido}%");
      });
    }

    $autores = $query->orderBy('id', 'desc')->paginate($limit);

    return response()->json($autores, 200);
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
      'nombres' => 'required|string|max:255',
      'apellidos' => 'required|string|max:255',
      'nacimiento' => 'required|date',
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

    $autor = new Autor();
    $autor->nombres = $request->input('nombres');
    $autor->apellidos = $request->input('apellidos');
    $autor->nacimiento = $request->input('nacimiento');

    if ($autor->save()) {
      return response()->json([
        'data' => $autor,
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
  public function show($id) {
    $res = Autor::where('id', $id)->get();
    if (isset($res)) {
      return response()->json([
        'data' => $res,
        'mensaje' => "Autor encontrado"
      ]);
    } else {
      return response()->json([
        'error' => true,
        'mensaje' => "Autor no encontrado"
      ]);
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Autor $autor) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $autor_id) {
    $validator = Validator::make($request->all(), [
      'nombres' => 'required|string|max:255',
      'apellidos' => 'required|string|max:255',
      'nacimiento' => 'required|date',
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
    $autor = Autor::findOrFail($autor_id);
    $autor->nombres = $request->input('nombres');
    $autor->apellidos = $request->input('apellidos');
    $autor->nacimiento = $request->input('nacimiento');

    if ($autor->save()) {
      return response()->json([
        'data' => $autor,
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
  public function destroy($autor_id) {
    $autor = Autor::findOrFail($autor_id);
    $tieneLibros = $autor->libros()->exists();
    if (!$tieneLibros) {
      $res = $autor->delete();
      if ($res) {
        return response()->json([
          'data' => $autor,
          'mensaje' => "Eliminado correctamente"
        ]);
      } else {
        return response()->json([
          'error' => true,
          'mensaje' => "Error al eliminar",
          'detalles' => $autor
        ]);
      }
    } else {
      return response()->json([
        'error' => true,
        'mensaje' => "Hay libros relacionados a este autor",
      ]);
    }
  }
}
