<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function roles(){

        return $this->belongsToMany(Rule::class,'user_rule','user_id','rule_id');
    }
    public function hasAnyRole($roles){
        if(is_array($roles)){

            foreach($roles as $role){
                if($this->hasRole($role)){
                    return true;
                }
            }
        }else{
            if($this->hasRole($roles)){
                return true;
            }
            return false;
        }


    }
    public function hasRole($role){

        if($this->roles()->where('name',$role)->first()){
            return true;
        }
        return false;
    }
    public function userInfo(){

        return $this->hasOne('App\UserInfo','user_id');
    }


    public function modules(){

        return $this->belongsToMany(Module::class,'module_rules','user_id','module_id');
    }
    public function hasAnyModule($roles){
        if(is_array($roles)){

            foreach($roles as $role){
                if($this->hasModule($role)){
                    return true;
                }
            }
        }else{
            if($this->hasModule($roles)){
                return true;
            }
            return false;
        }


    }
    public function hasModule($role){

        if($this->modules()->where('name',$role)->first()){
            return true;
        }
        return false;
    }

    public function orders(){

        return $this->hasMany('App\Order','user_id');
    }
    public function userInformation(){
        return $this->hasOne('App\UserInfo','user_id');
    }
    public function startclass(){
        return $this->hasMany('App\StartClass','student_id');


    }
    public function assignedTeacher(){
        return $this->hasOne('App\AssignTeacher','student_id');
    }


    public function phone(){
        return $this->hasOne('App\UserPhone','user_id');
    }
}
