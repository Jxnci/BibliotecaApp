<?php

namespace App\Http\Controllers;

use App\Models\Multa;
use Illuminate\Http\Request;

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
    //
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
