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
        Schema::table('user_phones', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_phones', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropForeign('users_phones_user_id_foreign');
            $table->dropIndex('users_phones_user_id_index');
        });
    }
};
