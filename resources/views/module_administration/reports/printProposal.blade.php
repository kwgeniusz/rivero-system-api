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
    font-size: 13px;
}

    .header {
	  background-color: #505050;
    width:100%;
  	height: 20px;
  	z-index: 1;
}

    .upper-line {
	  background-color: #303030;
  	height: 5px;
  	z-index: 1;
}

    .lower-line {
    position:absolute;
    margin-top:948px;
    width:100%;
  	height:5px;
    background-color:#303030;
  	z-index:1;
}

    .logo {
  	background-color: #ffc501;
    float: left;
    margin-top: -75px;
  	margin-left: 10px;
  	width: 120px;
  	height: 120px;
    border-radius: 0px 0px 10px 10px;
  	z-index: 2;
}

    .upper-right{
    position: absolute;
  	width: 100px;
    height: 30px;
    margin-top: 50px;
    margin-left: 543px;
    background-color: #ffc501;
    border-radius: 0px 0px 0px 10px;
    z-index: 2;
}

    .lower-block {
  	background-color: #ffc501;
  	position:absolute;
  	margin-top:920px;
    margin-left:131px;
    padding:3px;
  	width:375px;
  	height:40px;
    border-radius: 10px 10px 0px 0px;
  	z-index:2;
}

    .lower-left{
    float:left;
  	width:100px;
    height:30px;
    margin-top:-10px;
    background-color:#ffc501;
    border-radius: 0px 10px 0px 0px;
    z-index:2;
}

    .lower-right{
    float:right;
  	width:100px;
    height:30px;
    margin-top:-10px;
    background-color:#ffc501;
    border-radius: 10px 0px 0px 0px;
    z-index:2;
}

    .footer{
    position:absolute;
    margin-top:952px;
    width:100%;
  	height:20px;
    background-color:#505050;
  	z-index:1;
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

<div class="header"></div>
<div class="upper-line"></div>
<div class="upper-right"></div>

<div class="logo"><img class="img" src="/public/img/logos/jd.png"></img></div>

<div class="lower-block">ESCRIBE AQUÍ LO DEL FOOTER</div>

<div class="lower-line"></div>
<div class="footer">
        <div class="lower-left"></div>
        <div class="lower-right"></div>
      </div>

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

Manuel Castro, [08.09.20 18:49]
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