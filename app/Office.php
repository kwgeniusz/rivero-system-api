<?php

namespace App;

use App\Contract;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $table      = 'office';
    protected $primaryKey = 'officeId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'officeId',
        'countryId',
        'officeName',
        'officeAddress',
        'officePhone',
        'officeEmail',
        'dateCreated',
        'lastUserId',
    ];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function contract()
    {
        return $this->hasMany('App\Contract', 'officeId', 'officeId');
    }
}
