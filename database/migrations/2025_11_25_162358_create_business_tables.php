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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('category');
            $table->decimal('price', 15, 2);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->decimal('total_amount', 15, 2);
            $table->enum('status', ['paid', 'pending', 'cancelled'])->default('pending');
            $table->timestamps();
        });

        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained();
            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });

        Schema::create('cashflows', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 15, 2);
            $table->string('description');
            $table->string('category');
            $table->date('date');
            $table->timestamps();
        });

        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role'); // Owner, Admin, Cashier
            $table->enum('status', ['active', 'invited', 'inactive'])->default('invited');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });

        Schema::create('hpp_calculations', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->decimal('material_cost', 15, 2)->default(0);
            $table->decimal('labor_cost', 15, 2)->default(0);
            $table->decimal('overhead_cost', 15, 2)->default(0);
            $table->decimal('total_hpp', 15, 2);
            $table->decimal('margin_percentage', 5, 2)->default(0);
            $table->decimal('selling_price', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hpp_calculations');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('cashflows');
        Schema::dropIfExists('transaction_items');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('products');
    }
};
