<?php   
/* Country api
 *
 * Function : getCountry
 * Developer:  Gabriel Carrillo, Manuel Castro
 */

namespace App\Http\Controllers\Api\Country;

use Illuminate\Http\Request;
use App\Controllers;
use App\Models\Country;

use Illuminate\Support\Facades\Config;

class CountryController extends \App\Http\Controllers\Controller{


    /*------------------------------------------------------------------
     * getCountry
       get company
     
      Input
        int      $countryId
     
      
     *-----------------------------------------------------------------*/

    public function getCountry(Request $request) {

        //--default values  -----------------------
        $countryId     = 0;

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



   /*--------------------------------------------------------------------
   *  getOffset          
   *-------------------------------------------------------------------*/
   public function getOffset($a,$aStr) {

      $haystack = implode(" ",$aStr);
      $len = count($a);
      $aWord = array();

      for  ($i=0;$i < $len; $i++) {
         $needle = $a[$i];
         $pos = strpos($haystack,$needle); 
         $aWord[] = ['offset'=>$pos, 'term'=>$needle  ];
      }

      return $aWord;
   }

    /*--- end of function getOffset---- */


}
