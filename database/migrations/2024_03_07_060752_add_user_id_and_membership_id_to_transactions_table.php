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
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignUuid('user_id')->after('id')->constrained();
            $table->foreignUuid('membership_id')->after('user_id')->constrained();
            // $table->unsignedBigInteger('user_id')->after('id');
            // $table->unsignedBigInteger('membership_id')->after('user_id');

            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('membership_id')->references('id')->on('memberships');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['membership_id']);
        });
    }
};
