<?php

namespace App;

use App;
use DB;
use Auth;
use App\Helpers\DateHelper;

use Illuminate\Database\Eloquent\Model;

class Payable extends Model
{

    protected $table      = 'payable';
    protected $primaryKey = 'payableId';
    public $timestamps    = false;

    // protected $appends = ['amountDue','amountPaid','amountPercentaje'];

    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
       'payableId',
       'countryId',
       'officeId',
       'amountDue',
       'amountPaid',
       'cashboxId',
       'accountId',
       'datePaid',
       'subcontInvDetailId',
       'userId',
       'payStatusCode'
    ];
    //RECEIVABLE STATUS
    const STATELESS     = '1';
    const PROCESS     = '2';
    const DECLINED    = '3';
    const SUCCESS   = '4';

//------------ACCESORES-----------------//
    public function getAmountDueAttribute($amountDue)
    {
       return decrypt($this->attributes['amountDue']);
    }
    public function getAmountPaidAttribute($amountPaid)
    {
        return decrypt($this->attributes['amountPaid']);
    }
    public function getDatePaidAttribute($datePaid)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
         $newDate    = $oDateHelper->$functionRs($datePaid);
        return $newDate;
    }

// //------------MUTADORES-----------------//
    public function setAmountDueAttribute($amountDue)
    { 
        $amountDue = number_format((float)$amountDue, 2, '.', '');
        return $this->attributes['amountDue'] = encrypt($amountDue);
    } 
    public function setAmountPaidAttribute($amountPaid)
    {
        $amountPaid = number_format((float)$amountPaid, 2, '.', '');
        return $this->attributes['amountPaid'] = encrypt($amountPaid);
    } 
    public function setDatePaidAttribute($datePaid)
    {
        $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
         $newDate    = $oDateHelper->$functionRs($datePaid);

        $this->attributes['datePaid'] = $newDate;
    }
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
     public function insertP($subcontInvDetailId,$amountDue)
    {
        $payable                    = new Payable;
        $payable->countryId         = session('countryId');
        $payable->officeId          = session('officeId');
        $payable->amountDue         = $amountDue;
        $payable->amountPaid        = '0.00';
        $payable->subcontInvDetailId = $subcontInvDetailId;
        $payable->userId            = Auth::user()->userId;
        $payable->save();
        return $payable;
  }
   public function deleteBySubcont($subcontInvDetailId)
    {
        
        try {
          $this->where('subcontInvDetailId', '=', $subcontInvDetailId)
               ->delete();
               
            $success = true;
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
        }

        if ($success) {
            return $result = ['alert' => 'info', 'msj' => 'Cliente Eliminado'];
        } else {
            return $result = ['alert' => 'error', 'msj' => 'No se Puede Eliminar porque este registro tiene relacion con otros datos.'];
        }
    }  
}
