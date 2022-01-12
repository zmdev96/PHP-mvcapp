@extends('admin.layouts.app')

@section('content')
<!-- Css Header Resources -->
@section('content_css')


@endsection

<!-- Start Card Row -->
<div class="card shadow mb-4">
  <div class="card-header  d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">Users Edit</h6>
  </div>

  <div class="card-body">
    <div class="row">
          <div class="col-md-9">
            <div class="form-content">
              <form action="/app-admin/users/update" method="POST">
                <div class="form-row">
                  <div class="form-group col-md-3{{ $this->messenger->hasError('username') ? ' has-error' : '' }}">
                    <label for="inputUsername">Username</label>
                    <input type="text" name="username" class="form-control" id="inputUsername" value="{{$this->old('username', $user)}}">
                    @if ($this->messenger->hasError('username'))
                        <span class="help-block">
                            <small>{{ $this->messenger->error('username') }}</small>
                        </span>
                    @endif
                  </div>
                  <div class="form-group col-md-3{{ $this->messenger->hasError('firstname') ? ' has-error' : '' }}">
                    <label for="inputFirst_Name">Firstname</label>
                    <input type="text" name="firstname" class="form-control" id="inputFirst_Name" value="{{$this->old('firstname', $user)}}">
                    @if ($this->messenger->hasError('firstname'))
                        <span class="help-block">
                            <small>{{ $this->messenger->error('firstname') }}</small>
                        </span>
                    @endif
                  </div>
                  <div class="form-group col-md-3{{ $this->messenger->hasError('lastname') ? ' has-error' : '' }}">
                    <label for="inputFirst_Name">Lastname</label>
                    <input type="text" name="lastname" class="form-control" id="inputFirst_Name" value="{{$this->old('lastname', $user)}}">
                    @if ($this->messenger->hasError('lastname'))
                        <span class="help-block">
                            <small>{{ $this->messenger->error('lastname') }}</small>
                        </span>
                    @endif
                  </div>
                </div>
                {!!$this->csrf_token($user->UserId)!!}
                <button type="submit" name="submit" class="btn btn-success"><i style="margin-right:5px;" class="fas fa-plus"></i>Update</button>
              </form>
            </div>
          </div>
  </div>
</div>
<!-- End Card Row -->
<!-- JS Footer Resources -->
@section('content_js')

@endsection

@endsection
