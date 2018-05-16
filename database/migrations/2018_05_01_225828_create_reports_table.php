<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('run_id');
            $table->string('url');
            $table->string('json_report')->nullable();
            $table->string('html_report')->nullable();
            $table->string('failure_reason')->nullable();
            $table->integer('accessibility_score')->nullable();
            $table->integer('best_practices_score')->nullable();
            $table->integer('performance_score')->nullable();
            $table->integer('pwa_score')->nullable();
            $table->integer('seo_score')->nullable();
            $table->timestamps();

            $table->foreign('run_id')->references('id')->on('runs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
