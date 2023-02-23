
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
        <th style="background-color:#efcb44;font-size:18px;color:white" colspan="3" align="center"><b>EXPENSES TRANSACTIONS</b></th>
       </tr>

        <tr> 
         <th width="20%" align="left"> 
          <br>
          <img src="img/logos/jd/logo_jd.png" alt="test alt attribute" width="140px" height="120px"/>
         </th>

        <th width="55%">
             <div style="text-align:center; font-size:14px;">
               <strong style="font-size:20px" sty>{{$company[0]->companyName}}</strong><br>
               <img src="img/icon-point.png" width="10px" height="10px"/> {{$company[0]->companyAddress}}<br>
               <img src="img/icon-phone.png" width="10px" height="10px"/> {{$company[0]->companyPhone}},{{$company[0]->companyPhoneOptional}}<br>
               <img src="img/icon-email.png" width="10px" height="10px"/> {{$company[0]->companyEmail}}
               <img src="img/icon-location.png" width="10px" height="10px"/> {{$company[0]->companyWebsite}}
             </div>
        </th>

      <th width="25%" align="center">
         <table border="0">
            <tr style="font-size:12px">
              <td><b>Report Date:</b></td>
              <td align="left">{{$date->format('m/d/Y')}}</td>
            </tr>
         </table>     
      </th>

    </tr>
@if($dateRange['date1'] != '')
  <div  align="center" >
     <h2>From: {{$dateRange['date1']}} - To: {{$dateRange['date2']}}</h2>
  </div>
@elseif($dateRange['year'] != '')
<div align="center" >
     <h2>Year: {{$dateRange['year'] }}</h2>
</div>
@endif
</table>
 <table stype="border-collapse: collapse;" cellspacing="0" cellpadding="1px" border="0">
     <thead>
    <tr style="background-color:#f2edd1; color:black; font-size:10px;" id="bold" align="center">
        <th>#</th>
        <th>FECHA</th>
        <th>REFERENCIA EN BANCO O BENEFICIARIO</th>
        <th>METODO DE PAGO</th>
        <th>MOTIVO</th>
        <th>REFERENCIA DE TRANSACCION</th>
        <th>EXPENSES</th>
        <th>MONTO</th>
        <th>DESTINO</th>
    </tr>
     </thead>
@php

    $acum = 0 ;
    $background = '';
// Inicio del ciclo de impresion
foreach ($transactions as $transaction) {
            $acum = $acum + 1;
            if($acum % 2 != 0) { $background = "#fbfbfb";} else { $background = "#f2edd1";}
@endphp
        <tr style="background-color:{{$background}};  font-size:8px;" >
         <td align="center">{{$acum}}</td>
         <td align="center">{{$transaction['transactionDate'] }}</td>
         <td align="center">{{$transaction['description'] }}</td>
         <td align="center">{{$transaction['payment_method']['payMethodName'] }}</td>
         <td align="center">{{$transaction['reason'] }}</td>
         <td align="center">{{$transaction['reference'] }}</td>
         <td align="center">{{$transaction['transaction_type']['transactionTypeName'] }}</td>
         <td align="center">{{$transaction['amount'] }}</td>
         @if($transaction['cashboxId'] == null)
         <td align="center">{{$transaction['account']['bank']['bankName'] }} <br> {{$transaction['account']['accountCodeId'] }}</td>
         @else
           CASHBOX
         @endif
        </tr>
@php
 } // Fin de Foreach de arreglos
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
