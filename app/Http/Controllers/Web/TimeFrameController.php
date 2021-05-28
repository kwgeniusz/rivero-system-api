<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\TimeFrame;
use Illuminate\Http\Request;

class TimeFrameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->oTimeFrame = new TimeFrame();
    }

    public function index(Request $request)
    {
        $timeframes = $this->oTimeFrame->getAllByCompany(session('companyId'));

        if ($request->ajax()) {
            return $timeframes;
        }

        return view('module_contracts.proposals.timeframes.index')->with(['timeframes' => $timeframes]);
    }

    public function store(Request $request)
    {
        $timeframe = new TimeFrame();

        $timeframe->timeName = $request->timeName;
        $timeframe->daysRepresented = $request->daysRepresented;
        $timeframe->countryId = session('countryId');
        $timeframe->companyId = session('companyId');

        $timeframe->save();

        return $timeframe;
    }

    public function update(Request $request, $id)
    {
        $timeframe = TimeFrame::findOrFail($id);

        $timeframe->timeName = $request->timeName;
        $timeframe->daysRepresented = $request->daysRepresented;

        $timeframe->save();

        return $timeframe;
    }

    public function destroy($id)
    {
        $timeframe = TimeFrame::findOrFail($id);
        $timeframe->delete();
    }
}
