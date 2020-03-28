<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model
{
    protected $table      = 'invoice_status';
    protected $primaryKey = 'invStatusId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invStatusId',
        'invStatusCode',
        'language',
        'invStatusName',
    ];

}
