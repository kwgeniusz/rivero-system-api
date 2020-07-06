<?php

namespace App;

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
    protected $fillable = ['proposalId','propId','countryId','officeId','clientId','address','proposalDate','currencyId','grossTotal','taxPercent','taxAmount','netTotal','pCondId'];

     protected $appends = ['grossTotal','taxAmount','netTotal'];
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
        return $this->belongsTo('App\Invoice', 'invoiceId','invoiceId');
    }
    public function currency()
    {
        return $this->belongsTo('App\Currency', 'currencyId');
    }
      public function proposalDetail()
    {
        return $this->hasMany('App\ProposalDetail', 'proposalId')->orderBy('itemNumber');
    }
     public function note()
    {
      return $this->belongsToMany('App\Note', 'proposal_note', 'proposalId', 'noteId')->withPivot('propNoteId');
    }
     public function scope()
    {
      return $this->hasMany('App\ProposalScope', 'proposalId', 'proposalId');
    }
    public function paymentCondition()
    {
      return $this->belongsTo('App\PaymentCondition', 'pCondId', 'pCondCode');
    }
     public function paymentProposal()
    {
        return $this->hasMany('App\PaymentProposal', 'proposalId','proposalId');
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
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
         $newDate    = $oDateHelper->$functionRs($proposalDate);
        return $newDate;
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
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
         $newDate    = $oDateHelper->$functionRs($proposalDate);

        $this->attributes['proposalDate'] = $newDate;
    }
   

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    
  public function getAllByOffice($officeId)
    {
        return $this->where('officeId' , '=' , $officeId)
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
    public function findById($id,$countryId,$officeId)
    {
        return $this->where('proposalId', '=', $id)
                    ->where('countryId', $countryId)
                    ->where('officeId', $officeId) 
                    ->get();
    }
//------------------------------------------
    public function insertProp($countryId,$officeId,$modelType,$modelId,$clientId,$projectDescriptionId, $proposalDate,$taxPercent,$paymentConditionId,$status) {

          $oConfiguration = new OfficeConfiguration();
          $propId = $oConfiguration->retrieveProposalNumber($countryId, $officeId);
          $propId++;
                    $oConfiguration->increaseProposalNumber($countryId, $officeId);



        $proposal                   = new Proposal;
        $proposal->propId           =  $propId;
        $proposal->countryId        =  $countryId;
        $proposal->officeId         =  $officeId;
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
