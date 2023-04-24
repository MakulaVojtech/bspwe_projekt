<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('domain_details', function (Blueprint $table) {
            $table->id();
            $table->string('domain_name');
            $table->string('ftp_user');
            $table->string('ftp_password');
            $table->string('db_name');
            $table->string('db_user');
            $table->string('db_password');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('domain_details');
    }

};
