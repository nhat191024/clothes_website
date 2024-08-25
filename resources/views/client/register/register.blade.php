@extends('client.layout')
@section('main')
    <div class="container">
        @if ($errors->any())
            <div class="mt-3 mb-0 alert alert-danger alert-block">
                <strong>Please check your information again according to the instructions.</strong>
            </div>
        @endif
        <div class="row my-5">
            <div class="col-md-12">
                <h3>Registration</h3>
                <hr>
                <form action="{{ route('client.register') }}" method="POST">
                    @csrf
                    <div>
                        <label class="mt-2">Username</label>
                        <input class="account-input" type="text" name="username" placeholder="Enter Username" value="{{ old('username') ?? '' }}">
                        @if ($errors->has('username'))
                            <p class="text-danger small ">
                                <i>{{ $errors->first('username') }}</i>
                            </p>
                        @endif
                    </div>
                    <div>
                        <label class="mt-2">Full Name</label>
                        <input class="account-input" type="text" name="name" placeholder="Enter name" value="{{ old('name') ?? '' }}">
                        @if ($errors->has('name'))
                            <p class="text-danger small ">
                                <i>{{ $errors->first('name') }}</i>
                            </p>
                        @endif
                    </div>
                    <div>
                        <label class="mt-2">Phone number</label>
                        <input class="account-input" type="text" name="phone" placeholder="Enter Phone number" value="{{ old('phone') ?? '' }}">
                        @if ($errors->has('phone'))
                            <p class="text-danger small ">
                                <i>{{ $errors->first('phone') }}. Must be more or equal to 10 digits</i>
                            </p>
                        @endif
                    </div>
                    <div>
                        <label class="mt-2">Email</label>
                        <input class="account-input" type="text" name="email" placeholder="Enter Email" value="{{ old('email') ?? '' }}">
                        @if ($errors->has('email'))
                            <p class="text-danger small ">
                                <i>{{ $errors->first('email') }}</i>
                            </p>
                        @endif
                    </div>
                    <div>
                        <div>
                            <label class="mt-2">Password</label>
                            <input class="account-input" type="password" name="password" placeholder="Enter password" value="{{ old('password') ?? '' }}">
                            @if ($errors->has('password'))
                                <p class="text-danger small ">
                                    <i>{{ $errors->first('password') }}</i>
                                </p>
                            @endif
                        </div>
                        <div>
                            <label class="mt-2">Confirm Password</label>
                            <input class="account-input" type="password" name="password_confirmation"
                                placeholder="Repeat your password" value="{{ old('password_confirmation') ?? '' }}">
                                @if ($errors->has('password'))
                            <p class="text-danger small ">
                                <i>This {{ $errors->first('password') }}</i>
                            </p>
                        @endif
                        </div>
                    </div>
                    <div class="mt-2">
                        <br>
                        <button type="submit" class="btn-acconut">Create Accout</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
