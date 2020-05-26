<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingCodeGroup extends Model
{
    public $timestamps = false;

    protected $table      = 'building_code_group';
    protected $primaryKey = 'groupId';
    protected $fillable = ['groupId','buildingCodeId','groupName'];

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
    //  public function findById($id)
    // {
    //     return $this->where('groupId', '=', $id)->get();
    // }
    // public function getAll()
    // {
    //     return $this->orderBy('groupId', 'ASC')
    //                 ->get();
    // }

}
