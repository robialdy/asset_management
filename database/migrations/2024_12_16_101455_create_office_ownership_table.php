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
        Schema::create('office_ownership', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_office')->constrained('office')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_asset')->constrained('assets')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_ownership');
    }
};
