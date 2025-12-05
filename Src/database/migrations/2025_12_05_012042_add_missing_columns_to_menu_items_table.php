<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            // أضف الحقول الناقصة
            if (!Schema::hasColumn('menu_items', 'stock_quantity')) {
                $table->integer('stock_quantity')->default(0)->after('is_available');
            }
            
            if (!Schema::hasColumn('menu_items', 'category_id')) {
                $table->foreignId('category_id')->nullable()->constrained()->after('stock_quantity');
            }
        });
    }

    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            // Rollback
            $columns = ['stock_quantity', 'category_id'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('menu_items', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};