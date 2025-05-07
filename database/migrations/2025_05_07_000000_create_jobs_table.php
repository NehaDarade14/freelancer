<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('job_type', ['full-time', 'part-time', 'contract', 'freelance', 'internship']);
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('location');
            $table->dateTime('deadline');
            $table->enum('experience_level', ['entry', 'mid', 'senior', 'executive']);
            $table->json('skills_required');
            $table->enum('status', ['draft', 'active', 'closed', 'archived'])->default('draft');
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'deadline']);
            $table->index(['job_type', 'location']);
            $table->index(['experience_level', 'salary']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};