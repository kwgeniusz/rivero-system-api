<?php

namespace App;

use App;
use Auth;
use DB;
use App\Receivable;
use App\PaymentInvoice;
use App\SaleNoteDetail;
use App\CompanyConfiguration;
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
    const CREDIT = 'credit';
      const CREDIT_CANCELLATION    = 1;
      const CREDIT_DISCOUNT        = 2;
      const CREDIT_PARTIAL_REFUND  = 3;
    //------------------------
    const DEBIT  = 'debit';
      const DEBIT_APPEND_SERVICES = 1;
      const DEBIT_COMMISSIONS     = 2;

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
   public function client()
    {
        return $this->belongsTo('App\Client', 'clientId','clientId');
    }
   public function invoice()
    {
        return $this->hasOne('App\Invoice', 'invoiceId', 'invoiceId');
    }
    // public function paymentInvoice()
    // {
    //     return $this->hasMany('App\PaymentInvoice', 'salNoteId', 'salNoteId');
    // }
        public function saleNoteDetails()
    {
        return $this->hasMany('App\SaleNoteDetail', 'salNoteId', 'salNoteId')->orderBy('itemNumber');
    }
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
    public function getAllByType($companyId,$noteType)
   {
       return $this->whereHas('invoice', function($q) use ($companyId){
           $q->where('companyId', $companyId);
        })->where('noteType',$noteType)
          ->get();
    }
    public function getAllByInvoice($invoiceId)
    {
        return $this->where('invoiceId', $invoiceId)
                    ->orderBy('dateNote', 'DESC')
                    ->get();
    }
   public function getAllByInvoiceAndType($invoiceId,$noteType)
   {
       return $this->where('invoiceId', $invoiceId)
       ->where('noteType', $noteType)
       ->get(); 
    }
//-----------------------------------------
    public function findById($id)
    {
        return $this->with('saleNoteDetails','client','invoice')
                    ->where('salNoteId', '=', $id)
                    ->get();
    }

    public function insertS($data)
    {
        $error = null;
 
      DB::beginTransaction();
        try {
              $oPaymentInvoice   = new paymentInvoice;
              $invoice    = Invoice::find($data['invoiceId']);
            //si el saldo es igual a cero que no permita crear notas de ventas.
            if($invoice->balanceTotal == 0){
             throw new \Exception('Error: Esta Factura Tiene Saldo 0.00, no se permite agregar mas notas de ventas.');
            }
                //INSERTA DATOS DE LA NOTA DE VENTA
            $saleNote   = new SaleNote;
            $saleNote->invoiceId         = $data['invoiceId'];
            $saleNote->clientId          = $data['clientId'];
            $saleNote->reference         = $data['formReference'];
            $saleNote->concept           = $data['formConcept'];
            $saleNote->noteType          = $data['noteType'];
            $saleNote->netTotal          = $data['netTotal'];
            $saleNote->percent           = $data['formPercent'];
            $saleNote->dateNote          = date('Y-m-d H:i:s');
            $saleNote->userId            = Auth::user()->userId;
         
        if($data['noteType'] == 'credit') {
             //si son notas de credito, el monto de esa nota no debe sobrepasar el saldo.la restriccion va desde el nivel mas bajo(modelos) hasta la capa mas alta (interfaces) 
                if($data['netTotal'] > $invoice->balanceTotal){
                  throw new \Exception('Error: El monto de las Notas de Credito no puede ser mayor al saldo.');
                 }
           //NUMERACION DE LA NOTA DE CREDITO
           $oConfiguration = new CompanyConfiguration();
           $salId = $oConfiguration->retrieveCreditNoteNumber(session('countryId'), session('companyId'));
           $salId++;
           $oConfiguration->increaseCreditNoteNumber(session('countryId'), session('companyId'));    

            $saleNote->salId = $salId;
            $saleNote->save();
            
            // dd($saleNote->salNoteId);
            // exit();

                 if($data['formConcept'] == SaleNote::CREDIT_CANCELLATION) {
                 //si es una anulacion el netTotal de la notesale es igual al saldo de la factura. y se anula la factura
                    $oInvoice = new Invoice;
                    $oInvoice->changeStatus($data['invoiceId'], Invoice::PAID);
                      //recorre el arreglo que viene por request, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
                               $oSaleNoteDetail = new SaleNoteDetail;
                            foreach ($data['itemList'] as $key => $item) {
                               $result = $oSaleNoteDetail->insertS(
                                              $saleNote->salNoteId,
                                              $item['itemNumber'],
                                              $item['serviceId'],
                                              $item['serviceName'],
                                              $item['unit'],
                                              $item['unitCost'],
                                              $item['quantity'],
                                              $item['amount']);
                                 }
                  //las cuentas por cobrar quedan sin efecto cambiando su estado a anuladas (color gris)
       
                 
                    foreach ($invoice->sharePending as $key => $sharePending) {
                     $oPaymentInvoice->removePayment($sharePending->paymentInvoiceId,$sharePending->invoiceId);   
                               //  $sharePending->recStatusCode = Receivable::ANNULLED;                     
                            //  $sharePending->save();
                     };


                   }elseif($data['formConcept'] == SaleNote::CREDIT_DISCOUNT) {
                //si es un Descuento el netTotal de la notesale es el resultado de la siguiente formula
                // $rs = invoice->balanceTotal * porcentaje;
                
                           //las cuentas por cobrar quedan sin efecto cambiando su estado a anuladas (color gris)
                     // foreach ($invoice->sharePending as $key => $sharePending) {
                     //         $sharePending->recStatusCode = Receivable::ANNULLED;                     
                     //         $sharePending->save();
                     //   };
 
     
                   }elseif($data['formConcept'] == SaleNote::CREDIT_PARTIAL_REFUND) {
                //si es una devolucion parcial.  
                //al escoger de los items de la factura se toma el Service Id junto con el precio.
                //esto sera un arreglo de servicios por lo tanto-> debe existir un foreach que sume el total. y luego ingresalo debajo

                    //verificar si casualmente los articulos pagados hace que el saldo de la factura llege a cero.
                      $rs = 0;
                      $rs = $invoice->balanceTotal - $data['netTotal'];
        
                     if($rs == 0){
                       $oInvoice = new Invoice;
                       $oInvoice->changeStatus($data['invoiceId'], Invoice::PAID);
                      }

                       $oSaleNoteDetail = new SaleNoteDetail;
                            foreach ($data['itemList'] as $key => $item) {
                               $result = $oSaleNoteDetail->insertS(
                                              $saleNote->salNoteId,
                                              $item['itemNumber'],
                                              $item['serviceId'],
                                              $item['serviceName'],
                                              $item['unit'],
                                              $item['unitCost'],
                                              $item['quantity'],
                                              $item['amount']);
                                 }
                  //las cuentas por cobrar quedan sin efecto cambiando su estado a anuladas (color gris)
                     foreach ($invoice->sharePending as $key => $sharePending) {
                        $oPaymentInvoice->removePayment($sharePending->paymentInvoiceId,$sharePending->invoiceId);       
                            //  $sharePending->recStatusCode = Receivable::ANNULLED;                     
                            //  $sharePending->save();
                       };
                }
//=========================DEBIT NOTE=================================  
            }elseif ($data['noteType'] == 'debit') {      
                   //NUMERACION DE LA NOTA DE DEBITO
                $oConfiguration = new CompanyConfiguration();
                $salId = $oConfiguration->retrieveDebitNoteNumber(session('countryId'), session('companyId'));
                $salId++;
                $oConfiguration->increaseDebitNoteNumber(session('countryId'), session('companyId'));    

                $saleNote->salId = $salId;
                $saleNote->save();
            
                   if($data['formConcept'] == SaleNote::DEBIT_APPEND_SERVICES){
                     //agregar servicio 
                             $oSaleNoteDetail = new SaleNoteDetail;
                            foreach ($data['itemList'] as $key => $item) {
                               $result = $oSaleNoteDetail->insertS(
                                              $saleNote->salNoteId,
                                              ++$key,
                                              $item['serviceId'],
                                              $item['serviceName'],
                                              $item['unit'],
                                              $item['unitCost'],
                                              $item['quantity'],
                                              $item['amount']);
                                }
                   if($data['formConcept'] == SaleNote::DEBIT_COMMISSIONS){
                          
                   }   
                }
            }//end debitnote

        
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $rs  = ['alert' => 'success', 'msj' => 'Nota de Venta Agregada a Factura','saleNote' => $saleNote];
        } else {
            return $rs = ['alert' => 'error', 'msj' => $error];
        }

    }
  }