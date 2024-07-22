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
    Schema::create('prestamos', function (Blueprint $table) {
      $table->engine = "InnoDB";
      $table->bigIncrements('id');
      $table->integer('estado');
      $table->date('fecha_inicio');
      $table->date('fecha_fin');
      $table->bigInteger('user_id')->unsigned();
      $table->bigInteger('persona_id')->unsigned();
      $table->bigInteger('multa_id')->unsigned()->nullable();
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('persona_id')->references('id')->on('personas');
      $table->foreign('multa_id')->references('id')->on('multas');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    //
  }
};
