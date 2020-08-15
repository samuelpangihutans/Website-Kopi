<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
     //table name
     protected $table='transaction';
     //primary key
     public $primaryKey='id';
     //Timestamps
     public $timestamps=true;
}
