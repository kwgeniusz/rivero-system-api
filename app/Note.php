<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


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
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
     public function findById($id)
    {
        return $this->where('noteId', '=', $id)->get();
    }
    public function getAllByOffice($officeId)
    {
        return $this->where('officeId' , '=' , $officeId)
          ->orderBy('noteId', 'ASC')
          ->get();
    }
//------------------------------------------
    public function insertN($countryId,$officeId,$noteName)
    {
        $note                  = new Note;
        $note->countryId     = $countryId;
        $note->officeId     = $officeId;
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
}
