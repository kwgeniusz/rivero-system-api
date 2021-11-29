<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table      = 'country';
    protected $primaryKey = 'countryId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'countryId',
        'countryName',
        'language',
    ];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function contract()
    {
        return $this->hasMany('App\Contract', 'countryId', 'countryId');
    }
    public function countryConfiguration()
    {
        return $this->hasOne('App\CountryConfiguration', 'countryId', 'countryId');
    }

// //--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function findById($countryId)
    {
        return $this->where('countryId', '=', $countryId)->get();
    }
    // Obtener todos los registro
    public function getAll()
    {
        return $this->orderBy('countryId', 'ASC')->get();
    }

    // public function getAbbreviation($countryId){
    //     $rs = $this->where('countryId', $countryId)->get();
    //     return $rs[0]->abbreviation;
    // }

   // public function getLanguage($countryId){
   //      $rs = $this->where('countryId', $countryId)->get();
   //      return $rs[0]->language;
   //  }
}
