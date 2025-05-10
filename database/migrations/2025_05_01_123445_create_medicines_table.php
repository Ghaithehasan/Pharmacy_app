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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('medicine_name')->unique();
            $table->text('description')->nullable();
            $table->date('expiration_date')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnDelete()->cascadeOnUpdate();
            // $table->unsignedBigInteger('supplier_id')->nullable();
            // $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
