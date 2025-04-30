<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('bid_pack_type_id')->constrained()->onDelete('restrict');
            $table->unsignedInteger('remaining_bids');
            $table->dateTime('expires_at')->index();
            $table->timestamps();
            
            $table->index(['user_id', 'expires_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bids');
    }
};