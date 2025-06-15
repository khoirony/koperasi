<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjamans';

    protected $guarded = ['id'];

    public function peminjam() 
	{
		return $this->belongsTo(User::class, 'id_peminjam');
	}
    public function pegawai() 
	{
		return $this->belongsTo(User::class, 'id_pegawai');
	}
}
