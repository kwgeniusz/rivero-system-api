<style>
@page {
		margin: 0cm 0cm;
		font-family: helvetica;
		font-weight: normal;
}

		table {
		page-break-after: auto ;
}

		.pagenum:before {
		content: counter(page);
}

		body {
		margin: 1.5cm 1.5cm 2.5cm 1.5cm;
		font-size: 12px;
		background: white;
		/* To move everything up there */
		margin-top: 135px;
}

		.container-header{
		position: fixed;
		z-index: -1;
}

		.header {
		background-color: #505050;
		border-bottom: 4px solid #303030;
		width:100%;
		height: 30px;
		z-index: 1;

}
		.logo {
		background-color: #ffc501;
		float: left;
		margin-top: -50px;
		margin-left: 30px;
		width: 90px;
		height: 90px;
		border-radius: 0px 0px 10px 10px;
		z-index: 2;
}

		.logo img {
		width: 70px;
		margin: 12px 5px 5px 10px;
}

		.wm-one {
		position: absolute;
		top: 81px;
		left: 544px;
		z-index: 2;
		opacity: 0.5;
		z-index: -1;
	 }

	 	.wm-two {
		position: absolute;
		top: 480px;
		z-index: 2;
		opacity: 0.5;
		z-index: -1;
	 }

		.upper-right{
		position: absolute;
		width: 80px;
		height: 70px;
		margin-top: 50px;
		margin-left: 715px;
		background-color: #ffc501;
		border-radius: 0px 0px 0px 10px;
		z-index: 2;
}
	 /** Footer rules **/
		.footer {
		position: fixed;
		top: 96%;
		bottom: 0cm;
		left: 0cm;
		right: 0cm;
		height: 0cm;
		width: 100%;
		height: 50px;
		border-top: 19px solid #303030;
		background-color:#505050;
		z-index: 1;
}

		.footer img {
		position: relative;
		margin-top: 3px;
		width: 12px;
}

	 	.lower-block {
		position: absolute;
		background-color: #ffc501;
		width: 535px;
		height: 31px;
		font-size: 10.5px;
		text-align: center;
		margin-top: -60px;
		margin-left: 35px;
		margin-bottom: 48px;
		border-radius: 10px 10px 0px 0px;
		padding: 5px 5px 5px 5px;
		z-index: 2;
}
		.lower-left {
		display: inline-block; 
		margin-top: -10px;
		width: 80px;
		height: 59px;
		background-color: #ffc501;
		border-radius: 0px 10px 0px 0px;
		z-index: 2;
}

		.lower-right {
		display: inline-block;
		margin-top: -79px;
		margin-left: 715px;
		width: 80px;
		height: 60px;
		background-color: #ffc501;
		border-radius: 10px 0px 0px 0px;
		z-index: 2;
}

		table {
		width: 100%;
		 /*border:1px solid black;*/
}

		.table-header {
		background-color: #ffc501; 
		font-size: 17px; 
		text-align: center;
}

		td,tr,th{
		font-weight:normal;
}

		.bold {
		font-weight: bold !important;
}

		.big {
		font-size: 16px;
}

		.float-left {
		float: left;
		margin-left: 5px;
}

		.center {
		text-align: center;
		}

		.prologue {
		margin-top: 70px;
}

		.just {
		text-align: justify;
}

		.tab {
		padding-left: 40px;
}

		.date {
		float: right;
		margin-top: -40px;
}

		.line-height {
		line-height: 1.5;
}

		.pagination {
		position: absolute;
		color: black;
		margin-top: -30px;
		margin-left: 727px;
		z-index: 3;
		}

		.text-alt {
		font-size: 10px;
		color:white;
}

		.table-sign {
		margin-left: 40px;
		}

/* Top margin for table, #TODO have to improve this later on */
		.ts{
		margin-top: 10px;
		}

</style>


<body>
<div class="container-header">
	<div class="header"></div>

	<div class="upper-right"></div>
	 <div class="logo"><img src="img/logos/jd/jd.png"></img></div>
				<img class="wm-one" src="img/logos/jd/1.png"></img>
				<img class="wm-two" src="img/logos/jd/2.png"></img>
</div>

<div class="footer">
				<div class="pagination">
				<p>Page <span class="pagenum"></span></p>
				</div>

				<div class="lower-left"></div>
				<div class="lower-block">
				                                     <b>{{$company[0]->companyName}}</b> - 
					<img src="img/icon-email.png"></img> {{$company[0]->companyEmail}} 
					<img src="img/icon-location.png"></img> {{$company[0]->companyWebsite}} <br>
					<img src="img/icon-phone.png"></img> {{$company[0]->companyPhone}} / {{$company[0]->companyPhoneOptional}}
					<img src="img/icon-point.png"></img> {{$company[0]->companyAddress}}.
					<div class="text-alt">
					<p>© Copyright 2020 JD Rivero - All rights reserved | Designed by Rivero Visual Group</p>
					</div>
				</div>
				<div class="lower-right">
				</div>
 </div>

<div class="date bold">
{{$date->format('F jS, Y')}}
</div>       

<div class="big bold">
<b>
@if($client->clientType == 'COMPANY') 
  {{$client->companyName}}
@else 
  @if($client->gender == 'M') Mr. @else Mrs. @endif {{$client->clientName}}
@endif


</b>
</div>   

{{$client->mainEmail}}   <br>
P. {{$client->businessPhone}}    <br>
C. ID: {{$client->clientCode}}   <br>

<br>
<div>
<div class="float-left"><b>RE:</b></div>
<div class="float-left">Professional Design Services Proposal <br>
           @if($proposal[0]->$modelType->projectName)
		    <b>Project Name:</b> {{$proposal[0]->$modelType->projectName}} <br>
           @endif
           @if($proposal[0]->$modelType->siteAddress)
			<b> {{$proposal[0]->$modelType->siteAddress}}</b> <br>
           @endif
  <div style="font-size:10px">	   
			Proposal ID: {{$proposal[0]->propId}} 
			- {{$modelTypeView}} ID: {{$modelId}} <br>
			Type: {{$proposal[0]->$modelType->projectUse->projectUseName}} -
			Description: {{$proposal[0]->projectDescription->projectDescriptionName}} <br>
  </div>			
</div>

<br>
<div class="prologue">
@if($client->clientType == 'COMPANY' && $client->clientName == '') 
  Dears <b>{{$client->companyName}}<b/>
@else 
  @if($client->gender == 'M')Dear <b>Mr. @else Dear <b>Mrs. @endif  {{$client->clientName}}</b>
@endif

</div>

<br>
<div class="just">
<span class="tab">
@if($proposal[0]->subcontId != null)  
 JD Rivero & {{$proposal[0]->subcontractor->companyName}} 
@else
We
@endif 
are pleased to submit this proposal to provide Professional Design Services associated with this project at the reference address in  {{$proposal[0]->$modelType->city}},  {{$proposal[0]->$modelType->state}}. Based on our perception of the overall project objectives, we propose to perform the following <b>scope of work</b>.

</div>

				<ul class="just">
@foreach($proposal['0']->scope as $scope)
					<li>{!! nl2br($scope->description) !!}</li>
@endforeach
				</ul>
	
<div>
To comply with the scope of work we propose the following deliverables:
</div>
 
 <table class="ts" style="border-collapse: collapse;" cellspacing="0" cellpadding="1px">
				<thead>
				<tr class="table-header bold">
					<th width="5%" align="center">#</th>
					<th width="55%">DESCRIPTION</th>
					<th width="10%" align="center">UNIT</th>
					<th width="10%" align="center">QTY</th>
					<th width="10%" align="center">UP</th>
					<th width="10%" align="center">AMOUNT</th>
				</tr>
				</thead>
@php 
			 $acum= 0 ;
			 $subTotalPerPage= 0;
					 $acumPropDetail = 0;

foreach ($proposalDetails as $propDetail) {

							 $acum = $acum + 1;
								if ($acum % 2 == 0) {
										$background = "#ffffff";
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
				<tr class="line-height">
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
{{-- <div class="big bold center">
	 <b>Payment Breakdown</b>
</div>
		@foreach ($proposal[0]->paymentProposal as $payment) 
			<ul>
					<li>{{$payment->paymentDate}} {{$symbol}}{{$payment->amount}}</li>
			</ul>
		@endforeach
 --}}
@if($proposal[0]->paymentProposal->isNotEmpty())
	<div class="big bold center">Payment Breakdown</div>
		 <ul>
@foreach($proposal[0]->paymentProposal as $payment)
		<li>{!! nl2br($payment->paymentDate) !!} {{$symbol}}{{$payment->amount}}</li>
@endforeach
	</ul>
	
<br>
@endif

@if($proposal[0]->timeFrame->isNotEmpty())
		<div class="big bold center">Time Frame</div>
		 <ul>
@foreach($proposal[0]->timeFrame as $item)
		<li>{!! nl2br($item->timeName) !!}</li>
@endforeach
		 </ul>
@endif

@if($proposal[0]->term->isNotEmpty())
	<div class="big bold center">Terms & Conditions</div>
		<ul>
@foreach($proposal[0]->term as $item)
		  <li>{!! nl2br($item->termName) !!}</li>
@endforeach
	  </ul>
@endif

<div class="big bold center">
	 <b>Payment Method</b>
</div>

<div style="text-align: left">
<b>Remit payment to:</b><br>
<div class="tab">{!! nl2br($company[0]->paymentMethods) !!}</div>
</div>
<br>
<div align="center">
If the payment is by Check, Cash or Money Order, leave it at the office or give it to one of our employees at the project address.
</div>

<br>
@if($proposal[0]->note->isNotEmpty())
	 <div class="big bold center">Note</div>
		 <ul>
@foreach($proposal[0]->note as $note)
		<li>{!! nl2br($note->noteName) !!}</li>
@endforeach
	 </ul>
<br><br>
@endif

<div class="just">
<span style='display:inline; white-space:pre;'> </span><span style='display:inline; white-space:pre;'> </span>We are pleased to have the opportunity to submit this proposal and look forward to the prospect of working with you on this project. If the proposal is acceptable as presented, please sign where indicated below and return one copy to our office. If you have any questions, please do not hesitate to call us. 
<br><br>
Sincerely.
</div>
<br><br>

<table class="table-sign" cellspacing="0" cellpadding="0" border="0"  >
			 <tr>
		@if($proposal[0]->subcontId != null)  
				<th align="center" >
				@if($proposal[0]->subcontractor->subcontType == 'COMPANY')  
					<b>{{$proposal[0]->subcontractor->subcontractorName}}</b> <br>
					{{$proposal[0]->subcontractor->companyName}} <br>
				@else
					<b>{{$proposal[0]->subcontractor->companyName}}</b> <br>
				@endif
				    <!-- ENGINEERING CONSULTING <br> -->
					{{$proposal[0]->subcontractor->serviceOffered}}<br>
					{{$proposal[0]->subcontractor->mainPhone}}
				</th>
		@endif  
				<th align="center">
					 <b>{{$proposal[0]->user->fullName}}</b><br>
					 {{$company[0]->companyName}} <br> Representative
					 {{-- (214) 718 6256 <br> --}}
				</th>
			 </tr>
</table>

<br><br><br><br><br>
<div  class="bold center">
Accepted By:     _____________________________________ <br>
          @if($client->gender == 'M') Mr. @else Mrs. @endif  {{$client->clientName}}</b>
</div>




</body>