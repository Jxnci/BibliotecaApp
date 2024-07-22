<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    //
    Schema::create('detalle_prestamos', function (Blueprint $table) {
      $table->engine = "InnoDB";
      $table->bigIncrements('id');
      $table->text('observacion');
      $table->bigInteger('prestamo_id')->unsigned();
      $table->bigInteger('libro_id')->unsigned();
      $table->timestamps();

      $table->foreign('prestamo_id')->references('id')->on('prestamos');
      $table->foreign('libro_id')->references('id')->on('libros');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    //
  }
};
