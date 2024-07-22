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
    Schema::create('libros', function (Blueprint $table) {
      $table->engine = "InnoDB";
      $table->bigIncrements('id');
      $table->string('titulo');
      $table->string('imagen');
      $table->string('codigo');
      $table->string('paginas');
      $table->string('resena');

      $table->bigInteger('categoria_id')->unsigned();
      $table->timestamps();

      $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    //
  }
};
