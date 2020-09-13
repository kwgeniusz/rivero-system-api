<?php

namespace App\Http\Controllers\Web;

use Auth; 
use App\TimeFrame;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimeFrameController extends Controller
{
    private $oTimeFrame;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oTimeFrame = new TimeFrame;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     
     $timeFrames = $this->oTimeFrame->getAllByCompany(session('companyId'));

           if($request->ajax()){
                return $timeFrames;
            }

        return view('module_configuration.timeFrames.index', compact('timeFrames'));
    }

     public function store(Request $request)
    {

         $this->oTimeFrame->insertT(
            session('countryId'),
            session('companyId'),
            $request->timeName
        );

        $notification = array(
            'message'    => 'Registro Insertado Exitosamente',
            'alert-type' => 'success',
        );
         if($request->ajax()){
                return $notification;
            }
        return redirect()->route('timeFrames.index')->with($notification);
    }
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $timeFrame = $this->oTimeFrame->findById($id);
        return view('module_configuration.timeFrames.edit', compact('timeFrame'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->oTimeFrame->updateN(
            $request->timeId,
            $request->frameName
        );

        $notification = array(
            'message'    => 'Time Frame Modificado',
            'alert-type' => 'success',
        );

        return redirect()->route('timeFrames.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $timeFrame = $this->oTimeFrame->findById($id);

         if($request->ajax()){
                return $timeFrame;
            }

        return view('module_configuration.timeFrames.show', compact('timeFrame'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->oTimeFrame->deleteT($id);

        $notification = array(
            'message'    => 'Time Frame Eliminado',
            'alert-type' => 'info',
        );

        return redirect()->route('timeFrames.index')->with($notification);
    }

}
