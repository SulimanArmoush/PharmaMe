<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('scName');
            $table->string('trName');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('manufacturer');
            $table->integer('quantity');
            $table->date('expDate');
            $table->double('price');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('midicines');
    }
};
