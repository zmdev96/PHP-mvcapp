@extends('auth.layouts')

@section('content')

  <form class="" action="/auth/login/submit" method="post">
    {!!$this->csrf_token()!!}
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" value="Login">
  </form>

@endsection
