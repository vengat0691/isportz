
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
        <div class="card-header text-center"><b>{{ __('Create Post') }}</b></div>
            <div class="card-body">
    <form method="post" action="{{url('listPost')}}" enctype="multipart/form-data" name="form" id="form">

      @csrf

      @php
    $user_type = Auth::user()->type;
      @endphp

    <div class="form-group row">
        <label for="title" class="col-md-4 col-form-label  text-md-left">{{ __('Title') }}</label>

        <div class="col-md-8">
            <input id="title" name="title" type="text" class="form-control" value="{{ old('title') }}" maxlength="400" required >

        </div>
    </div>

    <div class="form-group row">
        <label for="description" class="col-md-4 col-form-label  text-md-left">{{ __('Description') }}</label>

        <div class="col-md-8">
            <textarea name="description" id="description" class="form-control" maxlength="1000"></textarea>
        </div>
    </div>


    <div class="form-group row">
        <label for="image" class="col-md-4 col-form-label">{{ __('Image') }}</label>
        <div class="col-md-4">
            <!-- <input type="file" name="image" id="image" onchange="imagePreview(this);" /> -->
            <input name="image" type="file" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
        </div>
        <div class="col-md-4" align="right">
            <!-- <img id="image_preview" width="100px" height="60px" src="{{URL::to('/')}}/img/no-image.jpg" /> -->
            <img id="output" src="{{URL::to('/')}}/img/no-image.jpg" width="100" height="100">
        </div>
        <!-- <script type="text/javascript">
        function imagePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        </script> -->
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
