<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->unsignedTinyInteger('work_rating')->default(0);
            $table->unsignedTinyInteger('communication_rating')->default(0);
            $table->unsignedTinyInteger('payment_rating')->default(0);
            $table->text('review_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->unsignedTinyInteger('rating');
            $table->dropColumn(['work_rating', 'communication_rating', 'payment_rating', 'review_text']);
        });
    }
};
