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
    Schema::create('personas', function (Blueprint $table) {
      $table->engine = "InnoDB";
      $table->bigIncrements('id');
      $table->string('nombres');
      $table->string('apellidos');
      $table->string('celular');
      $table->bigInteger('tipo_id')->unsigned();
      $table->timestamps();

      $table->foreign('tipo_id')->references('id')->on('tipos')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    //
  }
};
