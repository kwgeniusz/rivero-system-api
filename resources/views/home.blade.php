@extends('layouts.master')

@section('content')
<div class="container">

    <div class="row">
        <client-counter pref-url="./" router="statistic/clients" title="{{__('clients')}}"></client-counter>
        <contract-counter pref-url="./" router="statistic/contractsFinished" title="{{__('contracts_finished')}}"></contract-counter>
        <invoice-counter pref-url="./" router="statistic/invoicesPaid" title="{{__('paid_invoices')}}"></invoice-counter>
    </div>

    <div class="row">
          <div class="col-lg-3 col-6">
        <h4>Contratos Por Uso del Proyecto</h4>      
      <contract-chart class="chart" pref-url="./" router="statistic/contracts-by-project-use"/>
</div> 
    <div class="col-lg-6 col-6">
        <h4>Contractos Por Estado</h4>
      <contract-status-chart class="chart" pref-url="./" router="statistic/contracts-by-status"/>
</div> 
    </div>

    <div class="row">

<!-- The next code is for tabbing all text about Corporate Identity
    <div class="col-12 col-sm-6 col-lg-4">
            <div class="card card-primary card-outline card-outline-tabs">
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">{{__('about_us')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">{{__('view')}}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">{{__('mission')}}</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                  {{__('about_content')}}                  
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                  {{__('view_content')}}
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
                  {{__('mission_content')}}
                  </div>
                </div>
              </div> -->
    
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
        <div class="col-md-3">
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
