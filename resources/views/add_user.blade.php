
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
    @if(session('success'))
        <div class="alert alert-success  text-center">
        {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger  text-center">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-header text-center"><b>{{ __('Add User') }}</b></div>
            <div class="card-body">
    <form method="post" action="{{url('list')}}" enctype="multipart/form-data" name="form" id="form">

      @csrf

      @php
    $user_type = Auth::user()->type;
      @endphp
    <div class="form-group row">
        <label for="create" class="col-md-4 col-form-label text-md-left">{{ __('Create') }}</label>
        <div class="col-md-8">
            <select name="type" id="type" class="form-control" >
                <option value="U" >User</option>
                @if($user_type=='A')
                <option value="A" >Admin</option>
                @endif
            </select>
       </div>
    </div>

    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-left">{{ __('Name') }}</label>
        <div class="col-md-8">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" maxlength="35" required autocomplete="name" autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-left">{{ __('E-Mail Address') }}</label>

        <div class="col-md-8">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-left">{{ __('Password') }}</label>

        <div class="col-md-8">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password-confirm" class="col-md-4 col-form-label text-md-left">{{ __('Confirm Password') }}</label>

        <div class="col-md-8">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>
    </div>

    <div  align="right" >
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>

    </form>

   </div>
            </div>
        </div>
    </div>
</div>
@endsection
