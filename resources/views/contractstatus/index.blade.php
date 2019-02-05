@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-success col-xs-7">
    <div class="panel-heading"> <h3>{{__('contract_search_by_status')}}</h3></div>
    <div class="panel-body">

      <form class="form" action="{{Route('contracts.resultStatus')}}" method="POST">
        {{csrf_field()}}

            <div class="col-xs-12">
               <div class="form-group">
              <label for="contractStatus">{{__('choose_a_status')}}</label>
              <select class="form-control" name="contractStatus" id="contractStatus">
                    <option value="1" > {{__('vacancies')}} </option>
                    <option value="2" > {{__('initiates')}} </option>
                    <option value="3" > {{__('finished')}} </option>
                    <option value="4" > {{__('suspended')}} </option>
              </select>
              </div>
            </div>

            <div class="col-xs-12 text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-search" aria-hidden="true"></span>  {{__('search')}}
              </button>
              <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>
            </div>
          </form>


    </div>

  </div>

@endsection
