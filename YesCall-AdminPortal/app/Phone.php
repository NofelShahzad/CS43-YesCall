<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    //

    public function phone(){
        return $this->hasOne('App\UserPhone','user_id');
    }
}
