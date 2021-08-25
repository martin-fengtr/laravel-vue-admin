<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('add_hole')->default(0);
            $table->boolean('insp_filter')->default(0);
            $table->boolean('ad_hoc_insp')->default(0);
            $table->boolean('update_hole')->default(0);
            $table->boolean('report_problem')->default(0);
            $table->boolean('replace_badge')->default(0);
            $table->boolean('create_report')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
