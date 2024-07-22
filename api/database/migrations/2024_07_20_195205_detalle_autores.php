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
    Schema::create('detalle_autors', function (Blueprint $table) {
      $table->engine = "InnoDB";
      $table->bigIncrements('id');
      $table->bigInteger('autor_id')->unsigned();
      $table->bigInteger('libro_id')->unsigned();
      $table->timestamps();

      $table->foreign('autor_id')->references('id')->on('autors');
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
