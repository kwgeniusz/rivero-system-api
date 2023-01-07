<?php

namespace App\Models\Intercompany;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Company;
use App\Note;

class NoteEquivalence extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'intercompany_note_equivalence';
    protected $primaryKey = 'noteEquivId';
    protected $fillable   = ['originNoteId', 'originCompanyId', 'destinationNoteId', 'destinationCompanyId'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------

   public function destinationCompany()
   {
    return $this->hasOne(Company::class, 'companyId', 'destinationCompanyId');
   }

   public function destinationNote()
   {
    return $this->hasOne(Note::class, 'noteId', 'destinationNoteId');
   }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
  public function findById($id)
    {
        return $this->where('noteId', '=', $id)->get();
    }
//------------------------------------------
    public function insertS($localNote,$destinationNote)
    {             
        $equivalence                       = new NoteEquivalence;
        $equivalence->originNoteId      = $localNote['noteId'];
        $equivalence->originCompanyId      = $localNote['companyId'];
        $equivalence->destinationNoteId = $destinationNote['noteId'];
        $equivalence->destinationCompanyId = $destinationNote['companyId'];
        $equivalence->save();
    }
//------------------------------------------
    public function deleteS($noteId)
    {
        return $this->where('noteId', '=', $noteId)->delete();
    }
//------------------------------------------


}
