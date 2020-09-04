
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
            font-size:14px
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


<table cellspacing="0" cellpadding="1px" border="0">
       <tr >
        <th style="background-color:#efcb44;font-size:18px;color:white" colspan="3" align="center"><b>PAYMENT RECEIPT</b></th>
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

        <img src="img/codeqr.png" alt="test alt attribute" width="100px" height="100px"/>
      </th>

    </tr>
</table>

<br><br>
 <table cellspacing="0" cellpadding="6px" border="0" style="background-color:#f4f4f5;border-radius:4px">
       <tr>
        <th><b>Dear</b> {{$receivables[0]->client->clientName}}</th>
       </tr>
       <tr> 
        <th><b>We have received your payment , you can find the receipt below.</b></th>
       </tr>
</table>
@php
    foreach ($receivables as $receivable) {
@endphp
<br>
 <div align="center" style="font-size:15px"><b>Payment information</b></div>
 <br>

<table>
<tr>
<td style="width:20%"></td>
<td style="width:60%">
  <table cellspacing="0" cellpadding="6px" border="0" style=" border: 1px solid black;">
  <tr style="background-color:#f4f4f5;"> 
            <th>
               Payment date:
            </th>
            <th>
              {{$receivable->datePaid}}
            </th>
       </tr>

        <tr style="background-color:#f4f4f5;"> 
            <th>
               Amount paid:
            </th>
            <th>
                {{$symbol}}{{$receivable->amountPaid}}
            </th>
       </tr>

        <tr style="background-color:#f4f4f5;"> 
            <th>
             Method:
            </th>
            <th>
               {{$receivable->paymentMethod->payMethodName}}
            </th>
       </tr>
      
  </table> 
</td>
<td style="width:20%"></td>

</tr>
</table>

<br><br>
 <div align="center" style="font-size:15px"><b>Payment details</b></div>
 <br>

<table>
<tr>
<td style="width:20%"></td>
<td style="width:60%">
  <table  cellspacing="0" cellpadding="6px" border="0" style=" border: 1px solid black;">
      <tr style="background-color:#f4f4f5;"> 
            <th>
               Control Number:
            </th>
            <th>
              {{$receivable->invoice->contract->contractNumber}}
            </th>
       </tr>
        <tr style="background-color:#f4f4f5;"> 
            <th>
               Transaction ID:
            </th>
            <th>
              INVOICE #{{$receivable->invoice->invId}}
            </th>
       </tr>

        <tr style="background-color:#f4f4f5;"> 
            <th>
              Balance Due:
            </th>
            <th>
               {{$symbol}}  {{$receivable->balance}}    
            </th>
       </tr>

         <tr style="background-color:#f4f4f5;"> 
            <th>
               Customer ID:
            </th>
            <th>
               {{$receivable->client->clientCode}}
            </th>
       </tr>

          <tr style="background-color:#f4f4f5;"> 
            <th>
               Status:
            </th>
            <th>
               {{$receivable->receivableStatus[0]->recStatusName}}
            </th>
       </tr> 
  </table> 
</td>
<td style="width:20%"></td>

</tr>
</table>

<br>
<div align="center" style="font-size:15px"><b>Overpayment of <u> {{$symbol}}{{$receivable->amountPaid}}</u> converted to credit</b></div>
@php
    }
@endphp
 <br><br>    
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
