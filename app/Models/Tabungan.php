<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    use HasFactory;

    protected $table = 'tabungans';

    protected $guarded = ['id'];

    public function nasabah() 
	{
		return $this->belongsTo(User::class, 'id_nasabah');
	}
}
