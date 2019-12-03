<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class PaymentCondition extends Model
{
    protected $table      = 'payment_condition';
    protected $primaryKey = 'pCondId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pCondId',
        'pCondCode',
        'pCondLanguage',
        'pCondName'
    ];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAllByLanguage($countryId)
    {
         if($countryId == '1') { //DALLAS
            $language = 'en';
        } elseif($countryId == '2') { //VENEZUELA
            $language = 'es';
        }

        return $this->where('pCondLanguage' , '=' , $language)
          ->orderBy('pCondId', 'ASC')
          ->get();

    }
}
