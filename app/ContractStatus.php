<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractStatus extends Model
{
    protected $table      = 'contract_status';
    protected $primaryKey = 'contStatusId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contStatusId',
        'contStatusCode',
        'language',
        'contStatusName',
    ];

//--------------------- FUNCTIONS--------------------------------------//
         public function getAllByLanguage($language)
    {
         //se trae las condiciones de pago por el lenguaje que esta en la tabla pais
        return $this->where('language' , '=' , $language)
          ->orderBy('contstatusCode', 'ASC')
          ->get();

    }
}
