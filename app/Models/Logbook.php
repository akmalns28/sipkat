<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable= [
        'id_user',
        'id_spantau',
        'zat',
        'nilai',
        'kondisi',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function spantau(){
        return $this->belongsTo(SumurPantau::class, 'id_spantau', 'id');
    }

}
