<?php

namespace App;


use App\Staff;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public  $timestamps = false;
  
    protected $table ='position';
    protected $primaryKey = 'positionId';

    protected $fillable = [
        'positionId' ,
        'positionName' 	
    ];
//--------------------------------------------------------------------
/** Relations */
//--------------------------------------------------------------------  
}
