<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    public $timestamps = false;

    protected $table      = 'acc_account_type';
    protected $primaryKey = 'accountTypeId';
    protected $fillable = ['accountTypeId','buildingCodeName','projectUseId'];

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
      ->orderBy('accountTypeId', 'ASC')
      ->get();

}

}
