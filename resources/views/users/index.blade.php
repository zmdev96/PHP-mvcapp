@extends('layouts.app')

@section('content')
  <!-- JS Footer Resources -->
@section('content_js')
<script  src='@asset("img/resource.jpg")'></script>


@endsection
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>

                <div class="panel-body">
                    You are logged in! {{$title}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
