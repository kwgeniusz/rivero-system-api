<?php

namespace App\Models\human_resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HrAccTransaction extends Model
{
    public $timestamps = false;

    protected $table      = 'acc_transaction_tmp';
    protected $primaryKey = 'transactionId';

    protected $guarded = ['transactionId'];

    protected $dates = [
        'entryDate',
    ];

    
}
