<?php

namespace App;

use App;
use DB;
use App\ProposalDetail;
use App\Models\Inventory\ServiceCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProposalDetail extends Model
{
    //traits
    // use SoftDeletes;
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

    public $timestamps = false;

    protected $table      = 'proposal_detail';
    protected $primaryKey = 'propDetailId';
    protected $fillable = ['propDetailId','proposalId','serviceId', 'serviceParentId','serviceName','unit','unitCost','quantity','amount'];
  
    protected $appends = ['unitCost','amount'];

// Change defautl field for recursive librery

    public function getLocalKeyName()
    {
        return 'serviceId';
    }
    public function getParentKeyName()
    {
        return 'serviceParentId';
    }
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
//Relaciones recursivas

    //Relaciones de primer nivel
    public function proposalDetail() 
    {
        return $this->hasMany(ProposalDetail::class, 'serviceParentId','serviceId');
    }
    //Relaciones con el arbol completo
    public function childrenServiceTree() 
    {
        return $this->proposalDetail()->with('childrenServiceTree');
    }
   public function subcontractorPropDetail()
   {
         $relation = $this->hasMany('App\SubcontractorPropDetail', 'propDetailId', 'propDetailId');
     
        return $relation->with('subcontractor');
   }
   public function category()
   {
       return $this->belongsTo('App\Models\Inventory\ServiceCategory', 'categoryId','categoryId');
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

    public function getAllByProposal($proposalId)
    {
        $result = $this->with('category','service')
                       ->where('proposalId', $proposalId)
                       ->orderBy('propDetailId', 'ASC')
                       ->get();

        return $result;
    }

    public function getAllByProposalAndGroup($proposalId)
    {
        $result = ProposalDetail::where('serviceParentId', 0)
                                ->where('proposalId', $proposalId)
                                ->get()
                                ->map(function ($items) {
                                    return $items->load('childrenServiceTree');
                                 });
    }
    public function getWithPriceByProposal($proposalId)
    {
        $result = $this->with('subcontractorPropDetail')
                       ->where('proposalId', $proposalId)
                       ->where('unit','!=', null)
                       ->orderBy('itemNumber', 'ASC')
                       ->get();

        return $result;
    }
//------------------------------------------
    public function insert($proposalId, $itemNumber, $isHeaderTag, $categoryId, $serviceId ,$serviceName,$unit,$unitCost,$quantity,$amount) {

     $error = '';

        DB::beginTransaction();
        try {

              if($amount == '0.00') {
                $amount = 0.00;
              }
              
            //INSERTA UN RENGLON
             $propDetail                     = new ProposalDetail;
             $propDetail->proposalId         = $proposalId;
             $propDetail->itemNumber         = $itemNumber;
             $propDetail->isHeaderTag         = $isHeaderTag;
             $propDetail->categoryId          = $categoryId;
             $propDetail->serviceId          = $serviceId;
             $propDetail->serviceName        = $serviceName;
             $propDetail->unit               = $unit;
             $propDetail->unitCost           = $unitCost;
             $propDetail->quantity           = $quantity;
             $propDetail->amount             = $amount;
             $propDetail->save();
            
            //REALIZA ACTUALIZACION EN PROPUESTA
              $oProposal = new Proposal;
              $oProposal->updateProposalTotal('+', $proposalId, $amount);
     
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return ['alertType' => 'success', 'message' => 'Reglon Agregado Exitosamente','entity' => $propDetail];
        } else {
            return ['alertType' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
    public function deleteProp($id)
    {
           $error = null;

        DB::beginTransaction();
        try {
            //ELIMINA TODOS LOS ITEMS DE LA PROPUESTA
             $oProposalDetail = ProposalDetail::where('proposalId',$id)->delete();
         
            // //REALIZA ACTUALIZACION EN PROPUESTA
              //BUSCO LA PROPUESTA
            $prop = Proposal::find($id);
            $oProposal = new Proposal; 
            $oProposal->updateProposalTotal('-',$prop->proposalId, $prop->grossTotal); // RESTA TODO EL MONTO DE GROSSTOTAL PARA QUE HAGA EL DESCUENTO.

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Reglones Eliminados Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//-----------------------------------------

function cascadeBalanceUpdate($proposalId, $selectedService)
{

    DB::beginTransaction();
    try {    
      
     $serviceId = $selectedService->serviceId;
     $amount    = $selectedService->amount;

      if ($selectedService->serviceParentId == 0) { //HAY CAMBIAR ESTA LINEA POR serviceParentId == 0 (porque no tiene padre)
         $serviceParentId = 0;
      } else {
         $serviceParentId = $selectedService->serviceParentId;
      }
  // actualizar saldo en cascada
  $loop = 1;
  $acum = 0;
  // inicio del loop
  while($loop == 1) {

     // actualizar el saldo de cuenta con $serviceId
        if($acum > 0){ 
          $msg = $this->sumAmount($proposalId,$serviceId,$amount);
        }
      // consulta para saber el siguiente nivel de arriba
      $serviceId  = 0;
      $query      =  $this->where('proposalId','=',$proposalId)
                          ->where('serviceId','=',$serviceParentId) //  serviceId = serviceParentId  
                          ->get();
                  
      foreach($query as $row){
          $serviceId          = $row->serviceId;
          if ($row->serviceParentId == 0) { //serviceParentId
             $serviceParentId = 0;          // serviceParentId = 0
          } else {
             $serviceParentId  = $row->serviceParentId;   // serviceParentId = $row-> serviceParentId
          }
      }
      // condicion de salida del ciclo while
      if ($serviceId == 0 ) {
         $loop = 0;
      }
        $acum++;
    }//end of the loop
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return ['alertType' => 'info', 'message' => 'Actualizacion en cascada Exitosa'];
        } else {
            return ['alertType' => 'error', 'message' => $error];
        }
  }//end of the function

  function sumAmount($proposalId,$serviceId,$amount)
  {
    // obtener $saldos actuales
      DB::beginTransaction();
      try {   
          $query = $this->where('proposalId', '=', $proposalId)
                        ->where('serviceId', '=', $serviceId)
                        ->get();
  
            //Actualizar saldos en tabl acc_general_ledger_balance
            foreach($query as $row){
                  $row->amount    = $row->amount + $amount;
                  $row->save();
            }

           $success = true;
           DB::commit();
      } catch (\Exception $e) {
          $error   = $e->getMessage();
          $success = false;
          DB::rollback();
      }
  
      if ($success) {
        return ['alertType' => 'success', 'message' => 'El monto ha sido sumando en el renglon.'];
      } else {
        return ['alertType' => 'error', 'message' => $error];
      }
   }//end function

// FUNCTION OF REPORT PROPOSAL

 //in_service_category (jerarquica 3ero)
    //proposal_detail (detalle final)

    function markLeafItems($collection, $categoryParentId = NULL, $restrictorArrayCleaned, $proposalId)
    {
        foreach ($collection as $item) { //el primer registro de cada coleccion cae aqui (inicialmente las raices)
           
            if (count($item->childrenCategoriesTree) !== 0) {  //Es raiz, no es hoja, pero tiene relacionados

                $item->nivel = 'interno1';
                $item->leaf = false;

                foreach ($item->childrenCategoriesTree as $children) {

                    if (count($children->childrenCategoriesTree) !== 0) { //hijos internos que no son hoja y que tambien tienen hijos (estan entre la raiz y la hoja)

                        $children->nivel = 'interno2';

                        $children->leaf = false;
                        $this->markLeafItems($children->childrenCategoriesTree, $children->categoryId, $restrictorArrayCleaned, $proposalId);
                    } else { //hijos extremos que no tienen hijos, por lo tanto son hoja

                        $children->nivel = 'interno2.1';

                        $children->leaf = true;
                        $this->markLeafItems($children->childrenCategoriesTree, $children->categoryId, $restrictorArrayCleaned, $proposalId);
                    }
                }
            } else { //No tiene hijos, por lo tanto es hoja (entran en este grupo tambien los registros intermedios)

                $item->nivel = 'externo';

                $item->leaf = true;

                $services = ProposalDetail::where('categoryId', $item->categoryId)->where('proposalId', $proposalId)->get();
                   if (count($services) > 0) {
                       $item->unit     = $services[0]->unit;
                       $item->unitCost = $services[0]->unitCost;
                       $item->quantity = $services[0]->quantity;
                    }
                $sumatoriaServiceCategory = $services->sum('amount');

                $item->totalServicesAmount = $sumatoriaServiceCategory;
                $item->services = $services;

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

    public function showAllCompanyCategoriesHierarchicalMode($companyId, $proposalId)
    {
        $categories = ServiceCategory::with('childrenCategoriesTree')
            ->orderBy('categoryCode', 'ASC')
            ->where('categoryParentId', 0)
            ->where('companyId', $companyId)
            ->get();


        $categories_ids_with_services = collect(DB::select('SELECT * FROM in_service_category WHERE EXISTS (SELECT PropDetailId FROM proposal_detail WHERE proposal_detail.categoryId = in_service_category.categoryCode AND companyId =' . $companyId . ' AND proposalId =' . $proposalId . ')'));

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

        $this->markLeafItems($categories, NULL, $restrictorArrayCleaned, $proposalId);
        
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
