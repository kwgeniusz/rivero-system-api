<style>
@page {
    margin: 0cm 0cm;
    font-family: helvetica;
    font-weight: normal; !important
}

    .page-break {
    page-break-after: always;
}

    .pagenum:before {
    content: counter(page);
}

    body {
    margin: 1.5cm 1.5cm 2cm 1.5cm;
    font-size: 13px;
    background:white;
}

    .container-header{
    position: fixed;
}

    .header {
	  background-color: #505050;
    border-bottom: 4px solid #303030;
    width:100%;
  	height: 20px;
  	z-index: 1;

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

    .logo img {
    width: 100px;
    margin: 12px 5px 5px 10px;
}

    .wm-one {
    position:absolute;
    top: 50px;
  	left: 488px;
    z-index: 2;
    opacity:0.5;
    z-index:-1;
   }

   .wm-two {
    position:absolute;
    top: 480px;
    z-index: 2;
    opacity:0.5;
    z-index:-1;
   }

    .upper-right{
    position: absolute;
    width: 100px;
    height: 30px;
    margin-top: 50px;
    margin-left: 700px;
    background-color: #ffc501;
    border-radius: 0px 0px 0px 10px;
    z-index: 2;
}
   /** Define the footer rules **/
    .footer {
    position: fixed; 
    top:98%;
    bottom: 0cm; 
    left: 0cm; 
    right: 0cm;
    height: 0cm;
    width:100%;
  	height:20px;
    border-top: 4px solid #303030;
    background-color:#505050;
  	z-index:1;
}

   .lower-block {
    position:absolute;
    background-color: #ffc501;
    width:375px;
    font-size:10.5px;
    margin-top:-40px;
    margin-left:95px;
    margin-bottom:18px;
    border-radius: 10px 10px 0px 0px;
    padding: 5px 5px 5px 5px;
    z-index:2;
    /*margin-left:205px;*/
    /*height:40px;*/
    /*margin-bottom:100px;*/
    /*padding:3px;*/
}
    .lower-left {
    /*float:left;*/
    /*margin-top:-10px;*/
    display:inline-block; 
    margin-top:-2px;
    width:100px;
    height:30px;
    background-color:#ffc501;
    border-radius: 0px 10px 0px 0px;
    z-index:2;
}

    .lower-right {
    /*float:right;*/
    /*margin-left:700px;*/
    display:inline-block; 
    margin-top:-40px;
    margin-left:694px;
    width:100px;
    height:30px;
    background-color:#ffc501;
    border-radius: 10px 0px 0px 0px;
    z-index:2;
}

    table {
    width:100%;
     /*border:1px solid black;*/
}

    .table-header {
    background-color:#ffc501; 
    font-size:17px; 
    text-align:center;
}

    td,tr,th{
    font-weight:normal;
}

    .bold {
    font-weight: bold !important;
}

    .just {
    text-align: justify;
}

    .date {
    float:right;
}

    .client-info {
    margin-top:70px;
}

</style>
     {{-- Page <span class="pagenum"></span> --}}

<body>
<div class="container-header">
  <div class="header"></div>

  <div class="upper-right"></div>
   <div class="logo"><img src="img/logos/jd.png"></img></div>
</div>

<img class="wm-one" src="img/logos/1.png"></img>
<img class="wm-two" src="img/logos/2.png"></img>

<div class="footer">


     {{-- Page <span class="pagenum"></span> --}}
        <div class="lower-left"></div>
        <div class="lower-block"><i class="fa fa-mail"></i>project@jdrivero.com <i class="fa fa-globe"></i>www.jdrivero.com <i class="fa fa-phone"></i>+ (214) 462-0623 <i class="fa fa-fax"></i>+1 (469) 466-9747 <br>
        <i class="fa fa-map-marker"></i>9304 Forest Lane Suite #N274, Dallas, TX 75243.
        </div>
        <div class="lower-right"></div>
 </div>

<div class="date bold">
July 8th, 2020
</div>       

<div class="client-info bold">
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
<div class="just">
We are pleased to submit this proposal to provide Professional Design Services associated with the Commercial project at the reference address in Dallas, Texas. Based on our perception of the overall project objectives, we propose to perform the following scope of work.
</div>


        <ul>
@foreach($proposal['0']->scope as $scope)
          <li>{!! nl2br($scope->description) !!}</li>
@endforeach
        </ul>
  
<div>
To comply with the scope of work we propose the following tasks:
</div>
<br>


 
 <table style="border-collapse: collapse;" cellspacing="0" cellpadding="1px" border="0">
        <thead>
        <tr class="table-header bold">
          <th width="5%" align="center">#</th>
          <th width="40%">DESCRIPTION</th>
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
                    $background = "#d7d7d7";
                } else {
                    $background = "#ffffff";
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
        <th class="table-header" colspan="1">Time Frame</th>
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
        <th class="table-header" colspan="1">Terms & Conditions</th>
       </tr>
       <tr> 
           <ul>
@foreach($proposal['0']->note as $note)
    <li>{!! nl2br($note->noteName) !!}</li>
@endforeach
           </ul>
       </tr>
</table>
</body>