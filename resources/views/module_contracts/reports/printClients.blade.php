
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
        <th style="background-color:#efcb44;font-size:18px;color:white" colspan="3" align="center"><b>LIST JD RIVERO'S CUSTOMERS</b></th>
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

        <b>Report Date:</b><br> {{$date->format('m/d/Y')}}
      </th>

    </tr>
</table>
<br>
<table stype="border-collapse: collapse;" cellspacing="0" cellpadding="1px" border="1" >
        <thead>
        <tr style="background-color:#f2edd1; color:black; font-size:14px;" id="bold" align="center">
          <th>#</th>
          <th >CODE</th>
          <th >NAME</th>
          <th >PHONE</th>
          <th >EMAIL</th>
          {{-- <th >ADDRESS</th> --}}
          <th >CONTACT TYPE</th>
        </tr>
        </thead>
@php
       $acum = 0 ;
 //// inicio del ciclo de impresion
foreach ($clients as $client) {
               $acum = $acum + 1;
                if ($acum % 2 != 0) {
                    $background = "#fbfbfb";
                } else {
                    $background = "#f2edd1";
                }
@endphp
        <tr style="background-color:{{$background}}; font-size:11px; text-align: center">
         <td>{{$acum}}</td>
         <td>{{$client->clientCode}}</td>
         <td>{{$client->clientName}}</td>
         <td>{{$client->clientPhone}}</td>
         <td>{{$client->clientEmail}}</td>
         <td>{{$client->contactType->contactTypeName}}</td>
        </tr>
@php
}// FIN DE FOREACH DE RENGLONES

   // imprimir footer de factura
@endphp
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
