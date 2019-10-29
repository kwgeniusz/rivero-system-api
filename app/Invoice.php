<?php

namespace App;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    //traits
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'invoice';
    protected $primaryKey = 'invoiceId';
    protected $fillable = ['invoiceId','countryId','officeId','invoiceNumber','contractId','clientId','address','invoiceDate','currencyId','grossTotal','taxPercent','taxAmount','netTotal','status'];

     protected $appends = ['grossTotal','taxAmount','netTotal'];
     protected $dates = ['deleted_at'];
    //Status Invoice
    const OPEN    = '1';
    const CLOSED   = '2';
    const PAID_OUT  = '3';
    const CANCELED = '4';


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
        if (empty($invoiceDate)) {
            return $invoiceDate = null;
        }

        return $newDate = date("d/m/Y", strtotime($invoiceDate));
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
        if (empty($invoiceDate)) {
            return $invoiceDate = null;
        }
        $partes                           = explode("/", $invoiceDate);
        $arreglo                          = array($partes[2], $partes[1], $partes[0]);
        $date                             = implode("-", $arreglo);
        $this->attributes['invoiceDate'] = $date;
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
      
          $invoiceNumberFormat = $oConfiguration->generateInvoiceNumberFormat($countryId, $officeId);
                                  $oConfiguration->increaseInvoiceNumber($countryId, $officeId);

        $invoice                   = new Invoice;
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
//------------------------------------------
    public function updateContract($contractId, $contractDate, $clientId,
        $siteAddress, $projectTypeId, $serviceTypeId, $registryNumber, $startDate, $scheduledFinishDate,
        $actualFinishDate, $deliveryDate, $initialComment, $intermediateComment, $finalComment, $currencyName) {

        $contract                      = contract::find($contractId);
        // $contract->countryId           = $countryId;
        // $contract->officeId            = $officeId;
        $contract->contractDate        = $contractDate;
        $contract->clientId            = $clientId;
        $contract->siteAddress         = $siteAddress;
        $contract->projectTypeId       = $projectTypeId;
        $contract->serviceTypeId       = $serviceTypeId;
        $contract->registryNumber      = $registryNumber;
        $contract->startDate           = $startDate;
        $contract->scheduledFinishDate = $scheduledFinishDate;
        $contract->actualFinishDate    = $actualFinishDate;
        $contract->deliveryDate        = $deliveryDate;
        $contract->initialComment      = $initialComment;
        $contract->intermediateComment = $intermediateComment;
        $contract->finalComment        = $finalComment;
        $contract->currencyName        = $currencyName;

        $contract->save();

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
                  $invoice->grossTotal = $invoice->grossTotal - $amount;
                }
            }
              $taxAmount   = ($invoice->grossTotal * $invoice->taxPercent)/100;
              $invoice->taxAmount = number_format((float)$taxAmount, 2, '.', '');
              $netTotal    = $invoice->taxAmount + $invoice->grossTotal;
              $invoice->netTotal = number_format((float)$netTotal, 2, '.', '');

              $invoice->save();
    }
//------------------------------------------
    public function deleteContract($contractId)
    {
        return Contract::find($contractId)
                       ->delete();
        
    }
}
