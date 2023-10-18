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
        Schema::table('item_additions', function (Blueprint $table) {
            $table->foreignId('item_id')->constrained('items')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->foreignId('addition_id')->constrained('additions')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_additions', function (Blueprint $table) {
            $table->dropColumn('item_id');
            $table->dropForeign('item_additions_item_id_foreign');
            $table->dropIndex('items_additions_item_id_index');
            $table->dropColumn('addition_id');
            $table->dropForeign('additions_addition_id_foreign');
            $table->dropIndex('additions_addition_id_index');
        });
    }
};
