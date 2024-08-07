@extends('client.layout')
@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-4">
            <div class="card">
                <img class="avatar mx-auto" src="{{ url('') . '/' }}img/{{$user->avt}}" alt="Card image">
                <div class="card-body">
                    
                    <center>
                        <h4 class="">Name</h4>
                    </center>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Acconut info</li>
                        <li class="list-group-item active-list ">Change password</li>
                        <li class="list-group-item">Purchase history</li>
                      </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8 ">
            <form action="#">
                <label>Current password</label>
                <input class="account-input" type="text" name="password" placeholder="Enter current password" >
                <label>New password</label>
                <input class="account-input" type="text" name="password" placeholder="Enter new password" >
                <label>Confirm new password</label>
                <input class="account-input" type="text" name="passwordConfirm" placeholder="Confirm new password" >
                <div>
                    <br>
                    <a> <button type="submit" class="btn-acconut">Change password</button></a>
                </div>
        </div>

        </form>
    </div>
</div>
@endsection
