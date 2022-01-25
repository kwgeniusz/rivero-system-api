<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    // *-----------------------------------------------------------------*/

    public function getUser(Request $request) {

        //--default values  -----------------------
        $userId     = 0; 
        $oCountry      =  new Country();

        //-- parameters   -------------------------
        if($request->has('countryId')){ 
             $countryId     = trim($request->input('countryId'));  
        }

        //-- read country data  -------------------
        if ($countryId == 0) {           // leer todos los paises
         $rs = $oCountry->getAll();
        } else {                         // leer un pais
         $rs = $oCountry->findById($countryId);
        }


        //-- prepare output   ---------------------
        $aCountry      = array(); 

        foreach ($rs as $rows) {
        	
           $countryId     = $rows->countryId;
           $countryName   = $rows->countryName;	

           $aCountry[] = ['countryId'=>$countryId, 'countryName'=>$countryName  ];        	
        } 


        //-- send output  --------------------------   
	    return \Response::json([ 'country'=>$aCountry ]);

	}

    //----  end of function getCompany    -------------------------

}
