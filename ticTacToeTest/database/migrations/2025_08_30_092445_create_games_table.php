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
        Schema::create('games', function (Blueprint $table) {
        $table->id();
        // Board stored as 9-char string: '---------','X--O---X-','XO...'
        $table->char('board', 9)->default('---------');
        $table->enum('current_player', ['X','O'])->default('X');
        $table->enum('status', ['IN_PROGRESS','X_WON','O_WON','DRAW'])->default('IN_PROGRESS');
        $table->enum('winner', ['X','O'])->nullable();
        $table->timestamp('started_at')->useCurrent();
        $table->timestamp('finished_at')->nullable();
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
