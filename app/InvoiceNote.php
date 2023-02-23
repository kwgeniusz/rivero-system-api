<?php

namespace App;

use App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceNote extends Model
{
    //traits
    // use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'invoice_note';
    protected $primaryKey = 'invNoteId';
    protected $fillable = ['invNoteId','invoiceId','noteId','noteName'];

//------------------------------------
    public function getAllByInvoice($invoiceId)
    {
        $result = $this->where('invoiceId', $invoiceId)
            ->orderBy('invNoteId', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------------
    public function insert($invoiceId,$noteId,$noteName) {

     $error = null;

        DB::beginTransaction();
        try {
            //INSERTA UN RENGLON
             $invNote                   = new InvoiceNote;
             $invNote->invoiceId        = $invoiceId;
             $invNote->noteId        = $noteId;
             $invNote->noteName      = $noteName;
             $invNote->save();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Nota agregada Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//------------------------------------------

//------------------------------------------
    public function deleteInv($id)
    {
           $error = null;

        DB::beginTransaction();
        try {
            //BUSCAR EL RENGLON PARA SACAR SU invoiceId y amount
            $oInvoiceNote = InvoiceNote::where('invoiceId',$id)->delete();


            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Nota Eliminada Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//-----------------------------------------

}
