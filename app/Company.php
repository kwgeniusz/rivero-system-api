<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps = false;

    protected $table      = 'company';
    protected $primaryKey = 'companyId';

    protected $fillable = ['companyName', 'companyShortName', 'companyNumber', 'companyId', 'officeId', 'companyAddress'];
    
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function companyConfiguration()
    {
        return $this->hasOne('App\CompanyConfiguration', 'companyId', 'companyId');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function findById($companyId)
    {
        return $this->where('companyId', '=', $companyId)->get();
    }

    // Obtener todos los registro
    public function findByCompany($countryId,$companyId)
    {
        return $this->where('countryId', '=', $countryId)
                    ->where('companyId', '=', $companyId)   
                    ->get();
    }

    // Obtener todos los registroasd
    public function getAllByCountry($countryId)
    {
        return $this->where('countryId','=',$countryId)
                    ->orderBy('companyId', 'ASC')
                    ->get();
    }

}
