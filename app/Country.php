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
    ];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function contract()
    {
        return $this->hasMany('App\Contract', 'countryId', 'countryId');
    }

// //--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('countryId', 'ASC')->get();
    }
    public function getAbbreviation($countryId){
        $rs = $this->where('countryId', $countryId)->get();
        return $rs[0]->abbreviation;
    }

}
