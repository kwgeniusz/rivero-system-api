<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingCode extends Model
{
    public $timestamps = false;

    protected $table      = 'building_code';
    protected $primaryKey = 'buildingCodeId';
    protected $fillable = ['buildingCodeId','buildingCodeName','projectUseId'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
     public function projectUse()
    {
        return $this->belongsToMany('App\ProjectUse');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
     public function findById($id)
    {
        return $this->where('buildingCodeId', '=', $id)->get();
    }
    public function getAll()
    {
        return $this->orderBy('buildingCodeId', 'ASC')
                    ->get();
    }

}
