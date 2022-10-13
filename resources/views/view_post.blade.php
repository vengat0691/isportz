@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="d-none d-md-block">&nbsp;</div>
          @if (\Session::has('success'))
            <div class="alert alert-success  text-center">
              <p>{{ \Session::get('success') }}</p>
            </div><br />
          @endif
          @if (\Session::has('error'))
            <div class="alert alert-danger  text-center">
              <p>{{ \Session::get('error') }}</p>
            </div><br />
          @endif
          @if($count==0)
            <div class="text-center text-white"><h3>Sorry post doesn't exist</h3></div>
            <div>&nbsp;</div>
          @else
          <div class="card">
            <div class="card-body">
            @foreach ($list_post as $value)
                <h3 class="text-center">{{$value['title']}}</h3>
                <div>&nbsp;</div>
                <img class="img-fluid" src="{{URL::to('/')}}/img/{{$value['file']}}">
                <div>&nbsp;</div>
                <div class="lead">{{$value['description']}}</div>
                <div>&nbsp;</div>
                @if (Auth::user())
                    @if (Auth::user()->type == 'A')
                    <form  action="{{action('PostController@approvePost')}}" method="post">
                        @csrf
                        <input name="id" type="hidden" value="{{$value['id']}}">
                        @if ($value['approve_status'] == 0)
                        <h5 class="text-center"><button class="btn btn-success" type="submit">Approve</button></h5>
                        @else
                        <h5 class="text-center"><button class="btn btn-primary" type="submit" disabled>Approved</button></h5>
                        @endif
                    </form>
                    @endif
                @endif
            @endforeach
          @endif


</div>
</div>
</div>
</div>
</div>
 @endsection
