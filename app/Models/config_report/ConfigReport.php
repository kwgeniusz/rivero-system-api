<?php

namespace App\Models\config_report;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConfigReport extends Model
{
    public $timestamps = false;

    protected $table      = 'config_report';
    protected $primaryKey = 'reportId';

    protected $fillable = ['countryId', 'companyId', 'report', 'fieldType', 'size', 'fontType', 'value', 'x1',
        'x2', 'width', 'high', 'x2', 'y2', 'r', 'g', 'b'];

    public function getConfigReportByCompany($countryId, $companyId, $report, $module="normal")
    {
        $reports = DB::select("select * from `config_report` 
            where `countryId` = $countryId 
            AND `companyId` = $companyId 
            AND `report` = '$report'
            AND `module` = '$module'");
        // table('config_report')
        //     ->where('countryId', '=', $countryId)
        //     ->where('companyId', '=', $companyId)
        //     ->where('report', '=', $report)
        //     ->where('module', '=', ''.$module.'')
        //     ->get();
        return $reports;
    }
}
