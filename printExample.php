<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Client;

class PrintInvoice extends Controller
{
   
  // preparar variables  
  $line = 100;  
  $page = 0;              // paigina 1/1;   pagina 1/2  pagina 2/2
  $pageTotal = $object->getPageTotal();
  $linesperpage = 40;    // verfificar este numero

  
  // suponer que el encabezado 20 lineas
  
  // leer dataos
  $rs1  = $invoice->leerDatos();                // datos de cabecera
  $rs2  = $invoiceDetail->leeerDatos();         // datos de renglones

  foreach ($rs1 as $rsh) {              // cabecera invoice
       // obtener datos de la cabecera
  } 

  //// inicio del ciclo de impresion
  foreach ($rs2 as $rsd) {              // renglones  invoiceDetail

    // imprimir encabezado de factura
    if ($line > $linesperpage){               // imprimir
       
       if ($page > 0) {                                 
          // imprimir pie de pagina
          // imprimir pie de pagina
       }

       $page++;
       $line= 20;
       // incluir codigo de imprimer encabezado     
    } 
    // copiar variables renglones de tabla a memoria
    $cantidad = $rsd->qty;
    $service  = $rsd->service;

    $line++;
    /// imprimir renglon
  }
  // imprimir pie de pagina


  ////  fin del ciclo de impresion

}
