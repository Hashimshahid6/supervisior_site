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
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_email');
            $table->string('company_phone');
            $table->string('company_address');
            $table->string('company_city')->nullable();
            $table->string('company_country')->nullable();
            $table->string('company_postal_code')->nullable();
            $table->string('company_logo');
            $table->string('company_favicon');
            $table->text('company_description');
            $table->string('company_facebook')->nullable();
            $table->string('company_twitter')->nullable();
            $table->string('company_instagram')->nullable();
            $table->string('company_linkedin')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
