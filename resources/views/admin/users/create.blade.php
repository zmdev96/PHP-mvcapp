@extends('admin.layouts.app')

@section('content')
<!-- Css Header Resources -->
@section('content_css')


@endsection

<!-- Start Card Row -->
<div class="card shadow mb-4">
  <div class="card-header  d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">Users Create</h6>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-9">
        <div class="form-content">
          <form action="/app-admin/users/store" method="POST" enctype="multipart/form-data" >
            <div class="form-row">
              <div class="form-group col-md-3{{ $this->errors->hasError('username') ? ' has-error' : '' }}">
                <label for="inputUsername">Username</label>
                <input type="text" name="username" class="form-control" id="inputUsername" value="{{$this->old('username')}}">
                @if ($this->errors->hasError('username'))
                <span class="help-block">
                  <small>{{ $this->errors->get('username') }}</small>
                </span>
                @endif
              </div>
              <div class="form-group col-md-3{{ $this->errors->hasError('firstname') ? ' has-error' : '' }}">
                <label for="inputFirst_Name">Firstname</label>
                <input type="text" name="firstname" class="form-control" id="inputFirst_Name" value="{{$this->old('firstname')}}">
                @if ($this->errors->hasError('firstname'))
                <span class="help-block">
                  <small>{{ $this->errors->get('firstname') }}</small>
                </span>
                @endif
              </div>
              <div class="form-group col-md-3{{ $this->errors->hasError('lastname') ? ' has-error' : '' }}">
                <label for="inputFirst_Name">Lastname</label>
                <input type="text" name="lastname" class="form-control" id="inputFirst_Name" value="{{$this->old('lastname')}}">
                @if ($this->errors->hasError('lastname'))
                <span class="help-block">
                  <small>{{ $this->errors->get('lastname') }}</small>
                </span>
                @endif
              </div>
              <div class="form-group col-md-3{{ $this->errors->hasError('image') ? ' has-error' : '' }}">
                <label for="inputImage">Image</label>
                <input type="file" name="image" class="form-control" id="inputImage">
                @if ($this->errors->hasError('image'))
                <span class="help-block">
                  <small>{{ $this->errors->get('image') }}</small>
                </span>
                @endif
              </div>
            </div>
            {!!$this->csrf_token()!!}
            <button type="submit" name="submit" class="btn btn-success"><i style="margin-right:5px;" class="fas fa-plus"></i>Create</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Card Row -->
  <!-- JS Footer Resources -->
  @section('content_js')
  <script type="text/javascript">
    $('#my_form').submit(function(e) {
      e.preventDefault();
      var form_data = $(this).serialize();
      $.ajax({
        url: "http://mvcapp.work/app-admin/users/store",
        method: "post",
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(data) {
          window.location.href = 'http://mvcapp.work/app-admin/users';
        },
        error: function(data_error, exception) {
          if (exception == 'error') {
            console.log(data_error.responseJSON);

          }
        }
      });
    });
  </script>
  @endsection

  @endsection
