<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->string('plan_type'); // 3_months, 6_months, 12_months
            $table->integer('amount_paid'); // en centimes
            $table->string('currency', 3)->default('eur');
            
            $table->string('stripe_payment_intent_id')->unique();
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->enum('admin_status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->foreignId('processed_by')->nullable()->constrained('users');
            $table->timestamp('processed_at')->nullable();
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['admin_status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};