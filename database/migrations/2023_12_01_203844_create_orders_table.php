<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('Users')->onDelete('cascade');
            $table->foreignId('from_id')->constrained('Users')->onDelete('cascade');
            $table->double('totalPrice');
            $table->set('status', ['Preparation', 'Sent', 'Received'])->default('Preparation');
            $table->set('paymentStatus',['Paid', 'UnPaid'])->default('UnPaid');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
