<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequestForRoleTable extends Migration
{
    public function up()
    {
        Schema::table('request_for_role', function (Blueprint $table) {
            $table->enum('approved', ['Очікування', 'Відмовлено', 'Підтверджено'])->default('Очікування')->change();
        });
    }

    public function down()
    {
        Schema::table('request_for_role', function (Blueprint $table) {
            $table->boolean('approved')->default(0)->change();
        });
    }
}
