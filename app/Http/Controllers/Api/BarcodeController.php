<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Staff;
use Illuminate\Support\Facades\Hash;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;

class BarcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function barcodeCreate($staffCode)
    {
        $Barcode = new DNS1D;
        $staff = Staff::where('staffCode','=',$staffCode)->first();

        if (empty($staff)) {
            return 'No se encontraron datos';
        }
        // $user = '994049JD-000002';
        // $user = 'eyJpdiI6Ik9cL0tcL0V5YXczSVUzaGJnanA3dXgrQT09IiwidmFsdWUiOiJRc3JSOENvaGQzcjBXcmZYS1JhTW9qcCtXZFhRUUxHZXRFYWZ0cTRibXFFPSIsIm1hYyI6IjIzNzk2YTc4Nzg1ZDJlZTZlZDdiYjVjZDQ5ZWNlYzI5ZjA5ZTA4MzZkZTQzNDc0MTc1ZTM2MmNiMmQwY2U0NDAifQ==';
        $numberRand = rand(100000,1000000);
        $barcode = $numberRand . $staff->staffCode;
        // echo $barcode.'   -==-';
        // $success = false;
        // while (!$success) {
        //     Staff::where('barcode',Hash::check($id2, 'barcode'));
        // }
        // $barcodEncrypted1 = Hash::make($barcode);
        // $barcodEncrypted = encrypt($barcode);
        
        // $decrypted = decrypt($staff->barcode);
        // $decrypted = $staff->barcode;
        // if($user == $decrypted) {
        //     return 'correcto';
        // }else {
        //     return 'incorrecto';
        // }
        // // $decIdHash =  Hash::check($idHash, $id);
        // return $correct;
        // echo $barcode;
        // Staff::where('hrstaffId', $staff->hrstaffId)
        //     ->update(['barcode' => $barcodEncrypted1]);
        Staff::where('hrstaffId', $staff->hrstaffId)
            ->update(['barcode' => $barcode]);

        return $Barcode->getBarcodePNG($barcode, 'C128');
        // return $Barcode->getBarcodePNG($barcodEncrypted1, 'C128');
        // return DNS2D::getBarcodePNG($barcode, 'QRCODE');
        // return $Barcode->getBarcodePNG($barcode, 'C128');
        //  return DNS1D::getBarcodePNGPath($barcode, 'C128');
          
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function barcodeShow($barcode)
    {
        $staff = Staff::where('barcode','=',$barcode)->first();
        return response()->json($staff, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
