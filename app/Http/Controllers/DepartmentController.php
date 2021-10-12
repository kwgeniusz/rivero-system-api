<?php

namespace App\Http\Controllers;

use App\RrhhDepartment;
use App\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyId = session('companyId');
        // $companyId = session('companyId');
        return DB::select("SELECT * FROM `department` 
        LEFT JOIN `company` ON department.companyId = company.companyId
        LEFT JOIN ( SELECT departmentName as dpParentName, departmentId as dpId FROM department) dpName 
        	On department.parentDepartmentId = dpName.dpId  
        WHERE department.companyId = $companyId
        ORDER BY department.departmentId ASC");
    
    }
    public function editDepartment($id)
    {
        // return DB::select("SELECT * FROM `department` 
        // LEFT JOIN `company` ON department.companyId = company.companyId
        // LEFT JOIN ( SELECT departmentName as dpParentName, departmentId as dpId FROM department) dpName 
        // 	On department.parentDepartmentId = dpName.dpId");
        // return RrhhDepartment::find($id);
        return RrhhDepartment::where('departmentId', $id)->get();
    }
    public function parent()
    {
        $companyId = session('companyId');
        // return DB::select("SELECT departmentName as nameParent FROM department             
        // WHERE departmentId = $id");
        return RrhhDepartment::orderBy('departmentId', 'ASC')
                ->where('department.companyId', '=',$companyId)
                // ->where('countryId', '=',session('companyId'))
                ->get();
    }
    public function searchCompany()
    {
        $companyId = session('companyId');
        return Company::orderBy('companyId', 'ASC')
            ->where('companyId', '=',$companyId)
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $department = new RrhhDepartment();
        $department->companyId = $request->companyId;
        $department->departmentName = $request->departmentName;
        $department->parentDepartmentId = $request->parentDepartmentId;
        $department->save();
        return $department;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
 
        // return $request;
        $department = RrhhDepartment::find($id);
        // return $department;
        $department->departmentName = $request->departmentName;
        $department->save();
        return $department;
        // return "entro";
    }
    public function updateHard(Request $request, $id)
    {
 
        // return $request;
        $department = RrhhDepartment::find($id);
        // return $department;
        $department->companyId = $request->companyId;
        $department->departmentName = $request->departmentName;
        $department->parentDepartmentId = $request->parentDepartmentId;
        $department->save();
        return $department;
        // return "entro";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = RrhhDepartment::find($id);
        $department->delete();
        // return "entro";
    }
}
