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
        Schema::create('employees_contact', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employees_id')->constrained('employees')->onDelete('cascade');  // foreign key employees_id
            $table->string('phone');
            $table->string('email');
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees_contact');
    }
};
