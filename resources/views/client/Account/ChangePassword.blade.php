@extends('client.layout')
@section('main')
<div class="container">
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
                <input class="account-input" type="password" name="passwordCurent" placeholder="Enter current password" >
                <label>New password</label>
                <input class="account-input" type="password" name="passwordNew" placeholder="Enter new password" >
                <label>Confirm new password</label>
                <input class="account-input" type="password" name="passwordConfirm" placeholder="Confirm new password" >
                <div>
                    <br>
                    <a> <button type="submit" class="btn-acconut">Change password</button></a>
                </div>
        </div>

        </form>
    </div>
</div>
@endsection
