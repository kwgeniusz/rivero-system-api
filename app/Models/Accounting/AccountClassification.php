<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class AccountClassification extends Model
{
    public $timestamps = false;

    protected $table      = 'acc_account_classification';
    protected $primaryKey = 'accountClassificationId';
    protected $fillable = ['accountClassificationId','countryId','accountClassificationCode','accountClassificationName'];
   
   //Account Classification Codes
   const ASSETS    = '1';
   const LIABILITIES   = '2';
   const STOCKHOLDERS  = '3';
   const INCOME = '4';
   const EXPENSES = '5';
   const TAXES = '6';
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    //  public function projectUse()
    // {
    //     return $this->belongsToMany('App\ProjectUse');
    // }
    //     public function group()
    // {
    //     return $this->hasMany('App\BuildingCodeGroup','buildingCodeId','buildingCodeId');
    // }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
public function getAllByCountry($countryId)
{
     //se trae las condiciones de pago por el lenguaje que esta en la tabla pais
    return $this->where('countryId' , '=' , $countryId)
      ->orderBy('accountClassificationId', 'ASC')
      ->get();

}
}
