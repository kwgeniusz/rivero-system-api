<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceivableStatus extends Model
{
    protected $table      = 'receivable_status';
    protected $primaryKey = 'recStatusId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recStatusId',
        'recCode',
        'recLanguage',
        'recName',
        'pending'
    ];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
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

        return $this->where('recLanguage' , '=' , $language)
          ->orderBy('recCode', 'ASC')
          ->get();

    }
//------------------------------------------
//-----------
}
