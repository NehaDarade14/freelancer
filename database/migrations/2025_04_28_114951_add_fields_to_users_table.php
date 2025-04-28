<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('skills')->nullable();
            $table->string('experience')->nullable();
            $table->string('other')->nullable();
            $table->string('github_url')->nullable();
            $table->text('professional_bio')->nullable();
            $table->string('government_id')->nullable();
            $table->string('biometric_photo')->nullable();
            $table->string('signature_data')->nullable();
            $table->string('address_proof')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['skills', 'experience', 'other', 'github_url', 'professional_bio', 'government_id', 'biometric_photo', 'address_proof', 'signature_data']);
        });
    }
}
