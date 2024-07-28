@extends('client.layout')
@section('main')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-4">
                <div class="card">
                    <img class="avatar mx-auto" src="{{ url('') . '/' }}img/logo.webp" alt="Card image">
                    <div class="card-body">
                        <center>
                            <h4 class="">Name</h4>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-md-8 ">
                <form action="#">
                    <label>Name</label>
                    <input class="account-input" type="text" name="" placeholder="Enter name">
                    <label>Email</label>
                    <input class="account-input" type="text" name="" placeholder="Enter Email">
                    <label>Address</label>
                    <input class="account-input" type="text" name="" placeholder="Enter Address">
                    <label>Phone</label>
                    <input class="account-input" type="number" name="" placeholder="Enter Phonenumber">
                    <div class="row my-2">
                        <h5>Change Password</h5>
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
            </div>
            <div>
                <br>
                <a> <button type="submit" class="btn-acconut">Save</button></a>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
