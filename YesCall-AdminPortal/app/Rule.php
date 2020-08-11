<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    //
    public function users(){
        return $this->belongsToMany('App\User','user_rule','rule_id','user_id');
    }
}
