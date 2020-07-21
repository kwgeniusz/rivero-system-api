<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
      //traits
    use SoftDeletes;

    use Notifiable;
    use HasRoles;

    protected $table ='user';
    protected $primaryKey = 'userId';
    public $timestamps    = false;
    protected $fillable = [
        'userId',
        'countryId',
        'companyId',
        'defaultCountryId',
        'defaultcompanyId',
        'changeOffice',
        'fullName',
        'userName',
        'userLevel',
        'userName',
        'userEmail',
        
    ];
    protected $hidden = [
        'userPassword','remember_token','dateCreated'
    ];
//--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------
//FUNCION PARA PERMISOS EN COMPONENTES VUEJS//
    public function getAllPermissionsAttribute() {

      $permissions = [];

         foreach (Permission::all() as $permission) {
           if (Auth::user()->can($permission->name)) {
             $permissions[] = $permission->name;
           }
         }
    
         return $permissions;
 }

//--------------------------------------------------------------------
   /** Relations */
//--------------------------------------------------------------------  
public function country()
{
    return $this->belongsTo('App\Country', 'countryId');
}
public function company()
{
    return $this->belongsTo('App\Company', 'companyId');
}
//--------------------------------------------------------------------
   /** General Functions*/
//--------------------------------------------------------------------  
    public function findById($id)
    {
        return $this->where('userId', '=', $id)
                    ->get();
    }
    public function getAuthPassword()
    {
        return $this->userPassword;
    }
   public function getAll()
    {
        return $this->orderBy('userId', 'ASC')
                    ->get();
    }
 
    public function changeOffice($id,$countryId,$companyId)
    {
          return $this->where('userId', $id)
                      ->update(array('countryId' => $countryId,
                                     'companyId'  => $companyId));
    }

    public function insertU($values)
    {
        $user                = new User;
        $user->countryId     = $values['countryId'];
        $user->companyId      = $values['companyId'];
        $user->changeOffice  = $values['changeOffice'];
        $user->fullName      = $values['fullName'];
        $user->userName      = $values['userName'];
        $user->userPassword  = bcrypt($values['password']);
        $user->email         = $values['email'];
        $user->dateCreated   = date('Y-m-d H:i:s');
        $user->lastUserId    = Auth::user()->userId;
        $user->save();
    }
//------------------------------------------
    public function updateU($values,$id)
    {
        $this->where('userId', $id)->update(array(
            'countryId'      => $values['countryId'],
            'companyId'       => $values['companyId'],
            'changeOffice'   => $values['changeOffice'],
            'fullName'       => $values['fullName'],
            'userName'       => $values['userName'],
            'email'          => $values['email'],
        ));
    }
//------------------------------------------
    public function deleteU($id)
    {
          $this->where('userId', '=', $id)
               ->delete();
      }

}
