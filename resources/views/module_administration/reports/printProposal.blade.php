
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
            font-size:13px
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

@php
  // preparar variables  
  $line = 100;  
  $page = 1;              // paigina 1/1;   pagina 1/2  pagina 2/2
  $linesperpage = 30;    // numero maximo de renglones
  //calcular total de paginas
  $quantityPropDetails = count($proposalsDetails);
  $pageTotal = (intval($quantityPropDetails/$linesperpage));
  $pageTotal++;
   //si los registro y el limite de lineas son iguales es una pagina
   if($quantityPropDetails == $linesperpage){
    $pageTotal = 1;
   }

           $acum          = 0;
           $acum2         = 0;
           $acumPropDetail = 0;
           $subTotalPerPage= 0;
           $vienen = 0;

 //// inicio del ciclo de impresion
foreach ($proposalsDetails as $propDetail) {
//invoiceDetail

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
   {{$moneySymbol}} {{$subTotalPerPage}}
 </th>
</tr>
</table>
     <div class="page-break"></div>

@php
    }//endif - si la pagina es mayor que uno (1)
 // imprimir encabezado de factura 
@endphp

<table cellspacing="0" cellpadding="1px" border="0"  >
       <tr >
        <th style="background-color:#e5db99;font-size:18px;" colspan="3" align="center"><span id="bold">ELECTRONIC PROPOSAL</span></th>
       </tr>

     <tr> 
        <th width="20%" align="center"> 
          <img src="img/logo_jd.jpg" alt="test alt attribute" width="140px" height="120px"/>
         </th>
        <th width="48%">
             <div style="text-align:center">
               <strong style="font-size:22px">{{$company[0]->companyName}}</strong><br>
               <img src="img/icon-point.png" width="10px" height="10px"/> {{$company[0]->companyAddress}}<br>
               <img src="img/icon-phone.png" width="10px" height="10px"/> {{$company[0]->companyPhone}},{{$company[0]->companyPhoneOptional}}<br>
               <img src="img/icon-email.png" width="10px" height="10px"/> {{$company[0]->companyEmail}}
               <img src="img/icon-location.png" width="10px" height="10px"/> {{$company[0]->companyWebsite}}
             </div>
        </th>
    <th width="32%">
      <table border="0">
             <tr>
              <td><span id="bold">Proposal Number:</span></td>
              <td align="right">{{$proposal[0]->propId}}</td>
            </tr>
            <tr>
              <td><span id="bold">Proposal Date:</span></td>
              <td align="right">{{$proposal[0]->proposalDate}}</td>
            </tr>

            <tr>
              <td><span id="bold">Page:</span> {{$page}}/{{$pageTotal}}</td>
              <td align="left"></td>
            </tr>
            <tr>
              <td> </td>
              <td> </td>
            </tr>
            <tr>
              <td><span id="bold">Seller ID:</span></td>
              <td align="right"></td>
            </tr>
        </table>     
        </th>
   </tr>
</table>

@if($page == 1)
<br>
  <table cellspacing="0" cellpadding="0" border="0"  >
       <tr>
        <th align="justify">
        <strong>Dear Mr./Mrs. {{$client->clientName}}:</strong><br>
        We are pleased to submit this proposal to provide professional services associated with this project at the reference, address in DALLAS TX. Based on our perception of the overall project objectives, we propose to perform the following tasks. 
         </th>
       </tr>
</table>
<br>
@endif

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

 <table cellspacing="0" cellpadding="1px" border="0">
       <tr>
        <th colspan="3" style="background-color:#f2edd1;font-size:17px;" align="center"><span id="bold">PROJECT INFORMATION</span>
        </th>
       </tr>
        <tr> 
            <th width="45%">
             <span id="bold">{{$modelTypeView}} ID:</span> {{$modelId}}
            </th>
            <th width="55%" colspan="2">
             <span id="bold">Address:</span> {{$proposal[0]->$modelType->siteAddress}}
            </th>
            <th> </th>
       </tr>
       <tr> 
            <th width="15%">
              <span id="bold">Type:</span> {{$proposal[0]->$modelType->projectUse->projectUseName}} 
            </th>
            <th width="35%">
              <span id="bold">Description:</span> {{$proposal[0]->projectDescription->projectDescriptionName}}
            </th>
           <th width="60%"> 
             <span id="bold">Project Name:</span> {{$proposal[0]->$modelType->projectName}}
           </th>
       </tr>
</table>   
 
 <table stype="border-collapse: collapse;" cellspacing="0" cellpadding="1px" border="0">
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
               if ($propDetail->unit == null) {
                    $acum2 = "";
                    $space = "   ";
                    $symbol = '';
                } else {
                    $acumPropDetail = $acumPropDetail + 1;
                    $acum2=$acumPropDetail;
                    $space = "";
                    $symbol = $moneySymbol;
                }
     if($page > 2 && $line == 1) {  //si es la segunda pagina en la primera linea imprime el viene  
@endphp

        <tr style="background-color:;">
        <td width="5%" align="center"></td>
        <td width="40%" >CONTINUED</td>
        <td width="10%" align="center"></td>
        <td width="15%" align="center"></td>
        <td width="15%" align="center"></td>
        <td width="15%" align="right"> {{$moneySymbol}} {{$vienen}}</td>
        </tr>
@php
        if($vienen > 0){ //si viene es mayor que cero sumalo al subtotal de pagina 
            $subTotalPerPage += $vienen;
         }
    }
@endphp
        <tr style="background-color:{{$background}}">
        <td width="5%" align="center">{{$acum2}}</td>
        <td width="40%" >{{$space}}{{$propDetail->serviceName}}</td>
        <td width="10%" align="center">{{$propDetail->unit}}</td>
        <td width="15%" align="center">{{$propDetail->quantity}}</td>
        <td width="15%" align="center">{{$symbol}}  {{$propDetail->unitCost}}</td>
        <td width="15%" align="right">{{$symbol}}  {{$propDetail->amount}}</td>
        </tr>
@php
       $subTotalPerPage += $propDetail->amount;//acumulacion de subtotal de pagina
       $subTotalPerPage = number_format((float)$subTotalPerPage, 2, '.', '');
       $vienen =  number_format((float)$subTotalPerPage, 2, '.', '');

    $line++;
}// FIN DE FOREACH DE RENGLONES
@endphp
   {{-- // imprimir footer de factura --}}
</table>
<table cellspacing="0" cellpadding="0" border="0">
      <tr>
        <th colspan="3" style="background-color:#f2edd1;" align="center"><span id="bold"></span>
        </th>
       </tr>
       <tr>
        <th width="70%">
             <span id="bold">Payment break down:</span><br>
 @php        
       $acum3  = 0;
       foreach ($proposal[0]->paymentProposal as $receivable) {
        $acum3 = $acum3 + 1;
@endphp
      <table cellspacing="0" cellpadding="0" border="0"  >
                <tr>
                 <td width="10%">{{$acum3}}</td>
                 <td width="20%">{{$moneySymbol}} {{$receivable->amount}}</td>
                 <td width="75%"></td>
                </tr>
      </table>
@php
  }
@endphp
        </th>
        <th width="30%">
             <table cellspacing="0" cellpadding="0" border="0"  >
               <tr>
                <th><span id="bold">Subtotal</span></th><th style="border-top:1px solid black;"  align="right"> {{$moneySymbol}}{{$proposal[0]->grossTotal}}</th>
               </tr>
               <tr>
                <th><span id="bold">Tax Rate</span></th><th align="right">{{$proposal[0]->taxPercent}}%</th>
               </tr>
               <tr>
                <th><span id="bold">Tax</span></th><th align="right"> {{$moneySymbol}}{{$proposal[0]->taxAmount}}</th>
               </tr>
                <tr>
                <th><span id="bold">Total</span></th><th align="right"> {{$moneySymbol}}{{$proposal[0]->netTotal}}</th>
               </tr>
             </table>
        </th>
       </tr>
</table>


        <div style="background-color:#f2edd1;font-size:17px;" colspan="1" align="center"><span id="bold">Terms & Conditions</span></div>
           <ul>
@foreach($proposal['0']->note as $note)
    <li>{!! nl2br($note->noteName) !!}</li>
@endforeach
           </ul>

        <div style="background-color:#f2edd1;font-size:17px;" colspan="1" align="center"><span id="bold">Scope of Work</span></div>
          <ul>
@foreach($proposal['0']->scope as $scope)
    <li>{!! nl2br($scope->description) !!}</li>
@endforeach
         </ul>
<br>
  <table cellspacing="0" cellpadding="0" border="0" >
  {{--      <tr>
        <th style="background-color:#f2edd1;" colspan="1" align="center">
          -
        </th>
       </tr> --}}
       <br>
       <tr>
        <th align="center">
         We are pleased to have the opportunity to submit this proposal and look forward to the prospect of working with you on this project. If the proposal is acceptable as presented, please sign where indicated below and return one copy to our office. If you have any questions, please do not hesitate to call us.
         </th>
       </tr>
</table>

<br><br><br>

  <table  cellspacing="0" cellpadding="0" border="0">
       <tr align="center">
         <th> 
        ACCEPTED BY: _____________________________________<br>
                          Mr./Mrs. {{$client->clientName}}
         </th>
       </tr>
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
