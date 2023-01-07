<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Intercompany\TermEquivalence;

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

    public function termEquivalence()
    {
        return $this->hasOne(TermEquivalence::class, 'originTermId', 'termId')
                 ->with('destinationCompany','destinationTerm');
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
          ->orderBy('termName', 'ASC')
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
public function getAllByCompanyWithLinkedTerm($companyId,$linkedCompanyId)
{
    return $this->with(['termEquivalence' => function($q) use($linkedCompanyId){ 
        $q->where('destinationCompanyId', $linkedCompanyId);
    }])->where('companyId' , '=' , $companyId)
       ->orderBy('termName', 'ASC')
       ->get();
}

public function destinationTermWithOriginLink($companyId,$companyId2)
{

      return $this->leftjoin('intercompany_term_equivalence',  function($join) use($companyId2) {
             $join->on('term.termId', '=', 'intercompany_term_equivalence.destinationTermId')->where('originCompanyId', '=', $companyId2);
        })->where('companyId' , '=' , $companyId)
          ->orderBy('termName', 'ASC')
          ->get();
}

}
