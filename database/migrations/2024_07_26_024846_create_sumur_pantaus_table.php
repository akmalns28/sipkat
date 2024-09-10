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
        Schema::create('sumur_pantaus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->char('provinsi_id',2);
            $table->char('kota_id',4);
            $table->char('kecamatan_id',6);
            $table->char('kelurahan_id',10);
            $table->string('kode_sumur_pantau');
            $table->string('no_inventarisasi');
            $table->string('alamat');
            $table->string('lokasi');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('foto');
            $table->boolean('status');
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('provinsi_id')->references('id')->on('provinsi')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('kota_id')->references('id')->on('kota')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('kelurahan_id')->references('id')->on('kelurahan')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sumur_pantaus');
    }
};
