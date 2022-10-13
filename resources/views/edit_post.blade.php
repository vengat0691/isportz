
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
                <div class="card-header text-center"><b>{{ __('Edit Post') }}</b></div>

                <div class="card-body">
      <form method="post" action="{{action('PostController@update', $id)}}" enctype="multipart/form-data" name="form" id="form">
      @csrf
      <input name="_method" type="hidden" value="PATCH">

        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label  text-md-left">{{ __('Title') }}</label>

            <div class="col-md-8">
                <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{$post->title}}" maxlength="400" required >
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="description" class="col-md-4 col-form-label  text-md-left">{{ __('Description') }}</label>

            <div class="col-md-8">
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" maxlength="1000">{{$post->description}}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="image" class="col-md-4 col-form-label">{{ __('Image') }}</label>
            <div class="col-md-4"> 
    <input name="image" type="file" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
            </div>
            <div class="col-md-4" align="right">
                @if($post['file']!='')
                <img id="output" src="{{URL::to('/')}}/img/{{$post['file']}}" width="100" height="100">
                @else
                <img id="output" src="{{URL::to('/')}}/img/no-image.jpg" width="100" height="100">
                @endif
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
