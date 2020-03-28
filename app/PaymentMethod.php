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
        'officeId',
        'payMethodName',
        'verify'
    ];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('payMethodName', 'ASC')
                    ->get();

    }
//------------------------------------------
    public function ifIsInProcess($payMethodId)
    {
        $paymentMethod = $this->select('verify')
          ->where('payMethodId' , '=' , $payMethodId)
          ->first();

           return $paymentMethod->verify;
    }
//------------------------------------------
//-----------
}
