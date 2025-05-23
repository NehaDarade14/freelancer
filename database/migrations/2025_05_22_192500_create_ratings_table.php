<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned()->between(1, 5);
            $table->timestamps();
            
            $table->unique(['user_id', 'project_id']); // Prevent duplicate ratings
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}