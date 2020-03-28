<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactType extends Model
{
      use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'contact_type';
    protected $primaryKey = 'contactTypeId';
    protected $fillable   = ['contactTypeId','contactTypeName'];

    protected $dates = ['deleted_at'];
    
    //--------------------------------------------------------------------
    /** Relations */
    //--------------------------------------------------------------------
    public function client()
    {
        return $this->belongsToMany('App\Client', 'contactyTypeId', 'contactyTypeId');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
     public function findById($id)
    {
        return $this->where('contactTypeId', '=', $id)->get();
    }
    public function getAllByOffice($officeId)
    {
        return $this->where('officeId' , '=' , $officeId)
          ->orderBy('contactTypeName', 'ASC')
          ->get();
    }
//------------------------------------------
    public function insertCT($countryId,$officeId,$contactTypeName)
    {
        $contactType                  = new ContactType;
        $contactType->countryId       = $countryId;
        $contactType->officeId        = $officeId;
        $contactType->contactTypeName = $contactTypeName;
        $contactType->save();
    }

//------------------------------------------
    public function updateCT($contactTypeId, $contactTypeName)
    {
        $this->where('contactTypeId', $contactTypeId)->update(array(
            'contactTypeName' => $contactTypeName,
        ));
    }
//------------------------------------------
    public function deleteCT($contactTypeId)
    {
        return $this->where('contactTypeId', '=', $contactTypeId)->delete();
    }
//------------------------------------------
}
