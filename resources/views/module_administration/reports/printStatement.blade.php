
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
            font-size:13px;
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


 {{-- // imprimir encabezado de statement --}}

<table cellspacing="0" cellpadding="1px" border="0"  >
       <tr >
        <th style="background-color:#e5db99;font-size:18px;" colspan="3" align="center"><b>INVOICE STATEMENT</b></th>
       </tr>
 
      <tr> 
         <th width="20%" align="left"> 
          <img src="img/logo_jd.jpg" alt="test alt attribute" width="140px" height="120px"/>
         </th>
        <th width="60%">
             <div style="text-align:center">
               <strong style="font-size:22px" sty>{{$company[0]->companyName}}</strong><br>
               <img src="img/icon-point.png" width="10" height="10"/> {{$company[0]->companyAddress}}<br>
               <img src="img/icon-phone.png" width="10" height="10"/> {{$company[0]->companyPhone}},{{$company[0]->companyPhoneOptional}}<br>
               <img src="img/icon-email.png" width="10" height="10"/> {{$company[0]->companyEmail}}
               <img src="img/icon-location.png" width="10" height="10"/> {{$company[0]->companyWebsite}}
             </div>
        </th>
     <th width="20%">
        <table border="0">
            <tr style="font-size:12px">
              <td><b>Statement Date:</b>{{$date->format('m/d/Y')}}</td>
            </tr>
         </table>     
        </th>
    </tr>
</table>
       <br>

 <table cellspacing="0" cellpadding="1px" border="0">
       <tr>
        <th colspan="3" style="background-color:#f2edd1;font-size:17px;;" align="center"><b>CUSTOMER INFORMATION</b></th>
       </tr>
       <tr> 
            <th colspan="1">
               <b>ID:</b> {{$client[0]->clientCode}}
            </th>
            <th colspan="2">
              <b>Name:</b> {{$client[0]->clientName}}
            </th>
       </tr>

      <tr> 
            <th colspan="3">
              <b>Billing Address:</b> {{$client[0]->clientAddress}}
            </th>
       </tr>

     <tr> 
          <th colspan="2">
               <b>E-mail:</b> {{$client[0]->clientEmail}}
            </th>
            <th colspan="1">
                   <b>Phone:</b> {{$client[0]->clientPhone}}
            </th>
       </tr>
</table>

 <table cellspacing="0" cellpadding="1px" border="0">
       <tr>
        <th colspan="3" style="background-color:#f2edd1;font-size:17px;;" align="center"><b>PROJECT INFORMATION</b></th>
       </tr>
        <tr> 
            <th>
             <b>Control Number:</b> {{$invoice[0]->contract->contractNumber}}
            </th>
            <th colspan="2">
             <b>Address:</b> {{$invoice[0]->contract->siteAddress}}
            </th>
            <th> </th>
       </tr>
      <tr> 
            <th >
              <b>Type:</b> {{$invoice[0]->contract->projectUse->projectUseName}} 
            </th>
            <th colspan="2">
              <b>Description:</b> {{$invoice[0]->projectDescription->projectDescriptionName}}
            </th>
           <th> </th>
       </tr>
</table>   
    <br>

 <table stype="border-collapse: collapse;" cellspacing="0" cellpadding="1px" border="0">
        <thead>
        <tr style="background-color:#f2edd1; color:black; font-size:17px; font-weight: bold;" align="center">
          <th width="20%" align="center">DATE</th>
          <th width="35%" align="center">TRANSACTION</th>
          <th width="22.5%" >AMOUNT</th>
          <th width="22.5%" align="center">BALANCE</th>
        </tr>
        </thead>
    <tr style="background-color:white;">
        <td width="20%" align="center">{{$invoice[0]->invoiceDate}}</td>
        <td width="35%" align="left">ORIGINAL AMOUNT - REF. INV. {{$invoice[0]->invId}}</td>
        <td width="22.5%" align="center">{{$symbol}} 0.00</td>
        <td width="22.5%" align="center">{{$symbol}}{{$invoice[0]->netTotal}}</td>
    </tr>
@php
       $acum = 0 ;
       $statement = $invoice[0]->netTotal;
       $sign = '';
 //// inicio del ciclo de impresion
foreach ($transactions as $transaction) {
               $acum = $acum + 1;
                if ($acum % 2 != 0) {
                    $background = "#f2edd1";
                } else {
                    $background = "#fbfbfb";
                }

                if($transaction->reason == 'credit'){
                    $transaction->reason= 'CREDIT NOTE #'.$transaction->id;
                    $statement = $statement - $transaction->amount;
                    $sign = '(-)';
                }elseif($transaction->reason == 'debit'){
                    $transaction->reason= 'DEBIT NOTE #'.$transaction->id;
                   $statement = $statement + $transaction->amount;  
                    $sign = '(+)';                  
                }else{
                   $statement = $statement - $transaction->amount;
                    $sign = '(-)';                   
                }
                   $statement = number_format((float)$statement, 2, '.', '');       
@endphp
    <tr style="background-color: {{$background}};">
         <td width="20%" align="center">{{$transaction->transactionDate}}</td>
         <td width="35%" align="left"> {{$transaction->reason}}</td>
         <td width="22.5%" align="center">{{$sign}}  {{$symbol}}{{$transaction->amount}}</td>
         <td width="22.5%" align="center">{{$symbol}}{{$statement}}</td>
    </tr>
@php
}// FIN DE FOREACH DE RENGLONES

   // imprimir footer de factura
@endphp
 </table>
  <br><br>
 <table cellspacing="0" cellpadding="1px" border="0">
       <tr style="background-color:#f2edd1;" align="center">
        <th ><b>AMOUNT DUE</b>
        </th>
        <th ><b>1-7 DAYS PAST DUE</b>
        </th>
        <th ><b>8-15 DAYS PAST DUE</b>
        </th>
        <th ><b>OVER 16 DAYS PAST DUE</b>
        </th>
       </tr>
        <tr align="center"> 
            <th >
             {{$symbol}}{{$nextShare}}
            </th>
            <th>
             {{$symbol}}{{$nextShare}}
            </th>   
              <th>
             {{$symbol}}{{$nextShare}}
            </th>  
               <th>
             {{$symbol}}{{$nextShare}}
            </th>     
       </tr>
</table>   
 <br><br>
{{--  <table cellspacing="0" cellpadding="0" border="0"  >
       <tr>
        <th style="background-color:#f2edd1;" colspan="1" align="center"><b>Terms & Conditions</b></th>
       </tr>

       <tr> 
        <th>
              <b>T&C:</b>
                  <ul>
@foreach($invoice['0']->note as $note) 
    <li>{{$note->noteName}}</li>
@endforeach
                  </ul>
        </th>
       </tr>
</table> --}}



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
