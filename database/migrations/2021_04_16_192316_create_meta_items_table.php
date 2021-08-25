<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('element_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('label');
            $table->string('default_value')->default('');
            $table->string('options',255)->default('');
            $table->boolean('required')->default('0');
            $table->boolean('multiline')->default('0');
            $table->boolean('multiple')->default('0');
            $table->boolean('hide_until')->default('0');
            $table->integer('order');
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
        Schema::dropIfExists('meta_items');
    }
}
