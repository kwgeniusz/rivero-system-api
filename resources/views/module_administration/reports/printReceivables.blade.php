
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
        <th style="background-color:#efcb44;font-size:18px;color:white" colspan="3" align="center"><b>ACCOUNTS RECEIVABLE</b></th>
       </tr>

        <tr> 
         <th width="20%" align="left"> 
          <br><br>
          <img src="img/logo_jd.jpg" alt="test alt attribute" width="140px" height="120px"/>
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

</table>
<br>
 <table stype="border-collapse: collapse;" cellspacing="0" cellpadding="1px" border="0">
        <thead>
        <tr style="background-color:#f2edd1; color:black; font-size:14px;" id="bold" align="center">
          <th>#</th>
          <th >CLIENT COD.</th>
          <th >CUSTOMER NAME</th>
          <th >DATE</th>
          <th >INVOICE</th>
          {{-- <th >ADDRESS</th> --}}

          <th >TOTAL</th>
          <th >PAID</th>
          <th >BALANCE</th>
        </tr>
        </thead>
@php
       $acum = 0 ;
       $acumBalance= 0;
 //// inicio del ciclo de impresion
foreach ($invoices as $invoice) {
               $paid = 0;
               $acum = $acum + 1;
                if ($acum % 2 != 0) {
                    $background = "#fbfbfb";
                } else {
                    $background = "#f2edd1";
                }
                   // monto pagado de cada factura
                      $paid = $invoice->netTotal - $invoice->balance;
                      $paid = number_format((float)$paid, 2, '.', '');
                   // acumulacion de balance
                     $acumBalance += $invoice->balance;
                    $acumBalance = number_format((float)$acumBalance, 2, '.', '');



@endphp
        <tr style="background-color:{{$background}}">
         <td align="center">{{$acum}}</td>
         <td align="center">{{$invoice->client->clientCode}}</td>
         <td align="left">{{$invoice->client->clientName}}</td>
         <td align="center">{{$invoice->invoiceDate}}</td>
         <td align="center">{{$invoice->invId}}</td>
         {{-- <td align="left">{{$invoice->client->clientAddress}}</td> --}}
         <td align="right">{{-- {{$symbol}} --}}{{$invoice->netTotal}}</td>
         <td align="right">{{-- {{$symbol}} --}}{{$paid}} </td>
         <td align="right">{{-- {{$symbol}} --}}{{$acumBalance}}</td>
        </tr>
@php
}// FIN DE FOREACH DE RENGLONES

   // imprimir footer de factura
@endphp
 </table>
 {{-- <table cellspacing="0" cellpadding="2px" border="0"  >
       <tr>
        <th style="background-color:#f4f4f5;" colspan="1" align="center"><b>Terms & Conditions</b></th>
       </tr>

       <tr> 
        <th>
              <b>T&C:</b>
                  <ul>
@foreach($invoice['0']->note as $note){ 
    <li>$note->noteName</li>
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
