<?php   
/* Company api
 *
 * Function : getCompany
 * Developer:  Gabriel Carrillo, Manuel Castro
 */

namespace App\Http\Controllers\Api\Company;

use Illuminate\Http\Request;
use App\Controllers;
use App\Company;   // revisar

use Illuminate\Support\Facades\Config;

class CompanyController extends \App\Http\Controllers\Controller{


    /*------------------------------------------------------------------
     * getCompany
       get company
     
      Input
        int      $companyId
     
      
     *-----------------------------------------------------------------*/

    public function getCompany(Request $request) {

        //--default values  -----------------------
        $countryId     = 0;
        $companyId     = 0;
        $oCompany      = new Company();

        //-- parameters   -------------------------
        if($request->has('countryId')){ 
             $countryId     = trim($request->input('countryId' ));  
        }
        if($request->has('companyId')){ 
             $companyId     = trim($request->input('companyId' ));  
        }  

        // -- Validation --------------------------
        if( $countryId == 0 ) {
           return \Response::json([ 'message' => 'countryId is empty' ], 400); 
        }


        //-- read company data  -------------------

        if ($companyId == 0) {           // leer todos las compañais
         $rs = $oCompany->getAllByCountry($countryId);
        } else {                         // leer un compania
         $rs = $oCompany->findById($companyId);
        }



        //-- prepare output   ---------------------
        $aCompany      = array(); 

        foreach ($rs as $rows) {
           $countryId     = $rows->countryId;       	
           $companyId     = $rows->companyId;
           $companyName   = $rows->companyName;	

           $aCompany[] = ['countryId'=>$countryId,'countryId'=>$companyId, 'companyName'=>$companyName  ];        	
        } 


        //-- send output  --------------------------   
	    return \Response::json([ 'company'=>$aCompany ]);

	}

    //----  end of function getCompany    -------------------------


    /*--- end of function getOffset---- */


}
