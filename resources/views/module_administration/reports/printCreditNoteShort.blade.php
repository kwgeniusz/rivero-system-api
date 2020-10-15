
<<html>
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
            font-size:14px
        }

        table{
            width:100%;
            /*border:1px solid black;*/
        }
        .table-center{
           table-layout: fixed;
           border: 1px solid black;
           width: 60%;
           margin:0 auto;
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


<table cellspacing="0" cellpadding="1px" border="0">
    <tr >
     <th style="background-color:#efcb44;font-size:18px;color:white" colspan="3" align="center"><b>CREDIT NOTE</b></th>
   </tr>
        <tr> 
         <th width="20%" align="left"> 
          <br><br>
          <img src="img/logo_jd.jpg" alt="test alt attribute" width="140px" height="120px"/>
         </th>

        <th width="57%">
             <div style="text-align:center">
               <strong style="font-size:20px" sty>{{$company[0]->companyName}}</strong><br>
               <img src="img/icon-point.png" width="10px" height="10px"/> {{$company[0]->companyAddress}}<br>
               <img src="img/icon-phone.png" width="10px" height="10px"/> {{$company[0]->companyPhone}},{{$company[0]->companyPhoneOptional}}<br>
               <img src="img/icon-email.png" width="10px" height="10px"/> {{$company[0]->companyEmail}}
               <img src="img/icon-location.png" width="10px" height="10px"/> {{$company[0]->companyWebsite}}
             </div>
        </th>

      <th width="23%" align="center">
        <table>       
          <tr>
              <td id="bold">ID:</td>
              <td align="right">{{$creditNote[0]->salId}}</td>
            </tr>
            <tr>
              <td id="bold">Date:</td>
              <td align="right">{{$creditNote[0]->dateNote}}</td>
            </tr>
            <tr>
           {{--    <td id="bold">Page: {{$page}}/{{$pageTotal}}</td>
              <td align="left"></td> --}}
            </tr>
            <tr>
              <td> </td>
              <td> </td>
            </tr>
           {{--  <tr>
              <td id="bold">Seller ID:</td>
              <td align="right">{{$invoice[0]->user->fullName}}</td>
            </tr> --}}
         </table>     
      </th>

    </tr>
</table>

<br>
  <table cellspacing="0" cellpadding="1px" border="0">
       <tr>
        <th colspan="3" style="background-color:#f2edd1;font-size:14px;text-align: center"><span id="bold">CUSTOMER INFORMATION:</span></th>
       </tr>
       <tr> 
            <th colspan="1">
               <span id="bold">ID:</span> {{$client->clientCode}}
            </th>
            <th colspan="1">
              <span id="bold">Name:</span> {{$client->clientName}}
            </th>
             <th colspan="1">
              <span id="bold">Phone:</span> {{$client->clientPhone}}
            </th>
       </tr>
      <tr> 
            <th colspan="2">
              <span id="bold">Billing Address:</span> {{$client->clientAddress}}
            </th>
             <th colspan="1">
               <span id="bold">E-mail:</span> {{$client->clientEmail}}
            </th>
       </tr>
</table>

<div>  
HEMOS ACREDITADO A SU APRECIABLE CUENTA LA CANTIDAD DE $2000 POR CONCEPTO DE DESCUENTO APLICADA A FACTURA N° 
</div>

<table cellspacing="0" cellpadding="0" >
       <tr>
        <th colspan="2" style="background-color:#f2edd1;" align="center">
        </th>
       </tr>
       <tr> 
       {{--  <th width="20%" align="center">
          <img src="img/codeqr.png" alt="test alt attribute" width="100px" height="100px"/>
        </th> --}}
        <th width="60%">
             <b>Payment break down:</b><br>
 
   {{-- $amountRs =  $creditNote[0]->netTotal-$acumPaid; --}}
   @php
   $amountRs =  $creditNote[0]->netTotal;
   $amountRs =  number_format((float)$amountRs, 2, '.', '');
@endphp
        </th>
        <th width="40%">
             <table cellspacing="0" cellpadding="0" >
               <tr>
                <th><b>Subtotal</b></th><th style="border-top:1px solid black;"  align="right"> {{$symbol}}{{$creditNote[0]->grossTotal}}</th>
               </tr>
            {{--    <tr>
                <th><b>Tax Rate</b></th><th align="right">{{$creditNote[0]->taxPercent}}%</th>
               </tr>
               <tr>
                <th><b>Tax</b></th><th align="right"> {{$symbol}}{{$creditNote[0]->taxAmount}}</th>
               </tr> --}}
                <tr>
                <th><b>Total</b></th><th align="right"> {{$symbol}}{{$creditNote[0]->netTotal}}</th>
               </tr>
         {{--        <tr>
                <th><b>Amount PAID</b></th><th align="right" style="color:red"> {{$symbol}} {{$acumPaid}} </th>
               </tr>
 --}}                <tr>
                <th><b>Balance Due</b></th><th align="right"> {{$symbol}} {{$amountRs}} </th>
               </tr>
             </table>
        </th>
       </tr>
</table>
{{-- 
<br>
 <div align="center">
 <b>Reference:</b> <br>
   Project for a {{$creditNote->projectDescription->projectDescriptionName}} at {{$invoice->contract->siteAddress}}
</div>

<br>
 <div align="center" >
 <b>Invoice Number:</b> {{$invoice->invId}}<br>
          <b>Invoice Date:</b> {{$invoice->invoiceDate}}<br>
          <b>Invoice Amount:</b> {{$symbol}}{{$invoice->netTotal}}<br>
</div>


 <br>
  <table cellspacing="0" cellpadding="6px" border="1" class="table-center" >
     <tr style="text-align: center; font-weight:bold; background:#f2edd1;color:black"> 
            <th>
               <strong>
                 Quantity
               </strong>
            </th>
            <th>
                <strong>
                 Description
               </strong>
            </th>
             <th>
                <strong>
                 Amount
               </strong> 
            </th>
       </tr>

        <tr> 
            <th style="text-align: center">
                1
            </th>
            <th>
                PAYMENT 
            </th>
            <th style="text-align: center">
                {{$symbol}}{{$receivable[0]->amountDue}}
            </th>  
       </tr>

      <tr> 
            <th>
               
            </th>
            <th style="text-align: right;font-weight:bold">
                Total Due 
            </th>
            <th style="text-align: center;" >
                {{$symbol}}{{$receivable[0]->amountDue}}
            </th>  
       </tr>
  </table>

<br>
<div style="text-align: center">
<b>Invoice Balance:</b> {{$symbol}}{{$invoice->balanceTotal}}<br>
<b>Balance due after this payment:</b> {{$symbol}}{{ $invoice->balanceTotal - $receivable[0]->amountDue}}
</div>

<br><br>
<div style="text-align: center">
<b>Remit payment to:</b><br>
       Name: JD Rivero Dallas LLC <br>
           Bank: Bank of America <br>
           Account number: 4880 9011 7716 <br>
           Routing number: 111000025<br>
           026009593 (WIRES)<br>
           E-mail: jdriverodallas@gmail.com (ZELLE)
</div>

<br> <br><br>
<div align="center">
<b>NOTE:</b> If the payment is by Check, Cash or Money Order, leave it at the office or give it to one of our employees at the project address.
</div> --}}

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
