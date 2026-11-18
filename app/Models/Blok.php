<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blok extends Model
{
    protected $table = 'blok';
    protected $primaryKey = 'id_blok';

    protected $fillable = [
        'id_kebun',
        'kode_blok',
        'nama_blok',
        'luas_hektare',
    ];

    public function kebun()
    {
        return $this->belongsTo(Kebun::class, 'id_kebun', 'id_kebun');
    }

    public function hasilPanen()
    {
        return $this->hasMany(HasilPanen::class, 'id_blok', 'id_blok');
    }
}