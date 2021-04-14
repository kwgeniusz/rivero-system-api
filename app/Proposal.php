<?php

namespace App;

use Carbon\Carbon;
use App;
use App\Helpers\DateHelper;
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
    protected $fillable = ['proposalId','propId','countryId','companyId','clientId','address','proposalDate','currencyId','grossTotal','taxPercent','taxAmount','netTotal','pCondId'];

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
        return $this->hasMany('App\ProposalDetail', 'proposalId')->orderBy('itemNumber');
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
      return $this->hasMany('App\ProposalTerm', 'proposalId', 'proposalId')->orderBy('propTermId');
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
        return $this->where('companyId' , '=' , $companyId)
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
        $result = $this->with("paymentCondition",'projectDescription')
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
        return $this->with('user')
                    ->where('proposalId', '=', $id)
                    ->where('countryId', $countryId)
                    ->where('companyId', $companyId) 
                    ->get();
    }
//------------------------------------------
    public function insertProp($countryId,$companyId,$modelType,$modelId,$clientId,$projectDescriptionId, $proposalDate,$taxPercent,$paymentConditionId,$status,$userId) {

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
        $proposal->userId    =  $userId;
        $proposal->save();

      
        return $proposal->proposalId;

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
  //-------------------------------------------------
      public function updateProposalTotal($sign, $proposalId, $amount)
    {


        if ($sign == '+') {
              $proposal = Proposal::find($proposalId);
                    $grossTotal = $proposal->grossTotal + $amount;
                    $proposal->grossTotal = number_format((float)$grossTotal, 2, '.', '');
            } else {
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

    public function updateSubcontractor($proposalId, $subcontId) 
    {

        $proposal             = proposal::find($proposalId);
        $proposal->subcontId  = $subcontId;
        $proposal->save();

         $rs  = ['alertType' => 'success', 'message' => "Se ha Modificado el Subcontratista de la Propuesta",'model'=>$proposal];

         return $rs;
    }

    public function deleteProposal($proposalId)
    {
        return $this->where('proposalId', '=', $proposalId) 
                    ->delete();
    }
   public function assignInvoiceId($proposalId,$invoiceId)
    {
         $proposal                = proposal::find($proposalId);
         $proposal->invoiceId     = $invoiceId;
         $proposal->save();
    }
}
