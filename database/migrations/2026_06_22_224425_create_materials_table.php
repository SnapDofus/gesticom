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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('quantity_planned', 10, 2)->default(0);
            $table->decimal('quantity_purchased', 10, 2)->default(0);
            $table->decimal('estimated_price', 12, 2)->default(0);
            $table->decimal('actual_price', 12, 2)->nullable();
            $table->string('supplier')->nullable();
            $table->date('purchase_date')->nullable();
            $table->enum('status', ['not_purchased', 'partially_purchased', 'fully_purchased'])->default('not_purchased');
            $table->text('observation')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
