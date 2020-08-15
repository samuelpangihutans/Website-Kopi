<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    //
       //table name
       protected $table='order';
       //primary key
       public $primaryKey='id';
       //Timestamps
       public $timestamps=true;
   
}
