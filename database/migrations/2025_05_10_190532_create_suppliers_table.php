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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name'); // اسم الشركة
            $table->string('contact_person_name')->nullable();
            $table->text('bio')->nullable();
            $table->string('phone')->unique(); // رقم الهاتف
            $table->string('email')->unique()->nullable(); // البريد الإلكتروني
            $table->string('password')->nullable();
            $table->text('address')->nullable(); // العنوان
            $table->enum('payment_method', ['cash' , 'bank_transfer', 'credit'])->default('cash');
            $table->decimal('credit_limit', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
