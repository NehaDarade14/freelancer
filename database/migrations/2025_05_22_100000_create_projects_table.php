<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->text('scope');
                $table->text('deliverables');
                $table->text('requirements')->nullable();
                $table->enum('communication_preference', ['email', 'chat', 'video', 'mixed']);
                $table->decimal('budget', 10, 2);
                $table->date('deadline');
                $table->foreignId('client_id')->constrained('users');
                $table->foreignId('freelancer_id')->constrained('users');
                $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};