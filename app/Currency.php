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

   public function getAll()
    {
        return $this->orderBy('currencyId', 'ASC')
                    ->get();
    }

    public function getCurrencyTax($id = 1){
        return  DB::table('currency')
                ->select('exchangeRate')
                ->where('currencyId', '=',$id)
                ->get();
    }

}
