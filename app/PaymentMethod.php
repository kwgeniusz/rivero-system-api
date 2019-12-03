<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table      = 'payment_method';
    protected $primaryKey = 'payMethodId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payMethodId',
        'payMethodCode',
        'payMethodLanguage',
        'payMethodName',
        'verify'
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

        return $this->where('payMethodLanguage' , '=' , $language)
          ->orderBy('payMethodCode', 'ASC')
          ->get();

    }
//------------------------------------------
    public function ifIsInProcess($payMethodCode)
    {
        $paymentMethod = $this->select('verify')
          ->where('payMethodCode' , '=' , $payMethodCode)
          ->first();

           return $paymentMethod->verify;
    }
//------------------------------------------
//-----------
}
