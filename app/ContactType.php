<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{

    public $timestamps = false;

    protected $table      = 'contact_type';
    protected $primaryKey = 'contactTypeId';
    protected $fillable   = ['contactTypeId','contactTypeName'];
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
    public function getAll()
    {
        return $this->orderBy('contactTypeId', 'ASC')->get();
    }

}
