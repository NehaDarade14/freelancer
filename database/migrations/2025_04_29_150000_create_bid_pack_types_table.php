<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bid_pack_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('bids_allowed');
            $table->decimal('price', 10, 2);
            $table->boolean('is_active')->default(false);
            $table->enum('expiration_rules', ['monthly', 'unlimited'])->default('monthly');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bid_pack_types');
    }
};