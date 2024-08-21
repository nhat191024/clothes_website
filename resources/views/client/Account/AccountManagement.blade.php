@extends('client.layout')
@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-4">
                <div class="card">
                    <img class="avatar mx-auto mt-3" src="{{ url('img/user/' . (Auth::user() && file_exists(public_path('img/user/' . Auth::user()->avt)) ? Auth::user()->avt : 'avt-default.png')) }}" alt="Card image">
                    <div class="card-body">
                        <center>
                            <h4 class="">{{$user->full_name}}</h4>
                            <br>
                        </center>
                        <ul class="list-group list-group-flush">
                            <a href="{{route('client.account.index')}}"><li class="list-group-item active-list">Account info</li></a>
                            <a href="{{route('client.account.changepassword')}}"><li class="list-group-item">Change password</li></a>
                            <li class="list-group-item">Purchase history</li>
                          </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <form action="{{ route('client.account.index') }}" method="POST">
                    @csrf
                    <label>Name</label>
                    <input class="account-input" type="text" name="name" placeholder="Enter name" value="{{ $user->full_name }}">
                    <label>Email</label>
                    <input class="account-input" type="text" name="email" placeholder="Enter Email" value="{{ $user->email }}">
                    <label>Address</label>
                    <input class="account-input" type="text" name="address" placeholder="Enter Address" value="{{ $user->address }}">
                    <label>Phone</label>
                    <input class="account-input" type="tel" name="phone" placeholder="Enter Phonenumber" value="{{ $user->phone }}">
                    <div>
                        <br>
                        <button type="submit" class="btn-acconut">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
