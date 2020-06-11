<?php

namespace App;

use App;
use App\Country;
use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    //traits
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'invoice';
    protected $primaryKey = 'invoiceId';
    protected $fillable = ['invoiceId','invId','countryId','officeId','contractId','clientId','invoiceDate','grossTotal','taxPercent','taxAmount','netTotal','invStatusCode'];

     protected $appends = ['grossTotal','taxAmount','netTotal'];
     protected $dates = ['deleted_at'];
     
    //PARA EVITAR LOS NUMEROS MAGICOS
    const OPEN      = '1';
    const CLOSED    = '2';
    const PAID      = '3';
    const CANCELLED  = '4';


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
      public function projectDescription()
    {
        return $this->belongsTo('App\ProjectDescription', 'projectDescriptionId');
    }
    public function invoiceDetails()
    {
      return $this->hasMany('App\InvoiceDetail', 'invoiceId', 'invoiceId');
    }
     public function note()
    {
      return $this->belongsToMany('App\Note', 'invoice_note', 'invoiceId', 'noteId')->withPivot('invNoteId');
    }
    public function scope()
    {
      return $this->hasMany('App\InvoiceScope', 'invoiceId', 'invoiceId');
    }
     public function invoiceStatus()
    {    //aqui debo meter esta linea en una variable y hacerle un where para filtrarlo por idioma
         $relation = $this->hasMany('App\InvoiceStatus', 'invStatusCode','invStatusCode');
         //hace el filtrado por el idioma
         //el locale cambia por el middleware que esta en localitazion,
         //esto maneja los datos por el idioma que escpga el usuario
         return $relation->where('language',App::getLocale());
    }
    public function paymentCondition()
    {
      return $this->belongsTo('App\PaymentCondition', 'pCondId', 'pCondCode');
    }
    public function receivable()
    {
      return $this->hasMany('App\Receivable', 'invoiceId', 'invoiceId');
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

//--------------------------------------------------------------------
    /** Mutadores  */
//--------------------------------------------------------------------

    public function setGrossTotalAttribute($grossTotal)
    {
         $grossTotal = number_format((float)$grossTotal, 2, '.', '');
        return $this->attributes['grossTotal'] = encrypt($grossTotal);
    }
        public function setTaxAmountAttribute($taxAmount)
    {
       $taxAmount = number_format((float)$taxAmount, 2, '.', '');
        return $this->attributes['taxAmount'] = encrypt($taxAmount);
    }
        public function setNetTotalAttribute($netTotal)
    {
        $netTotal = number_format((float)$netTotal, 2, '.', '');
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
     public function getAllByOffice($officeId)
    {
        return $this->where('officeId' , '=' , $officeId)
            ->orderBy('invoiceDate', 'DESC')
            ->get();
    }   
    
    public function getAllByContract($contractId)
    {
        $result = $this->with('invoiceDetails','note','scope')
            ->where('contractId', $contractId)
            ->orderBy('invoiceId', 'ASC')
            ->get();

        return $result;
    }   

     public function getAllByClientAndOffice($clientId,$officeId)
    {
        $result = $this->where('clientId', $clientId)
            ->where('officeId', $officeId)
            ->where('invStatusCode', Invoice::OPEN)
            ->orWhere('clientId', $clientId)
            ->where('officeId', $officeId)
            ->where('invStatusCode', Invoice::CLOSED)
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
    public function insertInv($countryId,$officeId,$contractId,$clientId,$projectDescriptionId, $invoiceDate,$grossTotal,$taxPercent,$taxAmount,$netTotal,$paymentConditionId,$invStatusCode) {

          $oConfiguration = new OfficeConfiguration();
          $invId = $oConfiguration->retrieveInvoiceNumber($countryId, $officeId);
          $invId++;
          $oConfiguration->increaseInvoiceNumber($countryId, $officeId);

        $invoice                   =  new Invoice;
        $invoice->invId            =  $invId;
        $invoice->countryId        =  $countryId;
        $invoice->officeId         =  $officeId;
        $invoice->contractId       =  $contractId;
        $invoice->clientId         =  $clientId;
        $invoice->projectDescriptionId     =  $projectDescriptionId;
        $invoice->invoiceDate      =  $invoiceDate;
        $invoice->grossTotal       =  $grossTotal;
        $invoice->taxPercent       =  $taxPercent;
        $invoice->taxAmount        =  $taxAmount;
        $invoice->netTotal         =  $netTotal;
        $invoice->pCondId          =  $paymentConditionId;
        $invoice->invStatusCode    =  $invStatusCode;
        $invoice->save();

      
        return $invoice;

    }
  //------------------------------------------   
    public function changeStatus($invoiceId,$invStatusCode) {

        $invoice             = Invoice::find($invoiceId);
        $invoice->invStatusCode     = $invStatusCode;
        $invoice->save();

    }

   //------------------------------------------
    public function updateInvoice($invoiceId, $paymentConditionId,$projectDescriptionId, $invoiceDate, $taxPercent) {

        $invoice                     = invoice::find($invoiceId);
        $invoice->pCondId            = $paymentConditionId;
        $invoice->projectDescriptionId     =  $projectDescriptionId;
        $invoice->invoiceDate        = $invoiceDate;
        $invoice->taxPercent         = $taxPercent;
        $invoice->save();

         //para ajustar los montos de la propuesta segundo el porcentaje indicado
         $this->updateInvoiceTotal('+', $invoiceId, '0');

    }
   //--------------------------------------------- 
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
          $balance = number_format((float)$balance, 2, '.', '');

          return $balance;
    }
}
