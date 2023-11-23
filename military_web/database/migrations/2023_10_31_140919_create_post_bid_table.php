<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_bid', function (Blueprint $table) {
            $table->id();
            $table->string('header');
            $table->text('content');
            $table->string('photo')->nullable();
            $table->timestamp('expiration_datetime')->default(now()->addWeeks(1));
            $table->decimal('current_bid', 10, 2);
            $table->decimal('buy_price', 10, 2);
            $table->unsignedBigInteger('category_id'); // Зовнішній ключ для зв'язку з таблицею category
            $table->unsignedBigInteger('user_id'); // Зовнішній ключ для зв'язку з таблицею users
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('post_bid');
    }
};
