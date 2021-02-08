<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimePayment extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table = 'time_payment';
    protected $primaryKey = 'timePaymentId';
    protected $fillable = ['timePaymentId', 'countryId', 'companyId', 'timeName', 'deleted_at'];

    protected $dates = ['deleted_at'];

    //--------------------------------------------------------------------
    /** Relations */
    //--------------------------------------------------------------------
    public function proposal()
    {
        return $this->belongsToMany('App\Proposal');
    }

    //--------------------------------------------------------------------
    /** Function of Models */
    //--------------------------------------------------------------------
    public function findById($id)
    {
        return $this->where('timePaymentId', '=', $id)->get();
    }

    public function getAllByCompany($companyId)
    {
        return $this->where('companyId', '=', $companyId)
            ->orderBy('timePaymentId', 'ASC')
            ->get()
        ;
    }
}
