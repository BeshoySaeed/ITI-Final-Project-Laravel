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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->default(1)->constrained('roles')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            $table->foreignId('subscribe_id')->nullable()->constrained('subscription_plans')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');
            $table->dropForeign('users_role_id_foreign');
            $table->dropIndex('users_role_id_index');
            $table->dropColumn('subscribe_id');
            $table->dropForeign('users_subscribe_id_foreign');
            $table->dropIndex('users_subscribe_id_index');
        });
    }
};
