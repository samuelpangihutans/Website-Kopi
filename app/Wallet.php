<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
        //table name
        protected $table='wallet';
        //primary key
        public $primaryKey='id';
        //Timestamps
        public $timestamps=true;
}
