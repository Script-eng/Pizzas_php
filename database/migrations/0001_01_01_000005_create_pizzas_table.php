<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pizzas', function (Blueprint $table) {
            $table->id();
            $table->string('pname');
            $table->string('category_name');
            $table->boolean('vegetarian')->default(false);
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('category_name')
                ->references('cname')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pizzas');
    }
};
