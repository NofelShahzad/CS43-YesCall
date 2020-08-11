<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPhone extends Model
{
    //
    public function myphone(){
        return $this->belongsTo('App\Phone','phone_id');
    }
}
