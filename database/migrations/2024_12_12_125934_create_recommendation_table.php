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
        Schema::create('recommendation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_admin')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('required_item')->nullable();
            $table->enum('category', ['Submission', 'Rejuvenation', 'Destroy', 'Return']);
            $table->string('purpose_of')->nullable();
            $table->foreignId('id_asset')->constrained('assets')->onDelete('cascade')->onUpdate('cascade');
            $table->string('status');
            $table->text('description');
            $table->text('admin_reply')->nullable();
            $table->date('approved_at')->nullable();
            $table->date('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendation');
    }
};
