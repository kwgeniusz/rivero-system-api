<?php

namespace App\Models\config_Report;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConfigReport extends Model
{
    public $timestamps = false;

    protected $table      = 'config_report';
    protected $primaryKey = 'reportId';

    protected $fillable = ['countryId', 'companyId', 'report', 'fieldType', 'size', 'fontType', 'value', 'x1',
        'x2', 'width', 'high', 'x2', 'y2', 'r', 'g', 'b'];

    public function getConfigReportByCompany($countryId, $companyId, $report)
    {
        $reports = DB::table('config_report')
            ->where('countryId', '=', $countryId)
            ->where('companyId', '=', $companyId)
            ->where('report', '=', $report)
            ->get();
        return $reports;
    }
}
