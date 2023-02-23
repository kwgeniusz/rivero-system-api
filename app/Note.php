<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Intercompany\NoteEquivalence;


class Note extends Model
{
      use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'note';
    protected $primaryKey = 'noteId';
    protected $fillable = ['noteId','noteCode','noteLanguage','noteName'];

    protected $dates = ['deleted_at'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------

     public function invoice()
    {
        return $this->belongsToMany('App\Invoice');
    }

    public function noteEquivalence()
    {
        return $this->hasOne(NoteEquivalence::class, 'originNoteId', 'noteId')
                 ->with('destinationCompany','destinationNote');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
     public function findById($id)
    {
        return $this->where('noteId', '=', $id)->get();
    }
    public function getAllByOffice($companyId)
    {
        return $this->where('companyId' , '=' , $companyId)
          ->orderBy('noteName', 'ASC')
          ->get();
    }
//------------------------------------------
    public function insertN($countryId,$companyId,$noteName)
    {
        $note                  = new Note;
        $note->countryId     = $countryId;
        $note->companyId     = $companyId;
        $note->noteName     = $noteName;
        $note->save();
    }

//------------------------------------------
    public function updateN($noteId, $noteName)
    {
        $this->where('noteId', $noteId)->update(array(
            'noteName' => $noteName,
        ));
    }
//------------------------------------------
    public function deleteN($noteId)
    {
        return $this->where('noteId', '=', $noteId)->delete();
    }
//------------------------------------------

public function getAllByCompanyWithLinkedNote($companyId,$linkedCompanyId)
{
    return $this->with(['noteEquivalence' => function($q) use($linkedCompanyId){ 
        $q->where('destinationCompanyId', $linkedCompanyId);
    }])->where('companyId' , '=' , $companyId)
       ->orderBy('noteName', 'ASC')
       ->get();
}

public function destinationNoteWithOriginLink($companyId,$companyId2)
{

      return $this->leftjoin('intercompany_note_equivalence',  function($join) use($companyId2) {
             $join->on('note.noteId', '=', 'intercompany_note_equivalence.destinationNoteId')->where('originCompanyId', '=', $companyId2);
        })->where('companyId' , '=' , $companyId)
          ->orderBy('noteName', 'ASC')
          ->get();
}

}
