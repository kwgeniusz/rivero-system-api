<?php

namespace App;

use App;
use Auth;
use DB;
use App\Country;
use App\Receivable;
use App\PaymentInvoice;
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
      const CANCELLATION = 1;
      const DISCOUNT = 2;
      const PARTIAL_REFUND = 3;
    //------------------------
    const DEBIT  = 'debit';
      const INTEREST_ON_ARREARS = 1;
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

    public function insertS($data)
    {
        $error = null;

      DB::beginTransaction();
        try {
            // dd($data);
            // exit();
            $saleNote   = new SaleNote;
            $invoice    = Invoice::find($data['invoiceId']);
    

            //si el saldo es igual a cero que no permita crear notas de ventas.
            if($invoice->balanceTotal == 0){
             throw new \Exception('Error: Esta Factura Tiene Saldo 0.00, no se permite agregar mas notas de ventas.');
            }

        if($data['noteType'] == 'credit') {
             //si son notas de credito, el monto de esa nota no debe sobrepasar el saldo.la restriccion va desde el nivel mas bajo(modelos) hasta la capa mas alta (interfaces) 
                if($data['netTotal'] > $invoice->balanceTotal){
                     throw new \Exception('Error: El monto de las Notas de Credito no puede ser mayor al saldo.');
                       }

                 if($data['formConcept'] == SaleNote::CANCELLATION) {
                 //si es una anulacion el netTotal de la notesale es igual al saldo de la factura. y se anula la factura 
                    $oInvoice = new Invoice;
                    $oInvoice->changeStatus($data['invoiceId'], Invoice::CANCELLED);

                    $saleNote->netTotal = $data['netTotal'];
                  //las cuentas por cobrar quedan sin efecto cambiando su estado a anuladas (color gris)
                     foreach ($invoice->sharePending as $key => $sharePending) {
                             $sharePending->recStatusCode = Receivable::ANNULLED;                     
                             $sharePending->save();
                       };

                   }elseif($data['formConcept'] == SaleNote::DISCOUNT) {
                //si es un Descuento el netTotal de la notesale es el resultado de la siguiente formula
                // $rs = invoice->balanceTotal * porcentaje;
                    $saleNote->netTotal = $data['netTotal'];
                    $saleNote->percent = $data['formPercent'];

                 //al crear notas de ventas debo reiniciar las cuotas tambien porque modifico el saldo de la factura. 
                    foreach ($invoice->sharePending as $key => $sharePending) {
                        $oPaymentInvoice = new PaymentInvoice;
                        $oPaymentInvoice->removePayment($sharePending->paymentInvoiceId,$invoice->invoiceId);
                    };
 
     
                   }elseif($data['formConcept'] == SaleNote::PARTIAL_REFUND) {
                //si es una devolucion parcial.  
                //al escoger de los items de la factura se toma el Service Id junto con el precio.
                //esto sera un arreglo de servicios por lo tanto-> debe existir un foreach que sume el total. y luego ingresalo debajo
                // $saleNote->netTotal          = $data['netTotal'];

                        //al crear notas de ventas debo reiniciar las cuotas tambien porque modifico el saldo de la factura. 

                   }
            }elseif ($data['noteType'] == 'debit') {      

                   if($data['formConcept'] == SaleNote::INTEREST_ON_ARREARS){
                     //agregar servicio
                     // $saleNote->netTotal          = $data['netTotal'];
                   }   
            }//end debitnote

            //INSERTA DATOS DE LA NOTA DE VENTA
            $saleNote->invoiceId         = $data['invoiceId'];
            $saleNote->clientId          = $data['clientId'];
            $saleNote->reference         = $data['formReference'];
            $saleNote->concept           = $data['formConcept'];
            $saleNote->noteType          = $data['noteType'];
            $saleNote->dateNote          = date('Y-m-d H:i:s');
            $saleNote->userId            = Auth::user()->userId;

  
               
            $saleNote->save();
            
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
