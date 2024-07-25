<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LibroController extends Controller {

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request) {
    $limit = $request->input('limit', 1) * 10;
    $categoria_id = $request->input('categoria_id');
    $titulo = $request->input('titulo');

    $query = Libro::with('categoria:id,descripcion');

    if ($categoria_id) {
      $query->where('categoria_id', $categoria_id);
    }
    if ($titulo) {
      $query->where('titulo', 'like', "%{$titulo}%");
    }

    $libros = $query->paginate($limit);

    return response()->json($libros, 200);
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
      'titulo' => 'required|string|max:255',
      'imagen' => 'nullable|string|max:255',
      'codigo' => 'required|string|max:255',
      'paginas' => 'required|integer',
      'resena' => 'required|string',
      'categoria_id' => 'required|exists:categorias,id'
    ], [
      'required' => 'El :attribute es requerido',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'error' => true,
        'mensaje' => 'Errores de validación',
        'errors' => $validator->errors()
      ], 422);
    }

    $libro = new Libro();
    $libro->titulo = $request->input('titulo');
    $libro->imagen = $request->input('imagen');
    $libro->codigo = $request->input('codigo');
    $libro->paginas = $request->input('paginas');
    $libro->resena = $request->input('resena');
    $libro->categoria_id = $request->input('categoria_id');

    if ($libro->save()) {
      return response()->json([
        'data' => $libro,
        'mensaje' => 'Libro creado exitosamente'
      ]);
    } else {
      return response()->json([
        'error' => true,
        'mensaje' => 'Error al crear el libro'
      ], 500);
    }
  }


  /**
   * Display the specified resource.
   */
  public function show(Libro $libro) {
    $res = Libro::with('categoria:id,descripcion', 'autores:id,nombres,apellidos')->where('id', $libro->id)->get();
    if (isset($res)) {
      return response()->json([
        'data' => $res,
        'mensaje' => "Libro encontrado"
      ]);
    } else {
      return response()->json([
        'error' => true,
        'mensaje' => "Libro no encontrado"
      ]);
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Libro $libro) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Libro $libro) {

    $validator = Validator::make($request->all(), [
      'titulo' => 'required|string|max:255',
      'imagen' => 'nullable|string|max:255',
      'codigo' => 'required|string|max:255',
      'paginas' => 'required|string|max:255',
      'resena' => 'required|string|max:255',
      'categoria_id' => 'required|exists:categorias,id'
    ], [
      'required' => 'El :attribute es requerido',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'error' => true,
        'mensaje' => 'Errores de validación',
        'errors' => $validator->errors()
      ], 422);
    }

    $libro->titulo = $request->input('titulo');
    $libro->imagen = $request->input('imagen');
    $libro->codigo = $request->input('codigo');
    $libro->paginas = $request->input('paginas');
    $libro->resena = $request->input('resena');
    $libro->categoria_id = $request->input('categoria_id');

    if ($libro->save()) {
      return response()->json([
        'data' => $libro,
        'mensaje' => 'Libro actualizado exitosamente'
      ]);
    } else {
      return response()->json([
        'error' => true,
        'mensaje' => 'Error al actualizar el libro'
      ], 500);
    }
  }


  /**
   * Remove the specified resource from storage.
   */

  public function destroy(Libro $libro) {
    try {
      $res = $libro->delete();
      if ($res) {
        return response()->json([
          'data' => $libro,
          'mensaje' => "Libro eliminado"
        ]);
      } else {
        return response()->json([
          'error' => true,
          'mensaje' => "Error al eliminar el libro"
        ]);
      }
    } catch (\Illuminate\Database\QueryException $e) {
      if ($e->getCode() == "23000") {
        return response()->json([
          'error' => true,
          'mensaje' => "Este libro no se puede eliminar porque pertenece a un préstamo",
          'detalle' => $e->getMessage()
        ]);
      }

      return response()->json([
        'error' => true,
        'mensaje' => "Error al eliminar el libro"
      ]);
    }
  }
}
