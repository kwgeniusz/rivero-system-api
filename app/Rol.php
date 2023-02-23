<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
   /**ROLES USERS */
    // const DIRECTOR = '1';
    // const OFFICE_MANAGER = '2';
    // const PROJECT_MANAGER = '3';
    // const PROJECTIST = '4';
    // const INFORMATIC = '5';
    // const EMPLOYEE = '6';
    // const SELLER = '7';
    // const CLIENT = '8';

    public $timestamps = false;

    protected $table      = 'Roles';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id',
        'name',
        'guard_name',
    ];
//--------------------------------------------------------------------
   /** Relations */
//--------------------------------------------------------------------  

//--------------------------------------------------------------------
   /**  */
//--------------------------------------------------------------------  

   public function getAll()
    {
        return $this->orderBy('id', 'ASC')
                    ->get();
    }
 


}
