@extends('admin.layouts.app')

@section('content')
<!-- Css Header Resources -->
@section('content_css')

@endsection

<!-- Start Card Row -->
<div class="card shadow mb-4">
  <div class="card-header  d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">Test Stream</h6>
  </div>
  <div class="card-body">
    <h2>{{$this->auth->get('Username')}}</h2>
  </div>
</div>
<!-- End Card Row -->
<!-- JS Footer Resources -->
@section('content_js')
  {{-- <script src="{{DASHBOARD_VENDOR}}getUserMedia.min.js" type="text/javascript"></script> --}}

<script type="text/javascript">


</script>

@endsection

@endsection
