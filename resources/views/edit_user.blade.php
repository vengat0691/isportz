
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
                <div class="card-header text-center"><b>{{ __('Edit User') }}</b></div>

                <div class="card-body">
      <form method="post" action="{{action('OperationsController@update', $id)}}" enctype="multipart/form-data" name="form" id="form">
      @csrf
      <input name="_method" type="hidden" value="PATCH">

      <div class="form-group row">
        <label for="create" class="col-md-4 col-form-label text-md-left">{{ __('Create') }}</label>

        <div class="col-md-8">

        <select name="type" id="type" class="form-control" >
            <option value="">Select</option>
            <option value="A" {{$user->type == 'A' ? 'selected' : '' }} >Admin</option>
            <option value="U" {{$user->type == 'U' ? 'selected' : '' }} >User</option>
            </select>
       </div>
       </div>


        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-left">{{ __('Name') }}</label>

            <div class="col-md-8">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$user->name}}" maxlength="400" required >

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
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}" required autocomplete="email">

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
