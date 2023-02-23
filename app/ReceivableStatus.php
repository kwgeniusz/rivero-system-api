<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceivableStatus extends Model
{
    protected $table      = 'receivable_status';
    protected $primaryKey = 'recStatusId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recStatusId',
        'recStatusCode',
        'language',
        'recStatusName',
        'pending'
    ];
}
