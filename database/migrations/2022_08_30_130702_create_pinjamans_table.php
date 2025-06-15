<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinjamansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjamans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_peminjam')->nullable();
            $table->unsignedBigInteger('id_pegawai')->nullable();
            $table->bigInteger('jumlah')->nullable();
            $table->integer('jangka_waktu')->nullable();
            $table->double('bunga_perbulan',2)->nullable();
            $table->unsignedBigInteger('status_pinjaman')->nullable();
            $table->text('tujuan_pinjaman')->nullable();
            $table->text('tanggapan')->nullable();
            $table->string('nota')->nullable();

            // detail data diri
            $table->string('nik')->nullable();
            $table->string('nama')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->longText('alamat')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('status_kawin')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->timestamps();

            $table->foreign('id_peminjam')->references('id')->on('users');  
            $table->foreign('id_pegawai')->references('id')->on('users'); 
            $table->foreign('status_pinjaman')->references('id')->on('config_status_pinjamans'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aduans');
    }
}
