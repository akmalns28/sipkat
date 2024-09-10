<?php

namespace App\Models;

use App\Traits\HashidsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SumurPantau extends Model
{
    use HasFactory, HashidsTrait;

    protected $fillable= [
        'id_user',
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
        'kelurahan_id',
        'kode_sumur_pantau',
        'no_inventarisasi',
        'alamat',
        'lokasi',
        'longitude',
        'latitude',
        'foto',
        'status'
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
    
    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }
    
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
    
    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }
    
    
    public function logbook(){
        return $this->hasMany(Logbook::class);
    }

    public function monitroing(){
        return $this->hasMany(Kondisi::class);
    }

    public function kondisi(){
        return $this->hasMany(Kondisi::class);
    }
}
