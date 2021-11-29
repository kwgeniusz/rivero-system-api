<?php   
/* Enterprise word api
 * Get word

 * Company  :  Kamazooie devlopment Corporation
 * Developer:  Gabriel Carrillo
 * Version  :  2.3
 * Updated  :  22 October 2020
 *             14 December 2020
 *             24 January 2021
 */

namespace App\Http\Controllers\Api\EnterpriseWord;

use Illuminate\Http\Request;
use App\Controllers;
use App\Helpers\FunctionHelper;
use App\Models\Relation;
use App\Models\RelationType;
use App\Models\RelationTermLink;
use App\Models\Term;

use Illuminate\Support\Facades\Config;

class EnterpriseWordController extends \App\Http\Controllers\Controller{


    /*------------------------------------------------------------------
     * getWord
       get enterprise word
     
      Input
        int      $orgid
        string   $translation
     
      Output
        int      $orgid
        string   $aWord   (json)
      
     *-----------------------------------------------------------------*/

    public function getWord(Request $request) {

       $orgid         = trim($request->input('orgid' ));
       $translation   = trim($request->input('translation'  ));
       $aWord         = array();  
       if (is_null($orgid)) {
          $orgid = 0;
       }   

      // Validation

      if(is_null($translation) )
    	  { return \Response::json([ 'message' => 'Invalidad parameters ' ], 400); }
 
      // get tranlatuon in array format
      $type = gettype($translation);  
      if ($type =="string") {
          $aStr =  $this->getArray($translation);

      }
      if ($type =="array") {
          $aStr =  $translation;
      }


      // process elements in the translation array
      $len = count($aStr);

      for ($i=0;$i<$len;$i++)  {
          $str = $aStr[$i];
          $aW  = $this->getArray1($str);
          $aWord[] = $this->getEnterpriseWord($orgid,$aW);
      }
    
	    return \Response::json([ 'orgid'=>$orgid, 'words'=>$aWord ]);

      //----  end of function getEnterpriseWord    -----------------------------//-

	  }

   /*--------------------------------------------------------------------
   *  getArray   Get and array from a string. 
   *   EXAMPLES      "I,lost,job"     
   *                 "I,have,job,and,I,lost,job","economy,caused by,covid-19"
   *  INPUT
   *    $translation  string  translation string
   *  OUTPUT
   *    $aStr         array   translation strings are array elements
   *-------------------------------------------------------------------*/
   public function getArray($translation) {
      $a = str_split($translation);
      $count = count($a);
      $limit = $count - 1;
      $j = -1;
      $i = 0;
      $state = 1;
      $quote = '"';
      $comma = ",";
      $str   = "";
      $loop  = 1;
      $aStr  = array();

      // start of finite state machine
      while ($loop == 1) { 

         switch ($state) {

           case 1:
             $str  = "";               // empty the string
             if ($a[$i] == $quote ) {
                $state = 2;            // next state            
             } 
           break;

           case 2:
             if ($a[$i] == $quote ) {
                $str = $str.$a[$i]; 
                $j++;                  // increase index j
                $str[$j] = $str;
                $state = 4;            // next state            
             } else {
                $str = $str.$a[$i]; 
                $state = 3;            // next state          
             }
           break;

           case 3:
             if ($a[$i] == $quote ) {
                $j++;                  // increase index j
                $aStr[$j] = $str;       // save array element
                $state = 4;            // next state            
             } else {
                $str = $str.$a[$i]; 
                $state = 3;            // next state          
             }
           break;

           case 4:
             if ($a[$i] == $comma ) {
                $str  = "";            // empty the string
                $state = 1;            // next state    
             } 
           break;
         }


         if ($i < $limit ) {           // move to next array index
            $i++;
         } else {
            $loop = 0;                // exit State machine
         }

      }
      // end of finite state machine
      return $aStr;
   }

   /*--------------------------------------------------------------------
   *  getArray   Get and array from a string. 
   *    
   *  INPUT
   *    $translation  string  translation string
   *  OUTPUT
   *    $aStr         array   translation strings are array elements
   *-------------------------------------------------------------------*/
   public function getArray1($translation) {
      $a = str_split($translation);
      $count = count($a);
      $limit = $count - 1;
      $quote = '"';
      $special1 = '[';
      $special2 = ']';

      $aux = array();
      for($i=0;$i<=$limit;$i++) {
         if ($a[$i] == $quote or $a[$i] == $special1 or $a[$i] == $special2) {
             $count--;
         } else {
             $aux[] = $a[$i];
         }
      }

      $aux = implode("",$aux);
      $aux = explode(" ",$aux);

      return $aux;
   }

   /*--------------------------------------------------------------------
   *  getWord   Get valid words from traslation using table term. 
   *  INPUT
   *    $a       string  utterance
   *  OUTPUT
   *    $aStr    array   strings are array elements with enterprise words
   *-------------------------------------------------------------------*/
   public function getEnterpriseWord($orgid,$a) {

      $oTerm          = new Term();
      $aux = array();
      $len = count($a);
      $limit = $len - 1;
      $wcount = 0;
      $loop  = 0;
      $rtgId = 8;   // used in protected access
      if ($limit > 0){
         $loop = 1;
      }


      // beginning of loop
      while ($loop == 1) {

        $wfound   = 0;
        $woffset  = -1;
        $j        = -1;
        $nterm    = "";
        
        /// beginning of foreach        
        for ($i=$limit; $i>=0; $i--) {
           $wterm = $a[$i]; 

              if ($nterm == "") {
                 $nterm = $wterm;
              } else {
                 $nterm = $wterm ." " .$nterm;               
              }

              //$wid = $oTerm->retrieveFilteredTermId($orgid,$nterm,$rtgId);
              $wid = 0;
              $tmp = $oTerm->retrieveFilteredTermId($orgid,$nterm,$rtgId);
              foreach($tmp as $rs0) {                   
                 $wid = $rs0->termId;
                 $ownsp = $rs0->ownership;
                 $ownId = $rs0->ownerId;
                 $owName = $rs0->termName;
                 $lorgid = $rs0->leftOrgId;
                 $rorgid = $rs0->rightOrgId;
                 $rtg    = $rs0->relationTypeGroupId;
//echo " BB NOMBRE=$owName ONERSHIP=$ownsp, ID=$ownId; lorgid=$lorgid; rorgid=$rorgid; rtg=$rtg; ";                
              }              

              if ($wid > 0) {
                 $wfound = 1;
                 $woffset = $i;
                 $wcount++;

                if ($j > -1 and $wcount > 1) {
                   $aux[$j] = $nterm;                      
                } else {
                   $aux[] = $nterm;                 
                }

                $j = count($aux) - 1;

              }

        }
        //// end of foreach

        if ($wfound == 1) {
           $limit = $woffset - 1;
        } else {
           $limit--;
        }

        if ($limit < 0) {
           $loop = 0;
        }

      }
      // end of loop

      $aux = array_reverse($aux);
      $aux = $this->getOffset($aux,$a);
      return $aux;

   }


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
