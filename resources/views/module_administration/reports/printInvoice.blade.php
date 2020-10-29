
<html>
<head>
    <style>

        @page {
            margin: 0cm 0cm;
            font-family: helvetica;
            font-weight: normal; !important
        }
        body {
            margin: 1cm 1cm 2cm 1cm;
            font-size:13px
        }

        .pagenum:before {
        content: counter(page);
        }

        .pagination {
         position: absolute;
         color: black;
         bottom: 15px;
         left: 680px;
        }

        .page-break {
          page-break-after: always;
         }

        #watermark {
                position: fixed;

                /** 
                    Set a position in the page for your image
                    This should center it vertically
                **/
                bottom:   16cm;
                left:     6.5cm;

                /** Change image dimensions**/
                width:    8cm;
                height:   5cm;

                /** Your watermark should be behind every content**/
                z-index:  1000;
                /*z-index:  -1000;*/
            }
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #2a0927;
            color: white;
            text-align: center;
            line-height: 30px;
        }
        footer {
            position: fixed;
            bottom: 50px;
            left: 0cm;
            right: 0cm;
            height: 0cm;
            /*background-color: #2a0927;*/
            color: black;
            text-align: center;
            line-height: 20px;
        }

        table{
            width:100%;
            /*border:1px solid black;*/
        }

        td,tr,th{
            font-weight:normal;
        }
        tr.outer {
            color: red;
            text-decoration: line-through;
        }

        #bold {
          font-weight: bold;
        }


    </style>
</head>
<body>


{{-- 
<header>
    <h1>Styde.net</h1>
</header>
 
<main>
    <h1>{{__('add')}}</h1>
</main> --}}
 
{{-- <footer>
    <h4> © Copyright 2020 JD Rivero Global - All rights reserved <br>
     Designed By Rivero Visual Group</h4>
</footer> --}}
{{-- <div class="page-break"></div> --}}
@if($invoice[0]->invStatusCode == App\Invoice::PAID)
  <div id="watermark">
            <img src="img/paid2.png" height="100%" width="100%" />
   </div>
@endif
@php
 // preparar variables  
  $line = 100;  
  $page = 1;              // paigina 1/1;   pagina 1/2  pagina 2/2
  $linesperpage = 30;    // numero maximo de renglones
  //calcular total de paginas
  $quantityInvDetails = count($invoiceDetails);
  $pageTotal = (intval($quantityInvDetails/$linesperpage));
  $pageTotal++;
   //si los registro y el limite de lineas son iguales es una pagina
   if($quantityInvDetails == $linesperpage){
    $pageTotal = 1;
   }

           $acum          = 0;
           $acum2         = 0;
           $acumInvDetail = 0;
           $subTotalPerPage= 0;
           $vienen = 0;
           $moneySymbol = '';

 //// inicio del ciclo de impresion
foreach ($invoiceDetails as $invDetail) {

  //if de header
    if ($line > $linesperpage) { //imprimir
            if($page > 1) {
//FOOTER
@endphp
<tr>
 <th colspan="4" align="right">
   
 </th>
  <th colspan="1" align="right">
   Sub-Total:
 </th>
 <th style="border-top:2px solid black" colspan="1" align="right">
   {{$invoice[0]->contract->currency->currencySymbol}} {{$subTotalPerPage}}
 </th>
</tr>
</table>

     <div class="page-break"></div>
@php
    }//endif - si la pagina es mayor que uno (1)
@endphp
 {{-- // imprimir encabezado de factura --}}
 <table cellspacing="0" cellpadding="1px" >
       <tr>
        <th id="bold" style="background-color:#e5db99; font-size:18px;" colspan="3" align="center">ELECTRONIC INVOICE {{$status}}</th>
       </tr>
 
       <tr> 
         <th width="20%" align="center"> 
          <img src="img/logo_jd.jpg" alt="test alt attribute" width="140px" height="120px"/>
         </th>
        <th width="48%">
             <div style="text-align:center">
               <strong style=" font-size:22px;"  >{{$company[0]->companyName}}</strong><br>
               <img src="img/icon-point.png" width="10px" height="10px"/> {{$company[0]->companyAddress}}<br>
               <img src="img/icon-phone.png" width="10px" height="10px"/> {{$company[0]->companyPhone}},{{$company[0]->companyPhoneOptional}}<br>
               <img src="img/icon-email.png" width="10px" height="10px"/> {{$company[0]->companyEmail}}
               <img src="img/icon-location.png" width="10px" height="10px"/> {{$company[0]->companyWebsite}}
             </div>
        </th>
    <th width="20%">
        <table>       
          <tr>
              <td colspan="2" id="bold">Invoice Number:</td>
              <td align="right">{{$invoice[0]->invId}}</td>
            </tr>
            <tr>
              <td colspan="2" id="bold">Invoice Date:</td>
              <td align="right">{{$invoice[0]->invoiceDate}}</td>
            </tr>
            <tr>
              <td colspan="2" id="bold">Page:</td>
              <td align="right">{{$page}}/{{$pageTotal}}</td>
            </tr>
            <tr>
              <td> </td>
              <td> </td>
            </tr>
            <tr>
              <td colspan="2" id="bold">Seller ID:</td>
              <td align="right">{{$invoice[0]->user->fullName}}</td>
            </tr>
         </table>     
        </th>
       
    </tr>
</table>
    <br>   

  <table cellspacing="0" cellpadding="1px" border="0">
       <tr>
        <th colspan="3" style="background-color:#f2edd1;font-size:17px;" align="center"><span id="bold">CUSTOMER INFORMATION</span></th>
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


 <table cellspacing="0" cellpadding="1px">    
      <tr>
        <th id="bold" colspan="3" style="background-color:#f2edd1;font-size:17px;" align="center">PROJECT INFORMATION</th>
       </tr>
        <tr> 
            <th width="45%" >
             <span id="bold">Control Number:</span> {{$invoice[0]->contract->contractNumber}}
            </th>
            <th width="55%" colspan="2">
             <span id="bold">Address:</span> {{$invoice[0]->contract->siteAddress}}
            </th>
            <th> </th>
       </tr>
      <tr> 
            <th width="15%">
             <span id="bold"> Type:</span> {{$invoice[0]->contract->projectUse->projectUseName}} 
            </th>
            <th width="35%">
             <span id="bold"> Description:</span> {{$invoice[0]->projectDescription->projectDescriptionName}}
            </th>
           <th width="60%"> 
             <span id="bold">Project Name:</span> {{$invoice[0]->contract->projectName}}
           </th>
       </tr>
</table>   
       <br>

 <table stype="border-collapse: collapse;" cellspacing="0" cellpadding="1px">       
     <thead>
        <tr id="bold" style="background-color:#f2edd1; font-size:17px;" align="center">
          <th width="5%" align="center">#</th>
          <th align="center" width="40%">DESCRIPTION</th>
          <th width="10%" align="center">UNIT</th>
          <th width="15%" >QTY</th>
          <th width="15%" align="center">UP</th>
          <th width="15%" align="center">AMOUNT</th>
        </tr>
        </thead>
@php 
       $page++;
       $acum= 0 ;
       $subTotalPerPage= 0;
       $line= 1;// al pasar la pagina reinicia la linea

} //fin de condicion de header

               
               $acum = $acum + 1;
                if ($acum % 2 == 0) {
                    $background = "#f2edd1";
                } else {
                    $background = "#fbfbfb";
                }
     //espacios,numeracion,precios, negritas para reglon con precios
               if ($invDetail->unit == null) {
                    $acum2 = "";
                    $space = "   ";
                    $moneySymbol = '';
                } else {
                    $acumInvDetail = $acumInvDetail + 1;
                    $acum2=$acumInvDetail;
                    $space = "";
                    $moneySymbol = $invoice[0]->contract->currency->currencySymbol;
                }
     if($page > 2 && $line == 1) {  //si es la segunda pagina en la primera linea imprime el viene  
@endphp
        <tr style="background-color:;">
        <td width="5%" align="center"></td>
        <td width="40%" >CONTINUED</td>
        <td width="10%" align="center"></td>
        <td width="15%" align="center"></td>
        <td width="15%" align="center"></td>
        <td width="15%" align="right"> {{$invoice[0]->contract->currency->currencySymbol}} {{$vienen}}</td>
        </tr>
@php
        if($vienen > 0){ //si viene es mayor que cero sumalo al subtotal de pagina 
            $subTotalPerPage += $vienen;
         }
    }
@endphp
        <tr style="background-color:{{$background}};">
        <td width="5%" align="center">{{$acum2}}</td>
        <td width="40%" >{{$space}} {{$invDetail->serviceName}}</td>
        <td width="10%" align="center">{{$invDetail->unit}}</td>
        <td width="15%" align="center">{{$invDetail->quantity}}</td>
        <td width="15%" align="center">{{$moneySymbol}}  {{$invDetail->unitCost}}</td>
        <td width="15%" align="right">{{$moneySymbol}}  {{$invDetail->amount}}</td>
        </tr>
@php
       $subTotalPerPage += $invDetail->amount;//acumulacion de subtotal de pagina
       $subTotalPerPage = number_format((float)$subTotalPerPage, 2, '.', '');
       $vienen =  number_format((float)$subTotalPerPage, 2, '.', '');

    $line++;
}// FIN DE FOREACH DE RENGLONES
@endphp
   {{-- // imprimir footer de factura --}}
</table>
       <br><br>


<table cellspacing="0" cellpadding="0" >
       <tr>
        <th colspan="3" style="background-color:#f2edd1;" align="center">
        </th>
       </tr>
       <tr> 
        <th width="20%" align="center">
          <img src="img/codeqr.png" alt="test alt attribute" width="100px" height="100px"/>
        </th>
        <th width="50%">
             <b>Payment break down:</b><br>
 @php            
      $acum3        = 0;
      $acumPaid     = 0;
    foreach ($payments as $payment) {
     $acumPaid += $payment->receivable->amountPaid;
     $acumPaid =  number_format((float)$acumPaid, 2, '.', '');

        if($payment->receivable->paymentMethod == null){ 
           $paymentMethod  = null;
        }else{
           $paymentMethod  =$payment->receivable->paymentMethod->payMethodName;
        }

      if($payment->receivable->recStatusCode != 4){ 
           $recStatusName  = null;
        }else{
           $recStatusName  = $payment->receivable->receivableStatus[0]->recStatusName;
        }
@endphp

      <table cellspacing="0" cellpadding="0" >
                <tr @if($payment->receivable->receivableStatus[0]->recStatusCode == App\Receivable::ANNULLED)
                  class="outer" 
                  @endif>
                 <td width="10%">{{++$acum3}}</td>
                 <td width="35%">{{$moneySymbol}} {{$payment->receivable->amountDue}}</td>
                 <td width="35%">{{$paymentMethod}}</td>
                 <td width="20%">{{$recStatusName}}</td>
                 <td width="30%">{{$payment->receivable->datePaid}}</td>
                 <td width="15%"></td>
                </tr>
              </table>
@php
  }
   $amountRs =  $invoice[0]->netTotal-$acumPaid;
   $amountRs =  number_format((float)$amountRs, 2, '.', '');
@endphp
        </th>
        <th width="30%">
             <table cellspacing="0" cellpadding="0" >
               <tr>
                <th><b>Subtotal</b></th><th style="border-top:1px solid black;"  align="right"> {{$symbol}}{{$invoice[0]->grossTotal}}</th>
               </tr>
               <tr>
                <th><b>Tax Rate</b></th><th align="right">{{$invoice[0]->taxPercent}}%</th>
               </tr>
               <tr>
                <th><b>Tax</b></th><th align="right"> {{$symbol}}{{$invoice[0]->taxAmount}}</th>
               </tr>
                <tr>
                <th><b>Total</b></th><th align="right"> {{$symbol}}{{$invoice[0]->netTotal}}</th>
               </tr>
                <tr>
                <th><b>Amount PAID</b></th><th align="right" style="color:red"> {{$symbol}} {{$acumPaid}} </th>
               </tr>
                <tr>
                <th><b>Balance Due</b></th><th align="right"> {{$symbol}} {{$amountRs}} </th>
               </tr>
             </table>
        </th>
       </tr>
</table>

<br>

@if($invoice[0]->creditNote->isNotEmpty())
 <p style="color:red"> Note: this invoice has been affected by a credit note:
  @foreach($invoice[0]->creditNote as $creditNote)
   ID {{$creditNote['salId']}} 
  @endforeach
 </p> 
 @endif

@if($invoice[0]->debitNote->isNotEmpty())
 <p style="color:red">Note: this invoice has been affected by a debit note:
  @foreach($invoice[0]->debitNote as $debitNote)
   ID {{$debitNote['salId']}} 
  @endforeach
 </p> 
 @endif

 {{-- 

 <table cellspacing="0" cellpadding="0" >
       <tr>
        <th style="background-color:#f2edd1; font-size:17px;" colspan="1" align="center"><b>Terms & Conditions</b></th>
       </tr>
       <tr> 
                  <ul>
@foreach($invoice['0']->note as $note)
    <li>{!! nl2br($note->noteName) !!}</li>
@endforeach
                  </ul>
       </tr>
</table>



 <table cellspacing="0" cellpadding="0" >
       <tr>
        <th style="background-color:#f2edd1; font-size:17px;" colspan="1" align="center"><b>Scope of Work</b></th>
       </tr>
       <tr> 

                  <ul>
@foreach($invoice['0']->scope as $scope)
    <li>{!! nl2br($scope->description) !!}</li>
@endforeach

                  </ul>
       </tr>
</table>
 --}} 

<footer>
© Copyright 2020 JD Rivero Global - All rights reserved <br>
    Designed By Rivero Visual Group
        <div class="pagination">
				<p>Page <span class="pagenum"></span></p>
				</div>
</footer>

</div>
</body>
</html>
