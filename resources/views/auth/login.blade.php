@extends('layouts.app2')
@section('content')
<div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="{{ url('/authenticate') }}" method="post">
    {!! csrf_field() !!}
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email" value="{{old('email')}}" />
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" />
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      {{-- <div class="form-group has-feedback">
        <select class="form-control valdation_select" name="company" id="nn" >
        
        @foreach($companyData as $data)
          <option value="{{$data->company_id}}" {{ isset($data->default) && $data->default == 'Yes' ? 'selected':"" }} >{{$data->name}}</option>
        @endforeach
        </select>
      </div> --}}
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
    
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    
    <!-- /.social-auth-links -->

    <a href="{{ url('/password/reset') }}">I forgot my password</a><br>
    

  </div>
@endsection
