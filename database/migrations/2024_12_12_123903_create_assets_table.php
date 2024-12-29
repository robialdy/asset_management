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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('code_asset')->unique();
            $table->string('name')->unique();
            $table->string('slug');
            $table->string('category');
            $table->string('image')->nullable();
            $table->text('description');
            $table->date('added_date');
            $table->date('sent_date')->nullable();
            $table->date('return_date')->nullable();
            $table->date('destroy_date')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
