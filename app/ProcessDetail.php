<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessDetail extends Model
{
    public $timestamps = false;

    protected $table      = 'hrprocess_detail';
    protected $primaryKey = 'hrpdId';

    protected $fillable = ['hrprocessId', 'hrtransactionTypeId', 'quantity', 'amount'];
    


}
