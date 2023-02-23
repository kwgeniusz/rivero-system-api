<?php

namespace App;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    public $timestamps = false;

    protected $table      = 'currency';
    protected $primaryKey = 'currencyId';
    protected $fillable   = ['currencyId', 'currencyName','currencySymbol' , 'exchangeRate'];

     protected $dates = ['deleted_at'];
//--------------------------------------------------------------------
   /** Relations */
//--------------------------------------------------------------------  
    public function contract()
    {
        return $this->belongsTo('App\Contract', 'currencyId', 'currencyId');
    }
    public function invoice()
    {
        return $this->belongsTo('App\Invoice', 'currencyId', 'currencyId');
    }

//--------------------------------------------------------------------
   /**  */
//--------------------------------------------------------------------  

   public function getAllDisplay()
    {
        return $this->where('displayCurrency', '=', 1)
                    ->orderBy('currencyId', 'ASC')
                    ->get();
    }

    public function getExchangeRate($baseCurrency = 'USD', $localCurrency = 'VEF'){
        return  DB::table('currency')
                ->select('currencyName','currencySymbol','localCurrency','exchangeRate')
                ->where('currencyName', '=',$baseCurrency)
                ->where('localCurrency', '=',$localCurrency)
                ->where('displayCurrency', '=',0)
                ->get();
    }
    public function getAllCurrency(){
        return  DB::table('currency')
                ->orderBy('currencyId', 'ASC')
                ->get();
    }

}
