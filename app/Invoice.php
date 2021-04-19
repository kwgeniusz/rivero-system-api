<?php

namespace App;

use App;
use Carbon\Carbon;
use App\Country;
use App\Receivable;
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
    protected $fillable = ['invoiceId','invId','countryId','companyId','contractId','clientId','invoiceDate','grossTotal','taxPercent','taxAmount','netTotal','invStatusCode'];

     protected $appends = ['grossTotal','taxAmount','netTotal','balanceTotal','shareSucceed','invoiceDate'];
     protected $dates = ['deleted_at'];
     
    //PARA EVITAR LOS NUMEROS MAGICOS
    const OPEN      = '1';
    const CLOSED    = '2';
    const PAID      = '3';
    const CANCELLED  = '4';
    const COLLECTION  = '5';

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
      return $this->hasMany('App\InvoiceDetail', 'invoiceId', 'invoiceId')->orderBy('itemNumber');
    }
     public function subcontInvDetail()
    {
      return $this->hasMany('App\SubcontractorInvDetail', 'invoiceId', 'invoiceId');
    } 
    //  public function note()
    // {
    //   return $this->belongsToMany('App\Note', 'invoice_note', 'invoiceId', 'noteId')->withPivot('invNoteId');
    // }
    // public function scope()
    // {
    //   return $this->hasMany('App\InvoiceScope', 'invoiceId', 'invoiceId');
    // }
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
    public function paymentInvoice()
    {
        return $this->hasMany('App\PaymentInvoice', 'invoiceId', 'invoiceId');
    }
    public function proposal()
    {
        return $this->belongsTo('App\Proposal', 'invoiceId', 'invoiceId');
    } 
    public function receivable()
    {
      return $this->hasMany('App\Receivable', 'invoiceId', 'invoiceId');
    }
     public function debitNote()
    {
       return $this->hasMany('App\SaleNote', 'invoiceId','invoiceId')->where('noteType', 'debit');
    } 
     public function creditNote()
    {
      return $this->hasMany('App\SaleNote', 'invoiceId', 'invoiceId')->where('noteType', 'credit');
    } 
    public function user()
    {
        return $this->belongsTo('App\User', 'userId', 'userId');
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
    public function getInvoiceDateAttribute()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['invoiceDate'], 'UTC');
        $date->tz = session('companyTimeZone');   // ... set to the current users timezone
        return $date->format('Y-m-d H:i:s');
    }
   public function getPQuantityAttribute()
    {
          return $this->receivable->count();
    }
    public function getShareSucceedAttribute()
    {
      $shareSucceed = $this->receivable->filter(function ($receivable, $key) {
              return $receivable->recStatusCode == Receivable::SUCCESS;
          });

        return $shareSucceed;
    }
    public function getSharePendingAttribute()
    {
      $sharePending = $this->receivable->filter(function ($receivable, $key) {
              return $receivable->recStatusCode != Receivable::SUCCESS;
          });
     $sharePending = $sharePending->filter(function ($receivable, $key) {
              return $receivable->recStatusCode != Receivable::ANNULLED;
          });
        return $sharePending->values();
    } 
   public function getBalanceTotalAttribute()
    {
      //obtener el netTotal de la Factura
          $netTotal    = decrypt($this->attributes['netTotal']);
      //obtener el netTotal de todas las Notas de Debito(debito para el cliente) (+)
          $debitNoteTotal = $this->debitNote->sum('netTotal');
          $netTotal += $debitNoteTotal;
      //obtener el netTotal de todas las Notas de Credito(credito para el cliente) (-)
          $creditNoteTotal = $this->creditNote->sum('netTotal');
          $netTotal -= $creditNoteTotal;
      //obtener la suma de las cuotas pagadas
          $totalPaid   = $this->shareSucceed->sum('amountPaid');
      //Restando esta suma de pagos al saldo
          $balance = $netTotal - $totalPaid;
          $balance = number_format((float)$balance, 2, '.', '');
          return $balance;
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
        $date = Carbon::createFromFormat('Y-m-d', $invoiceDate, session('companyTimeZone'));
        $date->setTimezone('UTC');
        $this->attributes['invoiceDate'] = $date;
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    //  public function getAllByCompany($companyId)
    // {
    //     return $this->where('companyId' , '=' , $companyId)
    //         ->orderBy('invId', 'DESC')
    //         ->get();
    // }   
    public function getAllByStatus($invStatusCode,$companyId)
    {
        $result = $this->where('invStatusCode', $invStatusCode)
                        ->where('companyId' , '=' , $companyId)
                        ->get();
        return $result;
    }
  public function getAllByTwoStatus($invStatusCode1,$invStatusCode2,$companyId)
    {
        $result = $this->with('contract','invoiceStatus','projectDescription','client')
                       ->where('companyId' , '=' , $companyId)
                       ->where(function($q) use ($invStatusCode1,$invStatusCode2){
                          $q->where('invStatusCode', $invStatusCode1)
                          ->orWhere('invStatusCode', $invStatusCode2);
                        })
                        ->orderBy('invId', 'ASC')
                        ->get();
        return $result;
    }
    public function getAllByFourStatus($invStatusCode1,$invStatusCode2,$invStatusCode3,$invStatusCode4,$companyId)
    {
        $result = $this->with('contract','invoiceStatus','projectDescription','receivable','debitNote','creditNote')
                       ->where('companyId' , '=' , $companyId)
                       ->where(function($q) use ($invStatusCode1,$invStatusCode2,$invStatusCode3,$invStatusCode4){
                          $q->where('invStatusCode', $invStatusCode1)
                          ->orWhere('invStatusCode', $invStatusCode2)
                          ->orWhere('invStatusCode', $invStatusCode3)
                          ->orWhere('invStatusCode', $invStatusCode4);
                        })
                        ->orderBy('invId', 'DESC')
                        ->get();
        return $result;
    }

    public function getAllByContract($contractId)
    {
        $result = $this->with('invoiceDetails','proposal.term','proposal.scope','projectDescription','invoiceStatus')
            ->where('contractId', $contractId)
            ->orderBy('invoiceId', 'ASC')
            ->get();

        return $result;
    }  

 // this is used to report by client and company.
     public function getAllByClientAndCompany($clientId,$companyId)
    {
        $result = $this->where('clientId', $clientId)
            ->where('companyId', $companyId)
            ->where('invStatusCode', Invoice::OPEN)
            ->orWhere('clientId', $clientId)
            ->where('companyId', $companyId)
            ->where('invStatusCode', Invoice::CLOSED)
            ->orderBy('invoiceId', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------------
    public function findById($id,$countryId,$companyId)
    {
        return $this->with('invoiceDetails','projectDescription','client','contract')
                    ->where('invoiceId', '=', $id)
                    ->where('countryId', $countryId)
                    ->where('companyId', $companyId) 
                    ->get();
    }

//------------------------------------------
    public function insertInv($countryId,$companyId,$contractId,$clientId,$projectDescriptionId, $invoiceDate,$grossTotal,$taxPercent,$taxAmount,$netTotal,$paymentConditionId,$invStatusCode,$userId) {

          $oConfiguration = new CompanyConfiguration();
          $invId = $oConfiguration->retrieveInvoiceNumber($countryId, $companyId);
          $invId++;
          $oConfiguration->increaseInvoiceNumber($countryId, $companyId);

        $invoice                   =  new Invoice;
        $invoice->invId            =  $invId;
        $invoice->countryId        =  $countryId;
        $invoice->companyId         =  $companyId;
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
        $invoice->userId           =  $userId;
        $invoice->save();

      
        return $invoice;

    }
  //------------------------------------------   
    public function changeStatus($invoiceId,$invStatusCode)
    {

        $invoice                    = Invoice::find($invoiceId);
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
    // public function getBalance($invoiceId)
    // {
    //     $invoice = $this->select('netTotal')->where('invoiceId', $invoiceId)->get();

    //      // dd($invoice[0]->netTotal);
    //       $oReceivable = new Receivable();
    //       $totalPaid = $oReceivable->sumSucceedSharesForInvoice($invoiceId);

    //       $balance = $invoice[0]->netTotal - $totalPaid;
    //       $balance = number_format((float)$balance, 2, '.', '');

    //       return $balance;
    // }
}
