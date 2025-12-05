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

            // علاقة التصنيف
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            // بيانات المنتج
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);

            // الصورة
            $table->string('image')->nullable();  // ← هذا ما يستخدمه الـ Controller

            // الكمية
            $table->integer('stock')->default(0);

            // حالة المنتج
            $table->boolean('is_available')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
