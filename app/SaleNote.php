<?php

namespace App;

use App;
use App\Country;
use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

 class SaleNote extends Model
{
    //traits
    // use SoftDeletes;
    public $timestamps = false;

    protected $table      = 'sale_note';
    protected $primaryKey = 'salNoteId';
    protected $fillable   = ['salNoteId','invoiceId','clientId','reference','dateNote','concept','netTotal','noteType'];
    protected $appends    = ['netTotal'];
     // protected $dates = ['deleted_at'];
     
    //PARA EVITAR LOS NUMEROS MAGICOS
    const CREDIT = '1';
    const DEBIT  = '2';

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------

//--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------
    public function getNetTotalAttribute($netTotal)
    {
          return decrypt($this->attributes['netTotal']);
    }
//--------------------------------------------------------------------
    /** Mutadores  */
//--------------------------------------------------------------------
     public function setNetTotalAttribute($netTotal)
    {
        $netTotal = number_format((float)$netTotal, 2, '.', '');
        return $this->attributes['netTotal'] = encrypt($netTotal);
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAllByType($invoiceId,$noteType)
    {
        return $this->where('invoiceId', $invoiceId)
                    ->where('noteType', $noteType)
                    ->get();
    }
}
