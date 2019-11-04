<?php
/*--------------------------------------------------------------------------------
 *  File          : FunctionHelper.php        
 *	Type          : Helper class
 *  Function      : Provides assorted functions for input text
 *  Developer     : Gabriel Carrillo
 *  Company       : Kamazooie Development Corporation
 *  Version       : 1.4
 *---------------------------------------------------------------------------------*/

namespace App\Helpers;


use Illuminate\Http\Request;


class FunctionHelper
{

    public function ISOToInternational($ISODate)
    {   
       // convert date from yyyymmdd to dd/mm/yyyy

        $newDate = "";
        $sDay = SUBSTR($ISODate,8,2);
        $sMonth = SUBSTR($ISODate,5,2); 
        $sYear = SUBSTR($ISODate,0,4);
        $newDate = $sDay."/".$sMonth."/".$sYear;
        return $newDate;
    }


    public function ISOToInternational($ISODate)
    {   
       // convert date from yyyymmdd to dd/mm/yyyy

        $newDate = "";
        $sDay = SUBSTR($ISODate,8,2);
        $sMonth = SUBSTR($ISODate,5,2); 
        $sYear = SUBSTR($ISODate,0,4);
        $newDate = $sDay."/".$sMonth."/".$sYear;
        return $newDate;
    }

    public function ISOToEnglish($ISODate)
    {   
       // convert date from yyyymmdd to mm/dd/yyyy

        $newDate = "";
        $sDay = SUBSTR($ISODate,8,2);
        $sMonth = SUBSTR($ISODate,5,2); 
        $sYear = SUBSTR($ISODate,0,4);
        $newDate = $sMonth."/".$sDay."/".$sYear;
        return $newDate;
    }    

    ///-----------------------------------------------
    function create_MYSQL_date($dd,$mm,$yy){
      if (strlen($mm) <2) {
        $mm = "0".$mm;
      }
      if (strlen($dd) <2) {
        $dd = "0".$dd;
      }

      $MYSQLdate = $yy."/".$mm."/".$dd;
      return $MYSQLdate;
    }       
    ///----------------------------------------------- 
    public function get_current_date(){
        //return $this->current_date['d-m-Y'];
        return date('d-m-Y');
    }

    ///-----------------------------------------------
    public function get_current_day( $string = false ){
        if( $string ) return $this->current_date['weekday'];
        return $this->current_date['mday'];
    } 

    ///-----------------------------------------------
    public function get_current_month( $string = false ){
        if( $string ) return $this->current_date['month'];
        return $this->current_date['mon'];
    } 

    ///-----------------------------------------------
    public function get_current_year( $short = false ){
        if( $short ) return substr ( $this->current_date['year'], 2, 3 );
        return $this->current_date['year'];
    } 


	//------ make string with left * padding ----------------
    //   default string length = 10
    //   str_pad  = "*****99999"
	function makePadString($integer1, $stringLength = 10, $strPad = "*")
     { 
        if ($integer1 < 1) {
           $integer1 = "";	
		}
        return str_pad($integer1, $stringLength, $strPad, STR_PAD_LEFT);
     }	 
 
	 
}