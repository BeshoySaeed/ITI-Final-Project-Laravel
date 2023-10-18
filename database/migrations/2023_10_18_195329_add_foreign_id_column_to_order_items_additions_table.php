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
        Schema::table('order_item_additions', function (Blueprint $table) {
            $table->foreignId('order_item_id')->constrained('order_items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('addition_id')->constrained('additions')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items_additions', function (Blueprint $table) {
            $table->dropColumn('order_item_id');
            $table->dropForeign('order_items_additions_order_item_id_foreign');
            $table->dropIndex('order_items_additions_order_item_id_index');
            $table->dropColumn('addition_id');
            $table->dropForeign('order_items_additions_addition_id_foreign');
            $table->dropIndex('order_items_additions_addition_id_index');
        });
    }
};
