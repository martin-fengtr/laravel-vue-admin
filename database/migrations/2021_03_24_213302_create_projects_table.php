<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('status_id')->nullable()->constrained('project_statuses')->cascadeOnUpdate()->nullOnDelete();
            $table->string('name');
            $table->string('hash')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
