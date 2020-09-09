
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
            margin: 2cm 2cm 3cm 2cm;
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

/*html, body, .container { height: 100%; margin: 0; }

.container{
    background-color:#fff;
    width: 90%;
    height:90%;
    clear:both;
    z-index: 0;
}

.header {
      background-color: #505050;
    height:20px;
    z-index:1;
}
      
.darky-header {
      background-color: #464646;
    height:5px;
    z-index:1;
}
      
.logo {
    background-color: #ffc501;
    float: left;
    margin-top:0px;
    margin-left:10px;
    width:120px;
    height:120px;
    border-radius: 0px 0px 5px 5px;
    z-index:1;
}
      
.upper-right{
    float:right;
    width:120px;
    height:30px;
    background-color:#ffc501;
    border-radius: 0px 0px 0px 8px;
    z-index:1;
}
      
.content{
    float:center;
    padding: 5px 5px 5px 5px;
    width:100%;
    height:80%;
    background-color:#fff;
    z-index:0;
}
        
.logoWM1 {
    float:right;
    margin-top:-80px;
    width:170px;
    height:250px;
    background-color: #999;
    z-index:2;
}
        
.logoWM2 {
    float:left;
    margin-top:140px;
    width:170px;
    height:250px;
    background-color: #999;
    z-index:2;
}

.block2 {
    background-color: #ffc501;
    position:absolute;
    margin-top:-30px;
        margin-left:210px;
    width:375px;
    height:40px;
    border-radius: 5px 5px 0px 0px;
    z-index:2;
}
        
.darky-footer {
      background-color: #464646;
    height:5px;
    z-index:1;
}
      
.footer{
    height:20px;
    background-color:#505050;
    z-index:0;
}
        
.lower-left{
    float:left;
    width:120px;
    height:30px;
    margin-top:-10px;
    background-color:#ffc501;
    border-radius: 0px 8px 0px 0px;
    z-index:2;
}
        
.lower-right{
        position:absolute;
    width:120px;
    height:30px;
    margin-top:-29px;
    margin-left:680px;
    background-color:#ffc501;
    border-radius: 8px 0px 0px 0px;
    z-index:2;
}*/
    </style> 

</head>
  <body>




 {{-- // imprimir encabezado de statement --}}

<table cellspacing="0" cellpadding="1px" border="0"  >
       <tr >
        <th style="background-color:#e5db99;font-size:18px;" colspan="3" align="center"><b>PROPOSAL</b></th>
       </tr>
</table>
       
<div style="text-align: right">
July 8th, 2020
</div>       

<br>
<div>
Mr. Gino Gallegos    <br>                                
gino2051@gmail.com   <br>
C. (469) 258 0764    <br>
Customer ID: XXXXX   <br>
</div>

<br>
<div>
RE: Professional Design Services Proposal <br>
       12201 C. F. Hawn Freeway Dallas, TX 75253 <br>
       Proposal ID: XXXX <br>
       Precontract ID: XXX <br>
</div>

<br>
<div >
Dear Mr/Mrs. Gallegos
</div>

<br>
<div style="text-align: justify;">
We are pleased to submit this proposal to provide Professional Design Services associated with the Commercial project at the reference address in Dallas, Texas. Based on our perception of the overall project objectives, we propose to perform the following scope of work.
</div>

 <table cellspacing="0" cellpadding="0" border="0"  >
{{--        <tr>
        <th style="background-color:#f2edd1;font-size:17px;" colspan="1" align="center"><span id="bold">Scope of Work</span>
        </th>
       </tr> --}}
       <tr> 
          <ul>
@foreach($proposal['0']->scope as $scope)
    <li>{!! nl2br($scope->description) !!}</li>
@endforeach
         </ul>
       </tr>
</table>

<div>
To comply with the scope of work we propose the following tasks:
</div>
<br>


 
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
       $acum= 0 ;
       $subTotalPerPage= 0;
           $acumPropDetail = 0;

foreach ($proposalsDetails as $propDetail) {



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
}// FIN DE FOREACH DE RENGLONES
@endphp
      <tr >
        <td width="5%" align="center"></td>
        <td width="40%" ></td>
        <td width="10%" align="center"></td>
        <td width="15%" align="center"></td>
        <td width="15%" align="center">TOTAL:</td>
        <td width="15%" style="border-top:2px solid black"align="right"> {{$subTotalPerPage}}</td>
     </tr>
</table>

<br>
<div style="text-align: center;">
   <b>Payment breakdown:</b>
</div>


    @foreach ($proposal[0]->paymentProposal as $receivable) 
     <div>
        TO START {{$symbol}}{{$receivable->amount}}
     </div>
    @endforeach


<br>
 <table cellspacing="0" cellpadding="0" border="0"  >
       <tr>
        <th style="background-color:#f2edd1;font-size:17px;" colspan="1" align="center"><span id="bold">Time Frame</span></th>
       </tr>
       <tr> 
           <ul>
@foreach($proposal['0']->note as $note)
    <li>{!! nl2br($note->noteName) !!}</li>
@endforeach
           </ul>
       </tr>
</table>


 <table cellspacing="0" cellpadding="0" border="0"  >
       <tr>
        <th style="background-color:#f2edd1;font-size:17px;" colspan="1" align="center"><span id="bold">Terms & Conditions</span></th>
       </tr>
       <tr> 
           <ul>
@foreach($proposal['0']->note as $note)
    <li>{!! nl2br($note->noteName) !!}</li>
@endforeach
           </ul>
       </tr>
</table>
{{-- 
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
        <td width="22.5%" align="center">{{$symbol}} {{$invoice[0]->netTotal}}</td>
    </tr>
@php
       $acum = 0 ;
       $statement = $invoice[0]->netTotal;

 //// inicio del ciclo de impresion
foreach ($transactions as $transaction) {
               $acum = $acum + 1;
                if ($acum % 2 != 0) {
                    $background = "#f2edd1";
                } else {
                    $background = "#fbfbfb";
                }

                   $statement = $statement - $transaction->amount;
                   $statement = number_format((float)$statement, 2, '.', '');
                   
@endphp
        <tr style="background-color:$background;">
         <td width="20%" align="center">{{$transaction->transactionDate}}</td>
         <td width="35%" align="left"> {{$transaction->reason}}</td>
         <td width="22.5%" align="center">{{$symbol}} {{$transaction->amount}}</td>
         <td width="22.5%" align="center">{{$symbol}} {{$statement}}</td>
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
             {{$symbol}} {{$nextShare}}
            </th>
            <th>
             {{$symbol}} {{$nextShare}}
            </th>   
              <th>
             {{$symbol}} {{$nextShare}}
            </th>  
               <th>
             {{$symbol}} {{$nextShare}}
            </th>     
       </tr>
</table>   
 <br><br>
 <table cellspacing="0" cellpadding="0" border="0"  >
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
</table>
 --}}



{{-- 
 <div class="container">
      <div class="header">
        <div class="upper-right">Texture</div>
        <div class="logo">Logo</div>
      </div>
      <div class="darky-header"></div>
      <div class="content">Content askjdañskdj a}sdk ñaskdj ñasjdñlkasjdlaskjdl
        asdk aslkdj alkdj lak klas dlñakjsd kajsd asd asjdhlasjk dkaj sakdj
        lñaskjdp aojsdpoa jspdojaspdoj apsjdo apjs dpajsdpasjd pasojdas aspod
        jiapjdpaojsdpoajsdpojasdp apsjdpasojd pasoj pas dpas pajsd pajs psaj paj
        pa sda jsdja sas djapsj dpaosj dpjasdpjapsdjpasjd pasjd pasj pas jdpajs
        dpaojs dpaojs dpojasd pjosp djapsoijda a jsdpajsdṕjasdpjaspd
        japsdjpasjdpsajd psaj dpajs pjsadpjpj pas jdpajdpajsdp jaspdjapsjd asas
        asidoasjdájsdpoaj sdj́as asj dpoaijsdpasjd poaisjdoiajs dpajdpjao
        isdpajsdpoajsdpoajsdpojasd a sdáijsdpájs dpojasp dojapsdjapsjd pajsdp
        jaspdjaspd japs jdpa 
        <div class="logoWM1"></div>
        <div class="logoWM2"></div>
      </div>
      <div class="block2">asdasdasdadadsdas asdas das</div>
      <div class="darky-footer"> </div>
      <div class="footer">Footer
        <div class="lower-left">Texture</div>
        <div class="lower-right">Texture</div>
      </div>
</div>
 --}}

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
