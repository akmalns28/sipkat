<?php

namespace App\Traits;

use Vinkla\Hashids\Facades\Hashids;

trait HashidsTrait
{
    public function getHashidAttribute()
    {
        return Hashids::connection('main')->encode($this->attributes['id']);
    }

    public static function decodeHashid($hashid)
    {
        return Hashids::connection('main')->decode($hashid);
    }

    public static function findByHashid($hashid)
    {
        $id = Hashids::connection('main')->decode($hashid);
        return isset($id[0]) ? self::find($id[0]) : null;
    }
}
