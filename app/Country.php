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

    public function contract()
    {
        return $this->hasMany('App\Contract', 'countryId', 'countryId');
    }

    public function getAbbreviation($countryId){
        $rs = $this->where('countryId', $countryId)->get();
        return $rs[0]->abbreviation;
    }

}
