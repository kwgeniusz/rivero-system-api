@extends('layouts.master')

@section('content')
<div class="container">

    <div class="row">
        <dashboard-counters pref-url="./" router="statistic/clients" title="{{__('Users')}}"></dashboard-counters>
        <dashboard-counters pref-url="./" router="statistic/contractsFinished" title="{{__('contracts_finished')}}"></dashboard-counters>
        <dashboard-counters pref-url="./" router="statistic/contractsCancelled" title="{{__('contracts_cancelled')}}"></dashboard-counters><br><br>
   {{-- <dashboard-counters pref-url="/" router="statistics/contractsResidencial"></dashboard-counters>
        <dashboard-counters pref-url="/" router="clients"></dashboard-counters>
        <dashboard-counters pref-url="/" router="clients"></dashboard-counters> --}}
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{__('about_us')}}</div>

                <div class="panel-body">

                   <p>
                     {{__('about_content')}}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">   {{__('view')}}</div>

                <div class="panel-body">

                        {{__('view_content')}}
                        <img src="img/photo1.png" class="img-responsive img-circle" alt="Responsive image" >
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">   {{__('mission')}}</div>

                <div class="panel-body">
          <p>   {{__('mission_content')}}
            </p>
                <img src="img/photo2.png" class="img-responsive img-rounded" alt="Responsive image" > 
            </div>
 
            </div>
        </div>
    </div>
</div>
{{-- @php   
  echo date('Y-m-d H:i:s');
@endphp --}}
@endsection
