
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


<table cellspacing="0" cellpadding="1px" border="0">
       <tr >
        <th style="background-color:#efcb44;font-size:18px;color:white" colspan="3" align="center"><b>JOURNAL ENTRIES</b></th>
       </tr>

        <tr> 
         <th width="20%" align="left"> 
          <br>
          <img src="img/logos/jd/logo_jd.png" alt="test alt attribute" width="140px" height="120px"/>
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
            <tr style="font-size:12px" >
              <td><b>Report Date:</b></td>
              <td align="left">{{$date->format('m/d/Y')}}</td>
            </tr>
         </table>     
      </th>

    </tr>
@if($dateRange['date1'] != '')
  <div  align="center" >
     <h2>From: {{$dateRange['date1']}} To: {{$dateRange['date2']}}</h2>
  </div>
@elseif($dateRange['year'] != '')
<div align="center" >
     <h2>Year: {{$dateRange['year'] }}</h2>
</div>
@endif
</table>


 <table style="border-collapse: collapse;" cellspacing="0" cellpadding="1px" >
     <thead>
    <tr style="background-color:#f2edd1; color:black; font-size:10px;" id="bold" align="center">
        <!-- <th>#</th> -->
        <th>ASIENTO</th>
        <th>FECHA</th>
        @if($modelReport == 'accountName')<th>NOMBRE DE CUENTA</th>@elseif($modelReport == 'accountCode')<th>CUENTA</th>@endif
        <th>DESCRIPCION DE LA TRANSACCION</th>
        <th>DEBE</th>
        <th>HABER</th>
    </tr>
     </thead>
@php
// Inicio del ciclo de impresion
 $background= '';
@endphp

@foreach ($rs as $header) 

@php
  $transactionQuantity = 0;
  $acum1 = 0; $acum2   = 0;
  $totalDebit          = 0;
  $totalCredit         = 0;

  $transactionQuantity = count($header['transaction']);
  $acum1 += 1;
      if($acum1 % 2 != 0) { $background = "#fbfbfb";} else { $background = "#f2edd1";}
@endphp
   
    @foreach ($header['transaction'] as $key => $transaction)
           @php
            $acum2 += 1;
            $totalDebit  += $transaction['debit'];
            $totalCredit += $transaction['credit'];
           @endphp
<tr style="background-color:{{$background}}; font-size:8px;">

        @if($acum2 == 1)
         <td rowspan="{{$transactionQuantity}}" align="center">{{$header['entryNumber'] }}</td>
         <td rowspan="{{$transactionQuantity}}" align="center">{{Carbon\Carbon::parse($header['entryDate'])->format('m/d/Y')}}</td>
        @endif
        @if($modelReport == 'accountName')
        <td align="left">{{$transaction['generalLedger']['accountName'] }}</td>
        @elseif($modelReport == 'accountCode')
        <td align="left">{{$transaction['generalLedger']['accountCode'] }}</td>
        @endif
         <td align="left">{{$transaction['transactionDescription'] }}</td>
         <td align="right">{{number_format($transaction['debit'], 2, '.', ',') }}</td>
         <td align="right">{{number_format($transaction['credit'], 2, '.', ',') }}</td>

           <!-- // detectar todos menos el último: -->
          @if($loop->last)) 
           <tr  style="background-color:cdcdcd; font-size:8px;">
             <td align="right"> </td>
             <td align="right"></td>
             <td align="right"> </td>
             <td align="center"> <b>TOTAL</b></td>
             <td align="right"> <b>{{number_format($totalDebit, 2, '.', ',') }} </b></td>
             <td align="right"> <b>{{number_format($totalCredit, 2, '.', ',') }} </b></td>
           </tr>
           @endif
 </tr>
   @endforeach<!--  Fin de Foreach de transactions -->
 @endforeach <!--  Fin de Foreach de Headers-->

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
