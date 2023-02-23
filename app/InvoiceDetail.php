<?php

namespace App;

use App;
use DB;
use App\Models\Inventory\ServiceCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceDetail extends Model
{
    //traits
    // use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'invoice_detail';
    protected $primaryKey = 'invDetailId';
    protected $fillable = ['invDetailId','invoiceId','serviceId','serviceName','unit','unitCost','quantity','amount'];
  
    protected $appends = ['unitCost','amount'];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function subcontractorInvDetail()
    {
          $relation = $this->hasMany('App\SubcontractorInvDetail', 'invDetailId', 'invDetailId');
      
         return $relation->with('subcontractor');
    }
    public function invoice()
    {
          return $this->hasOne('App\Invoice', 'invoiceId', 'invoiceId');
    }
    public function service()
    {
        return $this->belongsTo('App\Models\Inventory\Service', 'serviceId','serviceId');
    }
    
//--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------
    public function getUnitCostAttribute($unitCost)
    {
       return decrypt($this->attributes['unitCost']);
    }
    public function getAmountAttribute($amount)
    {
       return decrypt($this->attributes['amount']);
    }
//--------------------------------------------------------------------
    /** Mutadores  */
//--------------------------------------------------------------------

    public function setUnitCostAttribute($unitCost)
    {
         if($unitCost != null) { 
        $unitCost = number_format((float)$unitCost, 2, '.', '');
    }
        return $this->attributes['unitCost'] = encrypt($unitCost);
    }
     public function setAmountAttribute($amount)
    {
          if($amount != null) { 
        $amount = number_format((float)$amount, 2, '.', '');
    }
        return $this->attributes['amount'] = encrypt($amount);
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------

    public function getAllByInvoice($invoiceId)
    {
        $result = $this->with('subcontractorInvDetail')
            ->where('invoiceId', $invoiceId)
            ->orderBy('itemNumber', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------
        public function getWithPriceByInvoice($invoiceId)
    {
        $result = $this->with('subcontractorInvDetail')
                       ->where('invoiceId', $invoiceId)
                       ->where('unit','!=', null)
                       ->orderBy('itemNumber', 'ASC')
                       ->get();

        return $result;
    }
//------------------------------------------
    public function insert($invoiceId, $itemNumber, $isHeaderTag, $categoryId ,$serviceId,$serviceName,$unit,$unitCost,$quantity,$amount) {

     $error = null;

        DB::beginTransaction();
        try {
              if($amount == '0.00'){
                $amount = null;
              }
            //INSERTA UN RENGLON
             $invDetail                   = new InvoiceDetail;
             $invDetail->invoiceId        = $invoiceId;
             $invDetail->itemNumber       = $itemNumber;
             $invDetail->isHeaderTag      = $isHeaderTag;
             $invDetail->categoryId       = $categoryId;
             $invDetail->serviceId        = $serviceId;
             $invDetail->serviceName      = $serviceName;
             $invDetail->unit             = $unit;
             $invDetail->unitCost         = $unitCost;
             $invDetail->quantity         = $quantity;
             $invDetail->amount           = $amount;
             $invDetail->save();
            
            //REALIZA ACTUALIZACION EN FACTURA
            $oInvoice = new Invoice;
            $oInvoice->updateInvoiceTotal('+', $invoiceId, $amount);
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Reglon Agregado Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//------------------------------------------

//------------------------------------------
    public function deleteInv($invoiceId)
    {
           $error = null;

        DB::beginTransaction();
        try {

            $invoice       = Invoice::find($invoiceId);
            $successShares = $invoice->shareSucceed;
            //Buscar alguna cuota pagada en essta factura.
            // $oReceivable = new Receivable;
            // $successShares=$oReceivable->shareSucceed($invoiceId);

   if($successShares->isEmpty()) { //si esta vacio(es decir no tiene pagos, permitelo eliminar),y limpia las cuotas creadas

          //Eliminar las cuentas por pagar de los invoices details
            $invDetails= $this->getAllByInvoice($invoiceId);
            foreach ($invDetails as $invDetail) {
                 $oSub = new SubcontractorInvDetail;
                 $oSub->deleteS($invDetail->subcontractorInvDetail);
             }
            
           //Eiminar las cuotas con payables
                $oPaymentInvoice= new PaymentInvoice;     
                $invoiceShares = $oPaymentInvoice->getAllByInvoice($invoiceId);

              foreach ($invoiceShares as $value) {
                  $oPaymentInvoice->removePayment($value->paymentInvoiceId,$invoiceId);
              }
       //eliminar items de la factura
             $this->where('invoiceId',$invoiceId)->delete();
         
      //REALIZA ACTUALIZACION EN PROPUESTA
            //BUSCO LA PROPUESTA
            $oInvoice = new Invoice; 
            $oInvoice->updateInvoiceTotal('-',$invoice->invoiceId, $invoice->grossTotal); // RESTA TODO EL MONTO DE GROSSTOTAL PARA QUE HAGA EL DESCUENTO.
        }else{
           throw new \Exception('Error: No se puede modificar renglones se ha comenzado a pagar la factura');
        };

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Reglon Eliminado Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//-----------------------------------------


 //in_service_category (jerarquica 3ero)
    //invoice_detail (detalle final)

    function markLeafItems($collection, $categoryParentId = NULL, $restrictorArrayCleaned, $invoiceId)
    {
        foreach ($collection as $item) { //el primer registro de cada coleccion cae aqui (inicialmente las raices)
           
            if (count($item->childrenCategoriesTree) !== 0) {  //Es raiz, no es hoja, pero tiene relacionados

                $item->nivel = 'interno1';
                $item->leaf = false;

                foreach ($item->childrenCategoriesTree as $children) {

                    if (count($children->childrenCategoriesTree) !== 0) { //hijos internos que no son hoja y que tambien tienen hijos (estan entre la raiz y la hoja)

                        $children->nivel = 'interno2';

                        $children->leaf = false;
                        $this->markLeafItems($children->childrenCategoriesTree, $children->categoryId, $restrictorArrayCleaned, $invoiceId);
                    } else { //hijos extremos que no tienen hijos, por lo tanto son hoja

                        $children->nivel = 'interno2.1';

                        $children->leaf = true;
                        $this->markLeafItems($children->childrenCategoriesTree, $children->categoryId, $restrictorArrayCleaned, $invoiceId);
                    }
                }
            } else { //No tiene hijos, por lo tanto es hoja (entran en este grupo tambien los registros intermedios)

                $item->nivel = 'externo';

                $item->leaf = true;

                $services = InvoiceDetail::with('service')
                                         ->where('categoryId', $item->categoryId)
                                         ->where('invoiceId', $invoiceId)->get();
                   if (count($services) > 0) {
                      
                       $item->unit1    = $services[0]->unit;
                       $item->unitCost = $services[0]->unitCost;
                       $item->quantity = $services[0]->quantity;
                    }
                $item->unitCost            = $services->sum('unitCost');
                $item->totalServicesAmount = $services->sum('amount');
                $item->services            = $services->sortBy('serviceId');

                // $item->totalServicesAmount = $sumatoriaServiceCategory;

                $item->makeHidden('childrenCategoriesTree');
                
            }
        }

        return $collection;
    }

    function cleanItems($collection, $restrictorArrayCleaned, $categoryParentId = NULL)
    {

        foreach ($collection as $item) { //el primer registro de cada coleccion cae aqui (inicialmente las raices)

            if (count($item->childrenCategoriesTree) !== 0) {  //Es raiz, no es hoja, pero tiene relacionados

                //Evitar que en $item->childrenCategoriesTree se mantengan datos inutiles

                $related_records1 = $item->childrenCategoriesTree;

                if ($related_records1) {

                    $meh1 = $related_records1->filter(function ($record) use ($restrictorArrayCleaned) {
                        if ($restrictorArrayCleaned->contains($record->categoryId)) {
                            return $record;
                        }
                    })->values();

                    $item->related_records = $meh1;
                }

                $item->makeHidden('childrenCategoriesTree');

                foreach ($item->childrenCategoriesTree as $children) {

                    if (count($children->childrenCategoriesTree) !== 0) { //hijos internos que no son hoja y que tambien tienen hijos (estan entre la raiz y la hoja)

                        $related_records2 = $children->childrenCategoriesTree;

                        if ($related_records2) {

                            $meh2 = $related_records2->filter(function ($record) use ($restrictorArrayCleaned) {
                                if ($restrictorArrayCleaned->contains($record->categoryId)) {
                                    return $record;
                                }
                            })->values();



                            $children->related_records = $meh2;

                            $children->makeHidden('childrenCategoriesTree');
                        }
                    }
                }
            }
        }

        return $collection;
    }

    public function showAllCompanyCategoriesHierarchicalMode($companyId, $invoiceId)
    {
        $categories = ServiceCategory::with('childrenCategoriesTree')
            ->orderBy('categoryCode', 'ASC')
            ->where('categoryParentId', 0)
            ->where('companyId', $companyId)
            ->get();

        $categories_ids_with_services = collect(DB::select('SELECT * FROM in_service_category WHERE EXISTS (SELECT invDetailId FROM invoice_detail WHERE invoice_detail.categoryId = in_service_category.categoryId AND companyId =' . $companyId . ' AND invoiceId =' . $invoiceId . ')'));

        $cat_without_roots_categories = $categories_ids_with_services->reject(function ($item) {
            return $item->categoryParentId == 0;
        })->values();
 
        $restrictorArray = collect([]);

        foreach ($cat_without_roots_categories as $category) {
             
            $element = ServiceCategory::find($category->categoryId);

            $restrictorArray->push($element->categoryId);

            $ancestors = $element->ancestors;
            $category->ancestors = $ancestors;

            foreach ($ancestors as $ancestor) {
                $restrictorArray->push($ancestor->categoryId);
            }
        } 
        
        $restrictorArrayCleaned = $restrictorArray->unique()->values();
        
        $this->markLeafItems($categories, NULL, $restrictorArrayCleaned, $invoiceId);
        
        $this->cleanItems($categories, $restrictorArrayCleaned);

        $cat_without_empty_roots_categories = $categories->reject(function ($item) {
            if (count($item->related_records) == 0) {
                return $item;
            }
        })->values();


        return  $cat_without_empty_roots_categories;

        // return response()->json(['data' => $cat_without_empty_roots_categories], 200);
    }


}
