@extends('layouts.master')

@section('content')
<div class="col-xs-7 col-xs-offset-2">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="text-center">
                <b>
                    {{__('contract_search_by_status')}}
                </b>
            </h3>
        </div>
        <div class="panel-body">
            <form action="{{Route('contracts.resultStatus')}}" class="form" method="POST">
                {{csrf_field()}}
                <div class="col-xs-7 col-xs-offset-2">
                    <div class="form-group">
                        <label for="contractStatus">
                            {{__('choose_a_status')}}
                        </label>
                        <select class="form-control" id="contractStatus" name="contractStatus">
                            <option value="1">
                                {{__('vacancies')}}
                            </option>
                            <option value="2">
                                {{__('initiates')}}
                            </option>
                            <option value="3">
                                {{__('finished')}}
                            </option>
                            <option value="4">
                                {{__('suspended')}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 text-center">
                    <button class="btn btn-primary" type="submit">
                        <span aria-hidden="true" class="fa fa-search">
                        </span>
                        {{__('search')}}
                    </button>
                    <a class="btn btn-warning" href="{{route('home')}}">
                        <span aria-hidden="true" class="fa fa-hand-point-left">
                        </span>
                        {{__('return')}}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
