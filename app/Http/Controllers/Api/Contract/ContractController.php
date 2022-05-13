<?php   
/* Contract api
 *
 * Function : getContract
 * Developer:  Gabriel Carrillo, Manuel Castro
 */

namespace App\Http\Controllers\Api\Contract;

use Illuminate\Http\Request;
use App\Controllers;
use App\Contract;

use Illuminate\Support\Facades\Config;

class ContractController extends \App\Http\Controllers\Controller {


    /*------------------------------------------------------------------
     * getContract
       get company
     
      Input
        int      $ContractId
     
      
     *-----------------------------------------------------------------*/

    public function getContract(Request $request) {

        //--default values  -----------------------
        $contractId     = 0; 
        $oContract      =  new Contract();

        //-- parameters   -------------------------
        if($request->has('contractId')){ 
             $contractId     = trim($request->input('contractId'));  
        }

        //-- read Contract data  -------------------
        if ($contractId == 0) {           // leer todos los paises
         $rs = $oContract->getAll();
        } else {                         // leer un pais
         $rs = $oContract->findById($contractId);
        }


        //-- prepare output   ---------------------
      //   $aContract      = array(); 

      //   foreach ($rs as $rows) {
        	
      //      $contractId     = $rows->contractId;
      //      $contractName   = $rows->contractName;	

      //      $aContract[] = ['ContractId' => $ContractId, 'ContractName'=>$ContractName  ];        	
      //   } 


        //-- send output  --------------------------   
	    return \Response::json($rs);

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
