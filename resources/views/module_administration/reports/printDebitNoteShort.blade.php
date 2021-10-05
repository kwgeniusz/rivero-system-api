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

        table{
            width:100%;
            /*border:1px solid black;*/
        }
        td,tr,th{
            font-weight:normal;
        }
        .table-center{
           table-layout: fixed;
           border: 1px solid black;
           width: 60%;
           margin:0 auto;
        }

        #bold {
          font-weight: bold;
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
        
       .pagenum:before {
        content: counter(page);
        }

        .pagination {
         position: absolute;
         color: black;
         bottom: 15px;
         left: 680px;
        }

    </style>
</head>
<body>

<table cellspacing="0" cellpadding="1px" >
       <tr>
        <th id="bold" style="background-color:#e5db99; font-size:18px;" colspan="3" align="center">DEBIT NOTE</th>
       </tr>
 
       <tr> 
         <th width="20%" align="center"> 
          <img src="img/logos/jd/logo_jd.png" alt="test alt attribute" width="140px" height="120px"/>
         </th>
        <th width="55%">
             <div style="text-align:center">
               <strong style=" font-size:22px;"  >{{$company[0]->companyName}}</strong><br>
               <img src="img/icon-point.png" width="10px" height="10px"/> {{$company[0]->companyAddress}}<br>
               <img src="img/icon-phone.png" width="10px" height="10px"/> {{$company[0]->companyPhone}},{{$company[0]->companyPhoneOptional}}<br>
               <img src="img/icon-email.png" width="10px" height="10px"/> {{$company[0]->companyEmail}}
               <img src="img/icon-location.png" width="10px" height="10px"/> {{$company[0]->companyWebsite}}
             </div>
        </th>
    <th width="25%">
        <table>       
          <tr>
              <td id="bold">Debit Note Number:
              {{$debitNote[0]->salId}}</td>
            </tr>
            <tr>
              <td id="bold">Date:
              {{$debitNote[0]->dateNote}}</td>
            </tr>
       
            <tr>
              <td id="bold">Page: <span class="pagenum"></span> </td>
            </tr>
            <tr>
              <td id="bold">Apply To: Invoice #{{$debitNote[0]->invoice->invId}}</td>
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
              <span id="bold">Phone:</span> {{$client->businessPhone}}
            </th>
       </tr>
      <tr> 
            <th colspan="2">
              <span id="bold">Billing Address:</span> {{$client->clientAddress}}
            </th>
             <th colspan="1">
               <span id="bold">E-mail:</span> {{$client->mainEmail}}
            </th>
       </tr>
</table>
<br>
  <table cellspacing="0" cellpadding="1px" border="0">
       <tr>
        <th colspan="1" style="background-color:#f2edd1;font-size:14px;text-align: center"><span id="bold">COMMISSION CHARGE:</span></th>
       </tr>
       <tr> 
            <th colspan="1">
              REFERENCE:{{$debitNote[0]->reference}} / AMOUNT:{{$symbol}}{{$debitNote[0]->netTotal}}
            </th>
       </tr>
</table>

<!-- <br><br>
<div align="center">
<b>NOTE:</b> If the payment is by Check, Cash or Money Order, leave it at the office or give it to one of our employees at the project address.
</div> -->

<footer>
© Copyright 2020 JD Rivero Global - All rights reserved <br>
    Designed By Rivero Visual Group
        <div class="pagination">
        <p>Page <span class="pagenum"></span></p>
        </div>
</footer>
</body>
</html>
