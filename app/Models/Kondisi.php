<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kondisi extends Model
{
    use HasFactory;

    protected $fillable= [
        'id_monitoring',
        'kondisi',
        'catatan',
        'updated_by',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function monitoring(){
        return $this->belongsTo(Monitoring::class, 'id_monitoring', 'id');
    }
}
