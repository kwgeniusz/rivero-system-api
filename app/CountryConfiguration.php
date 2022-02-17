<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryConfiguration extends Model
{
    public $timestamps = false;

    protected $table      = 'country_configuration';
    protected $primaryKey = 'countryConfigId';
    protected $fillable   = [
                            'countryConfigId',
                            'countryId',
                            'language',
                            'format_date',
                            'clientNumber'
                            ];
    protected $dates      = ['dateCreated'];

// relations
    public function primaryCurrency()
    {
        return $this->belongsTo('App\Currency', 'currency1Id', 'currencyId');
    }
    public function secondaryCurrency()
    {
        return $this->belongsTo('App\Currency', 'currency2Id', 'currencyId');
    }
}