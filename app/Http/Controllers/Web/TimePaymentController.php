<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\TimePayment;
use Illuminate\Http\Request;

class TimePaymentController extends Controller
{
    private $oTimePayment;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oTimePayment = new TimePayment();
    }

    public function index(Request $request)
    {
        $timePayment = $this->oTimePayment->getAllByCompany(session('companyId'));

        if ($request->ajax()) {
            return $timePayment;
        }

        return view('module_configuration.vue-timepayments.index', compact('timePayment'));
    }

    public function store(Request $request)
    {
        $timepayment = new TimePayment();

        $timepayment->timeName = $request->timeName;
        $timepayment->countryId = session('countryId');
        $timepayment->companyId = session('companyId');

        $timepayment->save();

        return $timepayment;
    }

    public function update(Request $request, $id)
    {
        $timepayment = TimePayment::findOrFail($id);

        $timepayment->timeName = $request->timeName;

        $timepayment->save();

        return $timepayment;
    }

    public function destroy($id)
    {
        $timepayment = TimePayment::findOrFail($id);
        $timepayment->delete();
    }
}
