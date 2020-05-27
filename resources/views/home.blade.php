@extends('layouts.master')

@section('content')
<div class="container">
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
@endsection
