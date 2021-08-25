<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('badge_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('status_id')->nullable()->constrained('hole_statuses')->cascadeOnUpdate()->nullOnDelete();
            $table->text('hole_photos')->nullable();
            $table->text('badge_photos')->nullable();
            $table->string('gridline')->nullable();
            $table->text('observations')->nullable();
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
        Schema::dropIfExists('holes');
    }
}
