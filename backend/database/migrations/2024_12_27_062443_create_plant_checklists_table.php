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
        Schema::create('plant_checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plant_type');
            $table->string('item_name');
            $table->enum('day', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->text('value')->nullable();
            $table->text('defect')->nullable();
            $table->date('date_reported')->nullable();
            $table->boolean('useable')->default(true);
            $table->string('reported_to')->nullable();
            $table->string('operator')->nullable();
            $table->enum('status', ['incomplete', 'complete'])->default('incomplete');
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
        Schema::dropIfExists('plant_checklists');
    }
};
