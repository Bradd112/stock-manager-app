<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('storages', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('address');
            $table->integer('capacity');
            $table->boolean('is_in_abroad');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('storages');
    }
};
