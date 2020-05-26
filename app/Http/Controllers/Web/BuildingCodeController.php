<?php

namespace App\Http\Controllers\Web;

use App\BuildingCode;
use App\Http\Controllers\Controller;

class BuildingCodeController extends Controller
{
	 private $oBuildingCode;

    public function __construct()
    {
        $this->oBuildingCode   = new BuildingCode;
    }

      public function index()
    {
        $buildingCodes = $this->oBuildingCode->getAll();

        return $buildingCodes;
    }

  public function getGroups($buildingCodeId)
   {
       $buildingCodeGroups = BuildingCode::find($buildingCodeId)->group()->get();

       return $buildingCodeGroups;
   }
}
