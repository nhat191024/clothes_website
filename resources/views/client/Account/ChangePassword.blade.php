@extends('client.layout')
@section('main')
<div class="container">
    @if ($message = Session::get('message'))
            <div class="mt-3 mb-0 alert alert-success alert-block">
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($error = Session::get('error'))
            <div class="mt-3 mb-0 alert alert-danger alert-block">
                <strong>{{ $error }}</strong>
            </div>
        @endif
    <div class="row my-5">
        <div class="col-md-4">
            <div class="card">
                <img class="avatar mx-auto mt-3" src="{{ url('') . '/' }}img/user/{{$user->avt}}" alt="Card image">
                <div class="card-body">
                    <center>
                        <h4 class="">{{$user->full_name}}</h4>
                    </center>
                    <ul class="list-group list-group-flush">
                            <a href="{{route('client.account.index')}}"><li class="list-group-item ">Account info</li></a>
                            <a href="{{route('client.account.changepassword')}}"><li class="list-group-item active-list">Change password</li></a>
                        <li class="list-group-item">Purchase history</li>
                      </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8 ">
            <form action="{{route('client.account.changepassword')}}" method="POST">
             @csrf
                <label>Current password</label>
                <input class="account-input" type="password" name="passwordCurrent" placeholder="Enter current password" >
                @if ($errors->has('passwordCurrent'))
                    <p class="text-danger small ">
                        <i>{{ $errors->first('passwordCurrent') }}</i>
                    </p>
                @endif
                <label>New password</label>
                <input class="account-input" type="password" name="passwordNew" placeholder="Enter new password" >
                @if ($errors->has('passwordNew'))
                    <p class="text-danger small ">
                        <i>{{ $errors->first('passwordNew') }}</i>
                    </p>
                @endif
                <label>Confirm new password</label>
                <input class="account-input" type="password" name="passwordConfirm" placeholder="Confirm new password" >
                @if ($errors->has('passwordConfirm'))
                    <p class="text-danger small ">
                        <i>{{ $errors->first('passwordConfirm') }}</i>
                    </p>
                @endif
                <div>
                    <br>
                    <a> <button type="submit" class="btn-acconut">Change password</button></a>
                </div>
        </div>

        </form>
    </div>
</div>
@endsection
