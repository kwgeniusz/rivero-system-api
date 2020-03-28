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
        'language',
        'pCondName'
    ];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAllByLanguage()
    {
         //se trae las condiciones de pago por el lenguaje que esta en la tabla pais
        return $this->where('language' , '=' , session('countryLanguage'))
          ->orderBy('pCondId', 'ASC')
          ->get();

    }
}
