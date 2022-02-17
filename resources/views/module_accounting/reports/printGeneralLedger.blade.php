
<html>
<head>
    <style>

        @page {
            margin: 0cm 0cm;
            font-family: helvetica;
            font-weight: normal; !important
        }
        .page-break {
          page-break-after: always;
         }
        body {
            margin: 1cm 1cm 2cm 1cm;
            font-size:11px
        }

        table{
            width:100%;
            /*border:1px solid black;*/
        }

        td,tr,th{
            font-weight:normal;
        }

        #bold {
          font-weight: bold;
        }

    </style>
</head>
<body>


<table cellspacing="0" cellpadding="1px" border="">
       <tr >
        <th style="background-color:#efcb44;font-size:18px;color:white" colspan="3" align="center"><b>GENERAL LEDGER</b></th>
       </tr>

        <tr> 
         <th width="20%" align="left"> 
          <br>
          <img src="img/logos/jd/logo_jd.png" alt="test alt attribute" width="140px" height="120px"/>
         </th>

        <th width="55%">
             <div style="text-align:center; font-size:14px;">
               <strong style="font-size:20px">{{$company->companyName}}</strong><br>
               <img src="img/icon-point.png" width="10px" height="10px"/> {{$company->companyAddress}}<br>
               <img src="img/icon-phone.png" width="10px" height="10px"/> {{$company->companyPhone}},{{$company->companyPhoneOptional}}<br>
               <img src="img/icon-email.png" width="10px" height="10px"/> {{$company->companyEmail}}
               <img src="img/icon-location.png" width="10px" height="10px"/> {{$company->companyWebsite}}
             </div>
        </th>

      <th width="20%" align="center">
         <table border="0">
            <tr style="font-size:12px">
              <td><b>Report Date:</b></td>
              <td align="left">{{$date->format('F jS, Y')}}</td>
            </tr>
            <tr style="font-size:12px">
              <td><b>Currency:</b></td>
              <td align="left">{{$currency->currencyName}}</td>
            </tr>
         </table>     
      </th>

    </tr>
  <div  align="center" >
     <h2>As of {{$lastDayOfTheMonth->format('F jS, Y') }}</h2>
  </div>


</table>
 <table stype="border-collapse: collapse;" cellspacing="0" cellpadding="1px" border="0">
     <thead>
    <tr style="background-color:#f2edd1; color:black; font-size:10px;" id="bold" align="center">
        <!-- <th>#</th> -->
        <th>CUENTA</th>
        <th>NOMBRE DE LA CUENTA</th>
        <th>DEBE</th>
        <th>HABER</th>
        <th>SALDO</th>
    </tr>
     </thead>
@php
// Inicio del ciclo de impresion
  $background= '';
  $acum =0;
    foreach ($generalLedgers as $generalLedger) {
            $acum = $acum + 1;
            if($acum % 2 != 0) { $background = "#fbfbfb";} else { $background = "#f2edd1";}
@endphp
<tr style="background-color:{{$background}};  font-size:8px;" >
         <td align="left"> {{$generalLedger['accountCode'] }} </td>
         <td align="left"> {{$generalLedger['accountName'] }}</td>
         <td align="right">{{number_format($generalLedger['debitTotal'], 2, '.', ',') }}</td>
         <td align="right">{{number_format($generalLedger['creditTotal'], 2, '.', ',') }}</td>
         <td align="right">{{number_format($generalLedger['difference'], 2, '.', ',') }}</td>
 </tr>
@php
   } // Fin de Foreach de headers
@endphp

 </table>
 

<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Helvetica", "italic");
            $pdf->text(210, 805, "© Copyright 2020 JD Rivero Global - All rights reserved", $font, 8);
            $pdf->text(250, 816, "Designed By Rivero Visual Group", $font, 8);
            $pdf->text(530, 816, "Page $PAGE_NUM/$PAGE_COUNT", $font, 8);
        ');
    }
</script>
</body>
</html>
