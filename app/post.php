<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    //table name
    protected $table='posts';
    //primary key
    public $primaryKey='id';
    //Timestamps
    public $timestamps=true;


    public function user(){
        return $this->hasMany('App\User');
    }
}
