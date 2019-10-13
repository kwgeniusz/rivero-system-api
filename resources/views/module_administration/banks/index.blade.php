@extends('layouts.master')

@section('content')
<span class="logo-lg "><h3><b> LISTA DE BANCOS </b></h3></span>
<div class="text-center">

    <div class="panel-body">

    <div class="row ">
      <div class="col-xs-12">
      <form class="form-inline" action="{{Route('banks.store')}}" method="POST">
      {{csrf_field()}}

         <div class="form-group">
           <label for="bankName">NOMBRE DEL BANCO</label>
           <input type="text" class="form-control" name="bankName" id="bankName" required>
         </div>

    {{--         <div class="form-group">
            <label for="countryId">{{__('country')}}</label>
            <select class="form-control" name="countryId" id="countryId">
                @foreach($countrys as $country)
                      <option value="{{$country->countryId}}" > {{$country->countryName}} </option>
                @endforeach
            </select>
          </div> --}}
           <button type="submit" class="btn btn-success">
                <span class="fa fa-plus" aria-hidden="true"></span>   {{__('add')}}
            </button>
        </form>
      </div>
    </div>

    <br>
    <hr>

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>ID</th>
                 <th> BANCOS</th>
                 <th> SALDO ACTUAL</th>
                 <th>{{__('actions')}}</th>
                </tr>
            </thead>
                <tbody>
                @foreach($banks as $bank)
                <tr>
                   <td>{{$bank->bankId}}</td>
                   <td>{{$bank->bankName}}</td>
                   <td>{{$bank->saldoActual}}</td>
                   <td><a href="{{route('banks.edit', ['id' => $bank->bankId])}}" class="btn btn-primary">
                    <span class="fa fa-edit" aria-hidden="true"></span> {{__('edit')}}
                      </a>
                       <a href="{{route('banks.show', ['id' => $bank->bankId])}}" class="btn btn-danger">
                     <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                       </a>
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>

                 <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
        </div>
    </div>

</div>
</div>

@endsection
