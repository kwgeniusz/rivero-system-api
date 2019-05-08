<?php

namespace App;

use App\Transaction;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    public $timestamps = false;

    protected $table      = 'bank';
    protected $primaryKey = 'bankId';
    protected $fillable   = [
        'bankId',
        'bankName',
        'initialBalance',
        'balance01',
        'balance02',
        'balance03',
        'balance04',
        'balance05',
        'balance06',
        'balance07',
        'balance08',
        'balance09',
        'balance10',
        'balance11',
        'balance12',
    ];
    //--------------------------------------------------------------------
    /** Relations */
    //--------------------------------------------------------------------
    public function transaction()
    {
        return $this->hasMany('App\Transaction', 'transactionId');
    }
    //-----

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('bankId', 'ASC')->get();
    }
//------------------------------------------
    public function findById($id)
    {
        return $this->where('bankId', '=', $id)->get();
    }
//------------------------------------------
    public function insertB($bankName, $countryId)
    {

        $bank              = new Bank;
        $bank->bankName    = $bankName;
        $bank->countryId   = $countryId;
        $bank->bankAccount = "00000000000000000000";
        $bank->save();
    }
//------------------------------------------
    public function updateB($bankId, $bankName, $initialBalance, $balance01, $balance02, $balance03, $balance04, $balance05,
        $balance06, $balance07, $balance08, $balance09, $balance10, $balance11, $balance12) {
        $this->where('bankId', $bankId)->update(array(
            'bankName'       => $bankName,
            'initialBalance' => $initialBalance,
            'balance01'      => $balance01,
            'balance02'      => $balance02,
            'balance03'      => $balance03,
            'balance04'      => $balance04,
            'balance05'      => $balance05,
            'balance06'      => $balance06,
            'balance07'      => $balance07,
            'balance08'      => $balance08,
            'balance09'      => $balance09,
            'balance10'      => $balance10,
            'balance11'      => $balance11,
            'balance12'      => $balance12,
        ));
    }
//------------------------------------------
    public function updateBalanceForBank($sign, $bankId, $month, $amount)
    {

        $balance = $this->select('balance' . $month)->where('bankId', '=', $bankId)->get();

        if ($sign == '+') {
            $this->where('bankId', $bankId)->increment('balance' . $month, $amount);
        } else {

            $this->where('bankId', $bankId)->decrement('balance' . $month, $amount);
        }
    }
//------------------------------------------
    public function deleteB($bankId)
    {
        return $this->where('bankId', '=', $bankId)->delete();
    }
//------------------------------------------
}
