<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class PaymentCondition extends Model
{
    protected $table      = 'payment_condition';
    protected $primaryKey = 'pCondId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pCondId',
        'pCondNameEn',
        'pCondNameSp',
    ];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll($location)
    {
        if($location == 'es') { 
           $result = $this->select('pCondId','pCondNameSp')
                       ->get();
          }else{
            $result = $this->select('pCondId','pCondNameEn')
                       ->get();
          }
        return $result;
    }
//------------------------------------------

}
