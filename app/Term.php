<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Term extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'term';
    protected $primaryKey = 'termId';
    protected $fillable = ['termId','countryId','companyId','termName','deleted_at'];

    protected $dates = ['deleted_at'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
     public function proposal()
    {
        return $this->belongsToMany('App\Proposal');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
     public function findById($id)
    {
        return $this->where('termId', '=', $id)
                    ->orderBy('termId', 'ASC')
                    ->get();
    }
    public function getAllByCompany($companyId)
    {
        return $this->where('companyId' , '=' , $companyId)
          ->orderBy('termId', 'ASC')
          ->get();
    }
//------------------------------------------
    public function insertT($countryId,$companyId,$termName)
    {
        $time                  = new Term;
        $time->countryId       = $countryId;
        $time->companyId       = $companyId;
        $time->termName        = $termName;
        $time->save();
    }

//------------------------------------------
    public function updateT($termId, $termName)
    {
        $this->where('termId', $termId)->update(array(
            'termName' => $termName,
        ));
    }
//------------------------------------------
    public function deleteT($termId)
    {
        return $this->where('termId', '=', $termId)->delete();
    }
//------------------------------------------
}
