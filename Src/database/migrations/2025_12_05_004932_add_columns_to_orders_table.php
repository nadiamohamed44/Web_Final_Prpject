<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // أضف كل الأعمدة الناقصة واحد بواحد
            if (!Schema::hasColumn('orders', 'total')) {
                $table->decimal('total', 10, 2)->after('user_id');
            }
            
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('pending')->after('total');
            }
            
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->after('status');
            }
            
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('payment_method');
            }
            
            if (!Schema::hasColumn('orders', 'address')) {
                $table->text('address')->after('payment_status');
            }
            
            if (!Schema::hasColumn('orders', 'phone')) {
                $table->string('phone')->after('address');
            }
            
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('phone');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = ['total', 'status', 'payment_method', 'payment_status', 'address', 'phone', 'notes'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};