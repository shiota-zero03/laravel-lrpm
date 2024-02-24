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
        Schema::create('fbis_evaluations', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('id_submission')->unsigned();
            $table->foreign('id_submission')->references('id')->on('submissions')->onDelete('cascade');
            $table->string('tipe')->nullable(true);

            $table->string('qa1')->nullable(true);
            $table->string('sa1')->nullable(true);
            $table->string('qa2')->nullable(true);
            $table->string('sa2')->nullable(true);
            $table->string('qa3')->nullable(true);
            $table->string('sa3')->nullable(true);
            $table->string('qa4')->nullable(true);
            $table->string('sa4')->nullable(true);

            $table->string('qb1')->nullable(true);
            $table->string('sb1')->nullable(true);
            $table->string('qb2')->nullable(true);
            $table->string('sb2')->nullable(true);
            $table->string('qb3')->nullable(true);
            $table->string('sb3')->nullable(true);

            $table->string('qc1')->nullable(true);
            $table->string('sc1')->nullable(true);
            $table->string('qc2')->nullable(true);
            $table->string('sc2')->nullable(true);
            $table->string('qc3')->nullable(true);
            $table->string('sc3')->nullable(true);
            $table->string('qc4')->nullable(true);
            $table->string('sc4')->nullable(true);

            $table->string('qd1')->nullable(true);
            $table->string('sd1')->nullable(true);
            $table->string('qd2')->nullable(true);
            $table->string('sd2')->nullable(true);
            $table->string('qd3')->nullable(true);
            $table->string('sd3')->nullable(true);
            $table->string('qd4')->nullable(true);
            $table->string('sd4')->nullable(true);
            $table->string('qd5')->nullable(true);
            $table->string('sd5')->nullable(true);

            $table->string('qe1')->nullable(true);
            $table->string('se1')->nullable(true);
            $table->string('qe2')->nullable(true);
            $table->string('se2')->nullable(true);

            $table->string('qf1')->nullable(true);
            $table->string('sf1')->nullable(true);
            $table->string('qf2')->nullable(true);
            $table->string('sf2')->nullable(true);

            $table->string('qg1')->nullable(true);
            $table->string('sg1')->nullable(true);

            $table->string('qh1')->nullable(true);
            $table->string('sh1')->nullable(true);
            $table->string('qh2')->nullable(true);
            $table->string('sh2')->nullable(true);
            $table->string('qh3')->nullable(true);
            $table->string('sh3')->nullable(true);
            $table->string('qh4')->nullable(true);
            $table->string('sh4')->nullable(true);

            $table->string('total')->nullable(true);
            $table->string('average')->nullable(true);

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
        Schema::dropIfExists('fbis_evaluations');
    }
};
