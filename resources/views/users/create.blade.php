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
                <div class="panel-heading">Create</div>

                <div class="panel-body">
                  <form class="" action="/users/store" method="POST">
                    <input type="text" name="username" >
                    <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>" >
                    <input type="submit" name="" value="Send">
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
