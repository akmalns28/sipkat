<?php

namespace App\Models;

use App\Traits\HashidsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Monitoring extends Model
{
    use HasFactory, HashidsTrait;

    protected $fillable =[
        'id_spantau',
        'signal',
        'alarm',
        'power_supply',
        'temp',
        'muka_air_tanah',
        'total_dissolve_solid',
        'daya_hantar_listrik',
    ];

    public function spantau(){
        return $this->belongsTo(SumurPantau::class,'id_spantau', 'id');
    }

    public function kondisi(){
        return $this->hasMany(Kondisi::class);
    }
}
