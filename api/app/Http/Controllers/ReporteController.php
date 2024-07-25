<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use App\Models\Libro;
use App\Models\Persona;
use App\Models\Prestamo;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    $numeroPersonas = Persona::count();
    $numeroLibros = Libro::count();
    $numeroAutores = Autor::count();
    $numeroPrestamos = Prestamo::count();

    $currentYear = Carbon::now()->year;
    $prestamosPorMes = DB::table('prestamos')
      ->select(DB::raw('MONTH(fecha_inicio) as mes'), DB::raw('COUNT(*) as total'))
      ->whereYear('fecha_inicio', $currentYear)
      ->groupBy(DB::raw('MONTH(fecha_inicio)'))
      ->get();

      $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre'
    ];

    $formattedData = array_fill_keys(array_values($meses), 0);

    // Rellenar con los datos obtenidos
    foreach ($prestamosPorMes as $prestamo) {
        $formattedData[$meses[$prestamo->mes]] = $prestamo->total;
    }

    return response()->json([
      'numeroPersonas' => $numeroPersonas,
      'numeroLibros' => $numeroLibros,
      'numeroAutores' => $numeroAutores,
      'numeroPrestamos' => $numeroPrestamos,
      'datosMensuales' => $formattedData,
    ]);
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
  public function show(string $id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id) {
    //
  }
}
