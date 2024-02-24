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
        Schema::create('fti_evaluations', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('id_submission')->unsigned();
            $table->foreign('id_submission')->references('id')->on('submissions')->onDelete('cascade');
            $table->string('tipe')->nullable(true);
            $table->string('q1')->nullable(true);
            $table->text('k1')->nullable(true);
            $table->string('q2')->nullable(true);
            $table->text('k2')->nullable(true);
            $table->string('q3')->nullable(true);
            $table->text('k3')->nullable(true);
            $table->string('q4')->nullable(true);
            $table->text('k4')->nullable(true);
            $table->string('q5')->nullable(true);
            $table->text('k5')->nullable(true);
            $table->string('q6')->nullable(true);
            $table->text('k6')->nullable(true);
            $table->string('q7')->nullable(true);
            $table->text('k7')->nullable(true);
            $table->string('total')->nullable(true);
            $table->string('average')->nullable(true);
            $table->string('orisinalitas')->nullable(true);
            $table->string('kualitas_teknikal')->nullable(true);
            $table->string('metodologi')->nullable(true);
            $table->string('kejelasan_kalimat')->nullable(true);
            $table->string('urgensi')->nullable(true);
            $table->string('last_comment')->nullable(true);
            $table->string('grade_value')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fti_evaluations');
    }
};
