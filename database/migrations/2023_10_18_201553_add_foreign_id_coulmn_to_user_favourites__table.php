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
        Schema::table('user_favourites', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_favourites', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropForeign('user_favourites_user_id_foreign');
            $table->dropIndex('user_favourites_user_id_index');
            $table->dropColumn('item_id');
            $table->dropForeign('user_favourites_item_id_foreign');
            $table->dropIndex('user_favourites__item_id_index');

        });
    }
};
