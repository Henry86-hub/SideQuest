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
        Schema::create('quests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('reward'); // e.g. "300 Gold Coins", "100 Gold & Potion"
            $table->enum('difficulty', ['F', 'E', 'D', 'C', 'B', 'A', 'S'])->default('F');
            $table->string('status')->default('available'); // available, claimed, in_progress, under_review, completed
            $table->dateTime('deadline')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quests');
    }
};
