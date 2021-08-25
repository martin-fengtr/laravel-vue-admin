<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaPageItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_page_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('meta_pages')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('meta_items')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('order');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['page_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meta_page_items');
    }
}
