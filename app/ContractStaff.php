<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractStaff extends Model
{
    protected $table ='contract_staff';
    protected $primaryKey = 'contractStaffId';
    public    $timestamps = false;

            /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [	
           'contractStaffId',
           'contractId',
           'staffId',
           'dateCreated',
           'lastUserId'
        ];

}
