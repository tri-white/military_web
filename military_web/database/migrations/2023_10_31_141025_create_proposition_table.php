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
        Schema::create('proposition', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 10, 2);
            $table->string('photo')->nullable();
            $table->text('message');
            $table->unsignedBigInteger('post_ask_id'); // Зовнішній ключ для зв'язку з таблицею post_ask
            $table->unsignedBigInteger('user_id'); // Зовнішній ключ для зв'язку з таблицею users
            $table->timestamps();

            $table->foreign('post_ask_id')->references('id')->on('post_ask');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposition');
    }
};
