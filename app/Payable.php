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

    protected $appends = ['amountDue'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
       'payableId',
       'countryId',
       'companyId',
       'amountDue',
       // 'balance',
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
    // public function getBalanceAttribute($balance)
    // {
    //     return decrypt($this->attributes['balance']);
    // }
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
    // public function setBalanceAttribute($balance)
    // {
    //     $balance = number_format((float)$balance, 2, '.', '');
    //     return $this->attributes['balance'] = encrypt($balance);
    // } 
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
  public function subcontInvDetail()
    {
        return $this->hasOne('App\SubcontractorInvDetail', 'subcontInvDetailId', 'subcontInvDetailId');
    }
    public function invoiceDetail()
    {
        return $this->hasOne('App\InvoiceDetail', 'invDetailId', 'invDetailId');
    }  
//-------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAllBySubcontractor($subcontId)
    {
        //consulta que traer relaciones desde tabla payable hasta contratc, y tiene una comparacion dentro de la relacion
        //subcontratos
        $result = $this->with('subcontInvDetail.subcontractor','subcontInvDetail.invoiceDetail.invoice.contract')
            ->whereHas('subcontInvDetail.subcontractor',function($q) use ($subcontId){
                $q->where('subcontId',$subcontId);
            })->orderBy('payableId', 'DESC')
              ->get();
       
        return $result;
    }
      public function insertP($subcontInvDetailId,$amountDue)
    {
        $payable                    = new Payable;
        $payable->countryId         = session('countryId');
        $payable->companyId          = session('companyId');
        $payable->amountDue         = $amountDue;
<<<<<<< HEAD
        $payable->balance           = $amountDue;
=======
        $payable->amountPaid           = $amountDue;
>>>>>>> aeefe06fae0c63d443ebaeb83e6950cd9ff2b9de
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
