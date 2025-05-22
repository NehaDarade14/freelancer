<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('progress')->default(0)->after('status');
            $table->dateTime('completed_at')->nullable()->after('deadline');
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('progress');
            $table->dropColumn('completed_at');
        });
    }
};