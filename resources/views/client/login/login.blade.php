@extends('client.layout')
@section('main')
    <div class="card mt-5 mb-5 contact__form offset-md-4 col-12 col-md-4">
        @if ($message = Session::get('message'))
            <div class="mt-3 mb-0 alert alert-danger alert-block">
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <h3 class="mt-3 mb-3">Login</h3>
        <form action="{{ route('client.login') }}" method="POST">
            @csrf
            <input type="text" name="username" placeholder="Phone. email, username ...">
            @if ($errors->has('username'))
                <p class="text-danger small text-center ">
                    <i>{{ $errors->first('username') }}</i>
                </p>
            @endif
            <input type="password" name="password" placeholder="Password">
            @if ($errors->has('password'))
                <p class="text-danger small text-center ">
                    <i>{{ $errors->first('password') }}</i>
                </p>
            @endif
            <button type="submit" class="site-btn mb-3">Login</button>
        </form>
    </div>
@endsection
