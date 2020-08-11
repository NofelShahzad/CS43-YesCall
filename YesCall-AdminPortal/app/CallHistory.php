<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallHistory extends Model
{
    //
    public function contacts(){
        return $this->belongsTo('App\Contact','contact_id');
    }
}
