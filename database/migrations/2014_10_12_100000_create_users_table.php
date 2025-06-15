<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // detail login
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('role_id');
            $table->integer('is_active')->default(0);
            $table->string('image')->nullable();

            // detail data diri
            $table->string('nik')->nullable();
            $table->string('nama')->nullable();
            $table->longText('bio')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->longText('alamat')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('status_kawin')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('config_user_roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
