<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropForeign(['rarity_id']);

            $table->foreign('rarity_id')
                ->references('id')
                ->on('rarities')
                ->onDelete('cascade');
        });

        Schema::table('collections', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['card_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('card_id')
                ->references('id')
                ->on('cards')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropForeign(['rarity_id']);

            $table->foreign('rarity_id')
                ->references('id')
                ->on('rarities');
        });

        Schema::table('collections', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['card_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('card_id')
                ->references('id')
                ->on('cards');
        });
    }
};
