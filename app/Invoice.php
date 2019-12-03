<?php

namespace App;

use App;
use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    //traits
    use SoftDeletes;

    // private $oDateHelper = new DateHelper;
    public $timestamps = false;

    protected $table      = 'invoice';
    protected $primaryKey = 'invoiceId';
    protected $fillable = ['invoiceId','countryId','officeId','invoiceNumber','contractId','clientId','address','invoiceDate','currencyId','grossTotal','taxPercent','taxAmount','netTotal','status'];

     protected $appends = ['grossTotal','taxAmount','netTotal'];
     protected $dates = ['deleted_at'];
    //Status Invoice
    const OPEN      = '1';
    const CLOSED    = '2';
    const PAID_OUT  = '3';
    const CANCELED  = '4';


//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function client()
    {
        return $this->belongsTo('App\Client', 'clientId');
    }
    public function contract()
    {
        return $this->belongsTo('App\Contract', 'contractId');
    }
    public function currency()
    {
        return $this->belongsTo('App\Currency', 'currencyId');
    }
     public function note()
    {
      return $this->belongsToMany('App\Note', 'invoice_note', 'invoiceId', 'noteId')->withPivot('invNoteId');
    }
//--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------
    public function getGrossTotalAttribute($grossTotal)
    {
          return decrypt($this->attributes['grossTotal']);
    }
    public function getTaxAmountAttribute($taxAmount)
    {
          return decrypt($this->attributes['taxAmount']);
    }
    public function getNetTotalAttribute($netTotal)
    {
          return decrypt($this->attributes['netTotal']);
    }
    public function getInvoiceDateAttribute($invoiceDate)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
         $newDate    = $oDateHelper->$functionRs($invoiceDate);
        return $newDate;
    }
    public function getStatusAttribute($status)
    {

        if (App::getLocale() == 'es') {
            switch ($status) {
                case 1:
                    return "ABIERTO";
                    break;
                case 2:
                    return "CERRADO";
                    break;
                case 3:
                    return "PAGADO";
                    break;
                case 4:
                    return "CANCELADO";
                    break;
            }
        } else {
            switch ($status) {
                case 1:
                    return "OPEN";
                    break;
                case 2:
                    return "CLOSED";
                    break;
                case 3:
                    return "PAID OUT";
                    break;
                case 4:
                    return "CANCELED";
                    break;
            }
        }

    }
//--------------------------------------------------------------------
    /** Mutadores  */
//--------------------------------------------------------------------

    public function setGrossTotalAttribute($grossTotal)
    {
        return $this->attributes['grossTotal'] = encrypt($grossTotal);
    }
        public function setTaxAmountAttribute($taxAmount)
    {
        return $this->attributes['taxAmount'] = encrypt($taxAmount);
    }
        public function setNetTotalAttribute($netTotal)
    {
        return $this->attributes['netTotal'] = encrypt($netTotal);
    }
    public function setInvoiceDateAttribute($invoiceDate)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
         $newDate    = $oDateHelper->$functionRs($invoiceDate);

        $this->attributes['invoiceDate'] = $newDate;
    }
   

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAllByContract($contractId)
    {
        $result = $this->where('contractId', $contractId)
            ->orderBy('invoiceId', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------------
    public function findById($id,$countryId,$officeId)
    {
        return $this->where('invoiceId', '=', $id)
                    ->where('countryId', $countryId)
                    ->where('officeId', $officeId) 
                    ->get();
    }

//------------------------------------------
    public function insertInv($countryId,$officeId,$contractId,$clientId, $siteAddress, $invoiceDate,$currencyId,$taxPercent,$paymentConditionId,$status) {

          $oConfiguration = new Configuration();
          $invId = $oConfiguration->retrieveInvoiceNumber($countryId, $officeId);
          $invId++;

          $invoiceNumberFormat = $oConfiguration->generateInvoiceNumberFormat($countryId, $officeId);
                                  $oConfiguration->increaseInvoiceNumber($countryId, $officeId);

        $invoice                   = new Invoice;
        $invoice->invId            =  $invId;
        $invoice->countryId        =  $countryId;
        $invoice->officeId         =  $officeId;
        $invoice->invoiceNumber    =  $invoiceNumberFormat;
        $invoice->contractId       =  $contractId;
        $invoice->clientId         =  $clientId;
        $invoice->address          =  $siteAddress;
        $invoice->invoiceDate      =  $invoiceDate;
        $invoice->currencyId      =  $currencyId;
        $invoice->grossTotal       =  '0.00';
        $invoice->taxPercent       =  $taxPercent;
        $invoice->taxAmount        =  '0.00';
        $invoice->netTotal         =  '0.00';
        $invoice->pCondId         =  $paymentConditionId;
        $invoice->status           =  '1';
        $invoice->save();

      
        return $invoice->invoiceId;

    }
      public function changeStatus($invoiceId,$status) {
        $invoice             = Invoice::find($invoiceId);
        $invoice->status     = $status;
        $invoice->save();
    }
      public function updateInvoiceTotal($sign, $invoiceId, $amount)
    {
        if ($sign == '+') {
              $invoice = Invoice::find($invoiceId);
                    $grossTotal = $invoice->grossTotal + $amount;
                    $invoice->grossTotal = number_format((float)$grossTotal, 2, '.', '');
            } else {
              $invoice = Invoice::find($invoiceId);
                if ($invoice->grossTotal < $amount) {
                    throw new \Exception('Error: El monto de la factura no puede ser menor que 0.00');
                } else {
                  $grossTotal = $invoice->grossTotal - $amount;
                  $invoice->grossTotal = number_format((float)$grossTotal, 2, '.', '');
                }
            }
              $taxAmount   = ($invoice->grossTotal * $invoice->taxPercent)/100;
              $invoice->taxAmount = number_format((float)$taxAmount, 2, '.', '');
              $netTotal    = $invoice->taxAmount + $invoice->grossTotal;
              $invoice->netTotal = number_format((float)$netTotal, 2, '.', '');

              $invoice->save();
    }
//--------------------------------------------------------------------
    //esta funcion llama a un metodo de receivables es para sacar el balance de lo que se ha pagado de la factura
    public function getBalance($invoiceId)
    {
        $invoice = $this->select('netTotal')
            ->where('invoiceId', $invoiceId)
            ->get();

         // dd($invoice[0]->netTotal);
          $oReceivable = new Receivable();
          $totalPaid = $oReceivable->sumSucceedSharesForInvoice($invoiceId);

          $balance = $invoice[0]->netTotal - $totalPaid;
          return $balance;
    }
//-----------------------------------------
    //SECTIONS NOTES
//------------------------------------------
    public function addNote($invoiceId ,$noteId)
    {
        $invoice = Invoice::find($invoiceId);
        $invoice->note()->attach($noteId);
        return $invoice->save();
    }
//------------------------------------------
    public function removeNote($invoiceId ,$noteId)
    {
        $invoice = Invoice::find($invoiceId);
        return $invoice->note()->detach($noteId);
    }
//------------------------------------------
}
