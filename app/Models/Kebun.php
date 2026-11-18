<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kebun extends Model
{
    protected $table = 'kebun';
    protected $primaryKey = 'id_kebun';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_pemilik',
        'nama_kebun',
        'lokasi',
        'keterangan',
    ];

    // WAJIB DITAMBAHKAN untuk Route Resource
    public function getRouteKeyName()
    {
        return 'id_kebun';
    }

    // Relasi ke Blok
    public function blok()
    {
        return $this->hasMany(Blok::class, 'id_kebun', 'id_kebun');
    }

    // Relasi ke Pemilik
    public function pemilik()
    {
        return $this->belongsTo(User::class, 'id_pemilik');
    }
}