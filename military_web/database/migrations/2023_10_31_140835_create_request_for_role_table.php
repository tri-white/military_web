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
        Schema::create('request_for_role', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_photo');
            $table->unsignedBigInteger('user_id'); // Зовнішній ключ для зв'язку з таблицею users
            $table->boolean('approved')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_for_role');
    }
};
