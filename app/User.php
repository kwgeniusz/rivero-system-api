<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    public function getAuthPassword()
    {
        return $this->userPassword;
    }

    public function getEmailForPasswordReset()
    {
        return $this->userEmail;
    }
 

}
