<?php

namespace App\Http\Controllers\Web;

use App\CostCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class CostCategoryController extends Controller
{
    private $oCostCategory;

    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware("permission:BA");
        $this->oCostCategory           = new CostCategory;
    }

    public function index(Request $request)
    {
        $costCategories = $this->oCostCategory->getAll();

         if($request->ajax()){
                return $costCategories;
            }
            
        // return view('module_administration.CostCategorys.index', compact('CostCategorys'));
    }

    public function subcategories(Request $request)
    {
        $subcategories = $this->oCostCategory->getAllSubCategoryById($request->id);

         if($request->ajax()){
                return $subcategories;
            }
            
        // return view('module_administration.CostCategorys.index', compact('CostCategorys'));
    }


}
