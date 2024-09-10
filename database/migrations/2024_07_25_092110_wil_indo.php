<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('provinsi', function (Blueprint $table) {
            $table->char('id',2)->primary();
            $table->string('name');
        });
        Schema::create('kota', function (Blueprint $table) {
            $table->char('id',10)->primary();
            $table->char('provinsi_id',2);
            $table->string('name');
            $table->foreign('provinsi_id')->references('id')->on('provinsi')->cascadeOnDelete()->cascadeOnUpdate();
        });
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->char('id',6)->primary();
            $table->char('kota_id',4);
            $table->string('name');
            $table->foreign('kota_id')->references('id')->on('kota')->cascadeOnDelete()->cascadeOnUpdate();
        });
        Schema::create('kelurahan', function (Blueprint $table) {
            $table->char('id',10)->primary();
            $table->char('kecamatan_id',6);
            $table->string('name');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
