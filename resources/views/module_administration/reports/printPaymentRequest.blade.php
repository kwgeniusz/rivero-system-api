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
        <th style="background-color:#efcb44;font-size:18px;color:white" colspan="3" align="center"><b>PAYMENT REQUEST</b></th>
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

<br>
 <table cellspacing="0" cellpadding="6px" border="0" style="background-color:#f4f4f5;border-radius:4px">
       <tr>
        <th>
          <b>Billed to:</b> <br>
           {{$receivable[0]->client->clientCode}}<br>
           {{$receivable[0]->client->clientName}}<br>
           {{$receivable[0]->client->clientAddress}}
        </th>

        <th>
          <b>Invoice Date:</b> {{$invoice->invoiceDate}}<br><br>
          <b>Invoice Number:</b> {{$invoice->invId}}
        </th>
       </tr>

</table>

<br>
 <div align="center" style="font-size:14px;">Reference: Project for a {{$invoice->projectDescription->projectDescriptionName}} at {{$invoice->contract->siteAddress}}</div>: 
 <br>

  <table cellspacing="0" cellpadding="6px" border="1" class="table-center" style="font-size:15px;background-color:#f4f4f5;">
     <tr style="text-align: center; font-weight:bold"> 
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

Invoice Amount: {{$symbol}}{{$invoice->netTotal}}<br><br>
Balance due after this payment: {{$symbol}}{{ $receivable[0]->amountDue-$invoice->netTotal}}<br><br>
Remit payment to:
       Name: JD Rivero Dallas LLC <br>
           Bank: Bank of America <br>
           Account number: 4880 9011 7716 <br>
           Routing number: 111000025<br>
           026009593 (wires)
<br>
{{-- 
 <table cellspacing="0" cellpadding="6px" border="1" style="background-color:#f4f4f5;border-radius:4px;text-align: center">
       <tr>
         <th colspan="2"> Remit payment to: </th>
       </tr>
       <tr>
         <th> CHECK or MONEY ORDER: </th>
         <th> Name: JD Rivero Dallas LLC  </th>
       </tr>
      <tr>
         <th>  ZELLE TRANSFER: </th>
         <th>           Name: JD Rivero Dallas LLC<br>
            E-mail: jdriverodallas@gmail.com </th>
       </tr>

       <tr>
         <th>WIRE TRANSFER or TRANSFER: </th>
         <th> 
          Name: JD Rivero Dallas LLC <br>
           Bank: Bank of America <br>
           Account number: 4880 9011 7716 <br>
           Routing number: 111000025<br>
           026009593 (wires) 
         </th>
       </tr>
     </tr> --}}
</table>


<br>
<div align="center" style="font-size:13px"><b>
CASH 
NOTE: If the payment is by Check, Cash or Money Order, leave it at the office or give it to one of our employees at the project address.
</b></div>

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
