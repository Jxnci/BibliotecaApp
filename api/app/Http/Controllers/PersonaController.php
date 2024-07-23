<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request) {
    $limit = $request->input('limit', 1) * 10;
    $nombreApellido = $request->input('nombreApellido');
    $tipo_id = $request->input('tipo');

    $query = Persona::with('tipo:id,descripcion');

    if ($tipo_id) {
      $query->where('tipo_id', $tipo_id);
    }

    if ($nombreApellido) {
      $query->where(function ($q) use ($nombreApellido) {
        $q->where('nombres', 'like', "%{$nombreApellido}%")
          ->orWhere('apellidos', 'like', "%{$nombreApellido}%");
      });
    }

    $autores = $query->paginate($limit);

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
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Persona $persona) {
    $res = Persona::with('tipo:id,descripcion')->where('id', $persona->id)->get();
    if (isset($res)) {
      return response()->json([
        'data' => $res,
        'mensaje' => "Persona encontrado"
      ]);
    } else {
      return response()->json([
        'error' => true,
        'mensaje' => "Persona no encontrado"
      ]);
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Persona $persona) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Persona $persona) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Persona $persona) {
    //
  }
}
