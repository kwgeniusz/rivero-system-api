<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountClassification extends Model
{
    public $timestamps = false;

    protected $table      = 'acc_account_classification';
    protected $primaryKey = 'accountClassificationId';
    protected $fillable = ['accountClassificationId','buildingCodeName','projectUseId'];

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
    //  public function findById($id)
    // {
    //     return $this->where('buildingCodeId', '=', $id)->get();
    // }
    // public function getAll()
    // {
    //     return $this->orderBy('buildingCodeId', 'ASC')
    //                 ->get();
    // }

}
