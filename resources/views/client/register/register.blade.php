@extends('client.layout')
@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-12">
                <form action="{{ route('client.register') }}" method="POST">
                    @csrf
                    <div>
                        <label class="mt-2">Username</label>
                        <input class="account-input" type="text" name="username" placeholder="Enter Username">
                        @if ($errors->has('username'))
                            <p class="text-danger small ">
                                <i>{{ $errors->first('username') }}</i>
                            </p>
                        @endif
                    </div>
                    <div>
                        <label class="mt-2">Full Name</label>
                        <input class="account-input" type="text" name="name" placeholder="Enter name">
                        @if ($errors->has('name'))
                            <p class="text-danger small ">
                                <i>{{ $errors->first('name') }}</i>
                            </p>
                        @endif                        
                    </div>
                    <div>
                        <label class="mt-2">Phone number</label>
                        <input class="account-input" type="text" name="phone" placeholder="Enter Phone number">
                        @if ($errors->has('phone'))
                            <p class="text-danger small ">
                                <i>{{ $errors->first('phone') }}</i>
                            </p>
                        @endif                        
                    </div>
                    <div>
                        <label class="mt-2">Email</label>
                        <input class="account-input" type="text" name="email" placeholder="Enter Email">
                        @if ($errors->has('email'))
                            <p class="text-danger small ">
                                <i>{{ $errors->first('email') }}</i>
                            </p>
                        @endif
                    </div>
                    <div>
                        <div>
                            <label class="mt-2">Password</label>
                            <input class="account-input" type="password" name="password" placeholder="Enter password">
                            @if ($errors->has('password'))
                            <p class="text-danger small ">
                                <i>{{ $errors->first('password') }}</i>
                            </p>
                        @endif                            
                        </div>
                        <div>
                            <label class="mt-2">Confirm Password</label>
                            <input class="account-input" type="password" name="password_confirmation"
                                placeholder="Repeat your password">
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
