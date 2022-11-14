<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('inventory_id');
            $table->string('name');
            $table->smallInteger('quantity');
            $table->string('quantity_type');
            $table->string('department');
            $table->string('status')->default('pending');
            $table->string('recommending_status')->default('pending');
            $table->string('approval_status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisitions');
    }
};
