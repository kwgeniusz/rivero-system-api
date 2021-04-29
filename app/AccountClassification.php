<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountClassification extends Model
{
    public $timestamps = false;

    protected $table      = 'acc_account_classification';
    protected $primaryKey = 'accountClassificationId';
    protected $fillable = ['accountClassificationId','countryId','accountClassificationCode','accountClassificationName'];

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
public function getAllByLanguage($language)
{
     //se trae las condiciones de pago por el lenguaje que esta en la tabla pais
    return $this->where('language' , '=' , $language)
      ->orderBy('accountClassificationId', 'ASC')
      ->get();

}
}
