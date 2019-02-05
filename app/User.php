<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

   /**ROLES USERS */
    const DIRECTOR = '1';
    const ADMINISTRATOR = '2';
    const SUPERVISOR = '3';
    const EMPLOYEE = '4';
    const CLIENT = '5';
    
    const PROJECT = '6';
    const PROJECTIST_GENERAL = '7';
    const SELLER = '8';
    
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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'userPassword','remember_token','dateCreated'
    ];

    public function getAuthPassword()
    {
        return $this->userPassword;
    }

    
 

}
