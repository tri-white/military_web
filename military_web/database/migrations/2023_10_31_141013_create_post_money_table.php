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
        Schema::create('post_money', function (Blueprint $table) {
            $table->id();
            $table->decimal('goal_amount', 10, 2);
            $table->decimal('current_amount', 10, 2);
            $table->unsignedBigInteger('category_id'); // Зовнішній ключ для зв'язку з таблицею category
            $table->unsignedBigInteger('user_id'); // Зовнішній ключ для зв'язку з таблицею users
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_money');
    }
};
