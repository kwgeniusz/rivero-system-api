<?php

namespace App\Models\Intercompany;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Company;
use App\Term;

class TermEquivalence extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'intercompany_term_equivalence';
    protected $primaryKey = 'termEquivId';
    protected $fillable   = ['originTermId', 'originCompanyId', 'destinationTermId', 'destinationCompanyId','unit2','cost1','cost2','variableName'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------

   public function destinationCompany()
   {
    return $this->hasOne(Company::class, 'companyId', 'destinationCompanyId');
   }

   public function destinationTerm()
   {
    return $this->hasOne(Term::class, 'termId', 'destinationTermId');
   }

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
  public function findById($id)
    {
        return $this->where('termId', '=', $id)->get();
    }
//------------------------------------------
    public function insertS($localService,$destinationTerm)
    {             
        $equivalence                       = new TermEquivalence;
        $equivalence->originTermId      = $localService['termId'];
        $equivalence->originCompanyId      = $localService['companyId'];
        $equivalence->destinationTermId = $destinationTerm['termId'];
        $equivalence->destinationCompanyId = $destinationTerm['companyId'];
        $equivalence->save();
    }
//------------------------------------------
    public function deleteS($termId)
    {
        return $this->where('termId', '=', $termId)->delete();
    }
//------------------------------------------


}
