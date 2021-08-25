<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hole_id')->constrained('holes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('page_id')->constrained('meta_pages')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('meta_items')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('value')->nullable();
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
        Schema::dropIfExists('meta_answers');
    }
}
