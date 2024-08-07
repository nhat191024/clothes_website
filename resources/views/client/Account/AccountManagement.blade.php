@extends('client.layout')
@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-4">
                <div class="card">
                    <img class="avatar mx-auto" src="{{ url('') . '/' }}img/{{$user->avt}}" alt="Card image">
                    <div class="card-body">
                        <center>
                            <h4 class="">{{$user->username}}</h4>
                            <br>
                        </center>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item active-list">Acconut info</li>
                            <li class="list-group-item ">Change password</li>
                            <li class="list-group-item">Purchase history</li>
                          </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8 ">
                <form action="#">
                    <label>Name</label>
                    <input class="account-input" type="text" name="name" placeholder="Enter name" value="">
                    <label>Email</label>
                    <input class="account-input" type="text" name="email" placeholder="Enter Email" value="{{$user->email}}">
                    <label>Address</label>
                    <input class="account-input" type="text" name="addres" placeholder="Enter Address" value="{{$user->address}}">
                    <label>Phone</label>
                    <input class="account-input" type="number" name="phone" placeholder="Enter Phonenumber" value="{{$user->phone}}">
                    <div>
                        <br>
                        <a> <button type="submit" class="btn-acconut">Save</button></a>
                    </div>
            </div>

            </form>
        </div>
    </div>
@endsection
