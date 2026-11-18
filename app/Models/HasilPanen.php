<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPanen extends Model
{
    protected $table = 'hasil_panen';
    protected $primaryKey = 'id_hasil';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_blok',
        'id_petugas',
        'tanggal_panen',
        'berat_tbs_kg',
        'keterangan',
    ];

    // Relasi ke Blok
    public function blok()
    {
        return $this->belongsTo(Blok::class, 'id_blok', 'id_blok');
    }

    // Relasi ke Petugas (User)
    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_petugas', 'id');
    }
}