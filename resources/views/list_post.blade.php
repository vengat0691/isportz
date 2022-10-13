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
          <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <div class="row">
                        <div class="col-md-8">{{ __('List Post') }}</div>
                        <div class="col-md-4 text-right"><span class="badge badge-dark">{{$count}}</span></div>
                    </div>
                </h4>
            </div>
            <div class="card-body">
              <div  align="right">
                <a href="{{action('PostController@create')}}"> <i class="fa fa-plus fa-2x text-success"></i></a>
              </div>
    @php
      $user_type = Auth::user()->type;
      $user_id = Auth::user()->id;
    @endphp
          @if($count==0)
            <div class="text-center text-danger">Sorry no data exist</div>
            <div>&nbsp;</div>
          @else
  <div class="table-responsive">
    <table class="table table-striped">
    <thead>
      <tr>
        <th class="text-left">S.no</th>
        <th class="text-left">Name</th>
        <th class="text-left">Title</th>
        <th class="text-center">Edit</th>
        <th class="text-center">Delete</th>
        @if($user_type=='A')
        <th class="text-center">Approve</th>
        @endif
        @if($user_type=='U')
        <th class="text-center">Status</th>
        @endif
      </tr>
    </thead>
    <tbody>
            @php $i=0; @endphp
        @foreach ($list_post as $value)
            @php  $i++; @endphp
      <tr>
            <td class="text-left"><label class="col-form-label">{{$i}}</label></td>
            <td class="text-left"><label class="col-form-label">{{$value['userName']}}</label></td>
            <td class="text-left"><label class="col-form-label">{{$value['title']}}</label></td>
            @if(($user_type=='A') || ($user_type=='U')&&($user_id==$value['user_id']))
            <td class="text-center"><a class="btn btn-link" href="{{action('PostController@edit', $value['id'])}}"><i class="fa fa-edit text-primary"></i></a></td>

            <td class="text-center">
                <form onclick="return confirm('Do you really want to delete?')" action="{{action('PostController@destroy', $value['id'])}}" method="post">
                @csrf
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-link" type="submit"><i class="fa fa-trash text-danger"></i></button>
                </form>
            </td>
            @else
            <td class="text-center">-</td>
            <td class="text-center">-</td>
            @endif

            @if($user_type=='A')
                @if($value['approve_status']==0)
                <td class="text-center">
                    <form onclick="return confirm('Do you really want to approve?')" action="{{action('PostController@approvePost', $value['id'])}}" method="post">
                    @csrf
                    <input name="_method" type="hidden" value="POST">
                    <input name="id" type="hidden" value="{{$value['id']}}">
                    <button class="btn btn-link" type="submit"><i class="fa fa-check text-success"></i></button>
                    </form>
                </td>
                @else
                <td class="text-center">Approved</td>
                @endif
            @endif

            @if($user_type=='U')
                @if($value['approve_status']==1)
                    <td class="text-center">Approved</td>
                @else
                    <td class="text-center">Not Approved</td>
                @endif
            @endif
            <td>&nbsp;</td>
      </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endif
</div>
</div>
</div>
</div>
</div>
 @endsection
