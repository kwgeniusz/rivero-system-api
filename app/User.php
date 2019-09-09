<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

   /**ROLES USERS */
    const DIRECTOR = '1';
    const OFFICE_MANAGER = '2';
    const PROJECT_MANAGER = '3';
    const PROJECTIST = '4';
    const INFORMATIC = '5';
    const EMPLOYEE = '6';
    const SELLER = '7';
    const CLIENT = '8';

    protected $table ='user';
    protected $primaryKey = 'userId';
    public $timestamps    = false;
    protected $fillable = [
        'userId',
        'userTypeName',
        'userLevel',
        'countryId',
        'officeId',
        'userName',
        'userEmail',
        
    ];
    protected $hidden = [
        'userPassword','remember_token','dateCreated'
    ];
//--------------------------------------------------------------------
   /** Relations */
//--------------------------------------------------------------------  
public function country()
{
    return $this->belongsTo('App\Country', 'countryId');
}
public function office()
{
    return $this->belongsTo('App\Office', 'officeId');
}
//--------------------------------------------------------------------
   /**  */
//--------------------------------------------------------------------  

    public function getAuthPassword()
    {
        return $this->userPassword;
    }
   public function getAll()
    {
        return $this->orderBy('userId', 'ASC')
                    ->get();
    }
 
    public function changeOffice($id,$countryId,$officeId)
    {
          return $this->where('userId', $id)
                      ->update(array('countryId' => $countryId,
                                     'officeId'        => $officeId));
    }
 

}
