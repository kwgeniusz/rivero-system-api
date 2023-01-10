<?php

namespace App;

use App;
use Auth;
use DB;
use App\Precontract;
use App\Country;
use App\Helpers\DateHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends Model
{
    //traits
    use SoftDeletes;

    // private $oDateHelper = new DateHelper;
    public $timestamps = false;

    protected $table      = 'proposal';
    protected $primaryKey = 'proposalId';
    protected $fillable = ['proposalId','propId','countryId','companyId','clientId','address','proposalDate','currencyId','grossTotal','taxPercent','taxAmount','netTotal','pCondId','paymentMethods'];

     protected $appends = ['grossTotal','taxAmount','netTotal','pQuantity','proposalDate'];
     protected $dates = ['deleted_at'];
 
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function client()
    {
        return $this->belongsTo('App\Client', 'clientId');
    }
    public function precontract()
    {
        return $this->belongsTo('App\Precontract', 'precontractId','precontractId');
    }
     public function contract()
    {
        return $this->belongsTo('App\Contract', 'contractId','contractId');
    }
      public function projectDescription()
    {
        return $this->belongsTo('App\ProjectDescription', 'projectDescriptionId');
    }
   public function invoice()
    {
        return $this->hasOne('App\Invoice', 'invoiceId','invoiceId');
    }
    public function currency()
    {
        return $this->belongsTo('App\Currency', 'currencyId');
    }
      public function proposalDetail()
    {
        return $this->hasMany('App\ProposalDetail', 'proposalId')
                    ->with('category','service')
                    ->orderBy('serviceId');
    }
     public function scope()
    {
      return $this->hasMany('App\ProposalScope', 'proposalId', 'proposalId');
    }
     public function timeFrame()
    {
      return $this->hasMany('App\ProposalTimeFrame', 'proposalId', 'proposalId')->orderBy('propTimeId');
    }
     public function term()
    {
      return $this->hasMany('App\ProposalTerm', 'proposalId', 'proposalId')->orderBy('termName');
    }
     public function note()
    {
        return $this->hasMany('App\ProposalNote', 'proposalId')->orderBy('propNoteId');
    }
    public function paymentCondition()
    {
      return $this->belongsTo('App\PaymentCondition', 'pCondId', 'pCondCode');
    }
     public function paymentProposal()
    {
        return $this->hasMany('App\PaymentProposal', 'proposalId','proposalId');
    }
    public function subcontractor()
    {
        return $this->hasOne('App\Subcontractor', 'subcontId','subcontId');
    }
     public function user()
    {
        return $this->belongsTo('App\User', 'userId', 'userId')->withTrashed();
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
    public function getProposalDateAttribute($proposalDate)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['proposalDate'], 'UTC');
        $date->tz = session('companyTimeZone');   // ... set to the current users timezone
        return $date->format('Y-m-d H:i:s');
    }
     public function getPQuantityAttribute()
    {
          return $this->paymentProposal->count();
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
     public function setProposalDateAttribute($proposalDate)
    {
        $date = Carbon::createFromFormat('Y-m-d', $proposalDate, session('companyTimeZone'));
        $date->setTimezone('UTC');
        $this->attributes['proposalDate'] = $date;
    }
   

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    
  public function getAllByCompany($companyId)
    {
        return $this->with('client','paymentCondition','projectDescription','user')
            ->where('companyId' , '=' , $companyId)
            ->orderBy('propId', 'DESC')
            ->get();
    }   

    public function getAllByContract($contractId)
    {
        $result = $this->where('contractId', $contractId)
            ->orderBy('proposalId', 'ASC')
            ->get();

        return $result;
    }   

    public function getAllByPrecontract($precontractId)
    {
        $result = $this->with('paymentCondition','projectDescription')
            ->where('precontractId', $precontractId)
            ->orderBy('proposalId', 'ASC')
            ->get();

        return $result;
    }
    //------------------------------------------
    // public function findByPrecontract($precontractId)
    // {
    //     return $this->where('precontractId', '=', $precontractId)
    //                 ->where('deleted_at', null)
    //                 ->get();
    // }
//------------------------------------------
    public function findById($id,$countryId,$companyId)
    {
        return $this->with('proposalDetail', 'scope', 'timeFrame', 'term', 'note', 'paymentProposal', 'subcontractor', 'user')
                    ->where('proposalId', '=', $id)
                    ->where('countryId', $countryId)
                    ->where('companyId', $companyId) 
                    ->get();
    }
//------------------------------------------
    public function insertProp($countryId,$companyId,$modelType,$modelId,$clientId,$projectDescriptionId, $proposalDate, $taxPercent, $paymentConditionId, $paymentMethods, $status ,$userId) {


        $error = null;
        
        DB::beginTransaction();
         try {

          $oConfiguration = new CompanyConfiguration();
          $propId = $oConfiguration->retrieveProposalNumber($countryId, $companyId);
          $propId++;
                    $oConfiguration->increaseProposalNumber($countryId, $companyId);
        $proposal                   = new Proposal;
        $proposal->propId           =  $propId;
        $proposal->countryId        =  $countryId;
        $proposal->companyId         =  $companyId;
        if($modelType == 'pre_contract'){
          $proposal->precontractId    =  $modelId;
        }else{
          $proposal->contractId       =  $modelId;
        }
        $proposal->clientId         =  $clientId;
        $proposal->projectDescriptionId     =  $projectDescriptionId;
        $proposal->proposalDate     =  $proposalDate;
        $proposal->grossTotal       =  '0.00';
        $proposal->taxPercent       =  $taxPercent;
        $proposal->taxAmount        =  '0.00';
        $proposal->netTotal         =  '0.00';
        $proposal->pCondId          =  $paymentConditionId;
        $proposal->paymentMethods   =  $paymentMethods;
        $proposal->userId    =  $userId;
        $proposal->save();

               $success = true;
               DB::commit();
           } catch (\Exception $e) {
               $success = false;
               $error   = $e->getMessage();
               DB::rollback();
           }
   
           if ($success) {
               return $proposal;
           } else {
               return $rs = ['alert' => 'error', 'message' => $error];
           }
    }
    //------------------------------------------
    public function updateProposal($proposalId, $paymentConditionId,$projectDescriptionId, $proposalDate, $taxPercent) {

        $proposal                     = proposal::find($proposalId);
        $proposal->pCondId            = $paymentConditionId;
        $proposal->projectDescriptionId     =  $projectDescriptionId;
        $proposal->proposalDate       = $proposalDate;
        $proposal->taxPercent         = $taxPercent;
        $proposal->save();

         //para ajustar los montos de la propuesta segundo el porcentaje indicado
         $this->updateProposalTotal('+', $proposalId, '0');


         return $proposal;

    }
    //------------------------------------------
    public function deleteProposal($proposalId)
    {
        return $this->where('proposalId', '=', $proposalId) 
                    ->delete();
    }  
    //-------------------------------------------------
      public function updateProposalTotal($sign, $proposalId, $amount)
    {
        if ($sign == '+') {
              $proposal = Proposal::find($proposalId);
                    $grossTotal = $proposal->grossTotal + $amount;
                    $proposal->grossTotal = number_format((float)$grossTotal, 2, '.', '');
        }else {
              $proposal = Proposal::find($proposalId);
                if ($proposal->grossTotal < $amount) {
                    throw new \Exception('Error: El monto de la propuesta no puede ser menor que 0.00');
                } else {
                  $grossTotal = $proposal->grossTotal - $amount;
                  $proposal->grossTotal = number_format((float)$grossTotal, 2, '.', '');
                }
        }
              $taxAmount   = ($proposal->grossTotal * $proposal->taxPercent)/100;
              $proposal->taxAmount = number_format((float)$taxAmount, 2, '.', '');
              $netTotal    = $proposal->taxAmount + $proposal->grossTotal;
              $proposal->netTotal = number_format((float)$netTotal, 2, '.', '');

              $proposal->save();
    }
//-------------------------------------------------
    public function updateSubcontractor($proposalId, $subcontId) 
    {
        $proposal             = proposal::find($proposalId);
        $proposal->subcontId  = $subcontId;
        $proposal->save();

         $rs  = ['alertType' => 'success', 'message' => "Se ha Modificado el Subcontratista de la Propuesta",'model'=>$proposal];

         return $rs;
    }
//-------------------------------------------------
    public function assignInvoiceId($proposalId,$invoiceId)
    {
         $proposal                = proposal::find($proposalId);
         $proposal->invoiceId     = $invoiceId;
         $proposal->save();
    }
//-------------------------------------------------
    public function duplicateProp($proposalId, $precontractId)
    {
        $error = null;
        
        DB::beginTransaction();
         try {
        
        $company     = Company::find(session('companyId'));

        // Buscar la Propuesta a utilizar para la duplicacion
          $proposal  = $this->findById($proposalId,session('countryId'),session('companyId'));
 
        // Busca los datos del precontrato destino, para agregarlos en la nueva propuesta
          $oPrecontract = new Precontract;
          $destinationPrecontract  = $oPrecontract->findById($precontractId,session('countryId'),session('companyId'));

        // Crear la Nueva Propuesta
        $newProposalId  =   $this->insertProp(
            $proposal[0]->countryId,
            $proposal[0]->companyId,
            'pre_contract',//esta funcion trae el nombre de la tabla para saber a que campo de la tabla(proposal) insertare el id , en este caso tengo dos opciones precontract y contract
            $destinationPrecontract[0]->precontractId,//se trae el id de la tabla que halla escogido el usuasio en formulario create .
            $destinationPrecontract[0]->clientId,
            $proposal[0]->projectDescriptionId,
            Carbon::now()->format('Y-m-d'), //poner funcion de fecha de hoy
            $proposal[0]->taxPercent,
            $proposal[0]->pCondId, 
            $company->paymentMethods,
            '1',
            Auth::user()->userId);

          
    //Insercion de Servicios de la propuesta
    if($proposal[0]->proposalDetail->isNotEmpty()) {
         
          $oProposalDetail = new App\ProposalDetail;
          foreach ($proposal[0]->proposalDetail as $key => $item) {
              $result = $oProposalDetail->insert(
                  $newProposalId,
                  $item->itemNumber,
                  $item->serviceId,
                  $item->serviceName,
                  $item->unit,
                  $item->unitCost,
                  $item->quantity,
                  $item->amount);
                }
        }

        //Insercion de Notas de la propuesta
        if($proposal[0]->note->isNotEmpty()) {

            $oProposalNote = new App\ProposalNote;
              foreach ($proposal[0]->note as $key => $item) {
                   $result = $oProposalNote->insert(
                    $newProposalId,
                    $item->noteId,
                    $item->noteName);
                if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
              };
             
        }
    //Insercion de Alcances
        if($proposal[0]->scope->isNotEmpty()) {
        
            $oProposalScope = new App\ProposalScope;
            foreach ($proposal[0]->scope as $key => $item) {
                 $result = $oProposalScope->insert(
                    $newProposalId,
                    $item->description);
    
                    if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
                  };
        }
    //Insercion de Terminos y condiciones
        if($proposal[0]->term->isNotEmpty()) {

            $oProposalTerm = new App\ProposalTerm;
              foreach ($proposal[0]->term as $key => $item) {
                   $result = $oProposalTerm->insert(
                    $newProposalId,
                    $item->termId,
                    $item->termName);
      
                  if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
              };   
        }
    // Insercion de Times Frames
        if($proposal[0]->timeFrame->isNotEmpty()) {
            
            $oProposalTimeFrame = new App\ProposalTimeFrame;
            foreach ($proposal[0]->timeFrame as $key => $item) {
                 $result = $oProposalTimeFrame->insert(
                  $newProposalId,
                  $item->timeId,
                  $item->timeName);
    
                  if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
            };
         }
    // Insertar Cuotas de la propuesta
        //  if($proposal[0]->paymentProposal->isNotEmpty()) {

        //     $oPaymentProposal = new App\PaymentProposal;
        //     foreach ($proposal[0]->paymentProposal as $key => $item) {
        //         $result = $oPaymentProposal->addPayment(
        //             $newProposalId,
        //             $item->amount,
        //             $item->paymentDate
        //         );
        //           if($result['alert'] == 'error'){ throw new \Exception($result['message']); }
        //     };
        //  }
               $success = true;
               DB::commit();
           } catch (\Exception $e) {
               $success = false;
               $error   = $e->getMessage();
               DB::rollback();
           }
   
           if ($success) {
                return $rs  = ['alert' => 'success', 'message' => "Propuesta Duplicada con Exito"];
           } else {
                return $rs  = ['alert' => 'error', 'message' => $error];
           }
    
    }
}
