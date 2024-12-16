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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_office')->nullable()->constrained('office')->onDelete('cascade')->onUpdate('cascade');
            $table->string('username')->unique();
            $table->string('department')->nullable();
            $table->string('email')->unique();
            $table->string('full_name');
            $table->string('phone', 15);
            $table->enum('role', ['Admin', 'User']);
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
