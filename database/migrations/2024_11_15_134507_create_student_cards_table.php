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
        Schema::create('student_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assuming users table exists
            $table->foreignId('vocabulary_id')->constrained('vocabularies')->onDelete('cascade');
            $table->foreignId('study_method_id')->constrained('study_methods')->onDelete('cascade');
            $table->integer('level')->default(1);
            $table->timestamp('last_studied_at')->nullable();
            $table->timestamp('next_review_at')->nullable();
            $table->text('question')->nullable();
            $table->timestamps();
        });
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_cards');
    }
};
