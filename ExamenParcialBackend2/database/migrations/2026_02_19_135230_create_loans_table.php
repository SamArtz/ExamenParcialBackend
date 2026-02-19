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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            // relacion con libros
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->string('applicant_name');
            $table->timestamp('loan_date'); 
            $table->timestamp('return_date')->nullable();
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
