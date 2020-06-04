<?php

namespace App;

use App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceScope extends Model
{
    //traits
    // use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'invoice_scope';
    protected $primaryKey = 'invScopeId';
    protected $fillable = ['invScopeId','invoiceId','description'];

//------------------------------------
    public function getAllByInvoice($invoiceId)
    {
        $result = $this->where('invoiceId', $invoiceId)
            ->orderBy('invScopeId', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------------
    public function insert($invoiceId,$description) {

     $error = null;

        DB::beginTransaction();
        try {
            //INSERTA UN RENGLON
             $invScope                   = new InvoiceScope;
             $invScope->invoiceId        = $invoiceId;
             $invScope->description      = $description;
             $invScope->save();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Alcance agregada Exitosamente'];
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
            $oInvoiceScope = InvoiceScope::where('invoiceId',$id)->delete();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Alcance Eliminada Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//-----------------------------------------

}
