<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    public $timestamps = false;

    protected $table      = 'note';
    protected $primaryKey = 'noteId';
    protected $fillable = ['noteId','noteCode','noteLanguage','noteName'];


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
    public function getAllByLanguage($countryId)
    {
        if($countryId == '1') { //DALLAS
            $language = 'en';
        } elseif($countryId == '2') { //VENEZUELA
            $language = 'es';
        }

        return $this->where('noteLanguage' , '=' , $language)
          ->orderBy('noteId', 'ASC')
          ->get();
    }
// //------------------------------------------
//     public function insertNote($clientName, $clientDescription, $clientAddress, $clientPhone, $clientEmail)
//     {

//         $client                    = new Client;
//         $client->userId            = 1;
//         $client->clientName        = $clientName;
//         $client->clientDescription = $clientDescription;
//         $client->clientAddress     = $clientAddress;
//         $client->clientPhone       = $clientPhone;
//         $client->clientEmail       = $clientEmail;
//         $client->dateCreated       = date('Y-m-d H:i:s');
//         $client->lastUserId        = Auth::user()->userId;
//         $client->save();
//     }

// //------------------------------------------
//     public function deleteNote($clientId)
//     {
//         return $this->where('clientId', '=', $clientId)->delete();
//     }
// //------------------------------------------
}
