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
        @if ($errors->any())
            <div class="mt-3 mb-0 alert alert-danger alert-block">
                <strong>Your updated info has some problems, please consider checking.</strong>
            </div>
        @endif
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
                <form action="{{ route('client.account.index') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="customFile">Profile image</label>
                        <div class="custom-file">
                            <input type="file" accept="image/*" class="custom-file-input" id="customFile"
                                name="avt">
                            <label class="custom-file-label" for="customFile">
                                {{ isset($user->avt) ? 'Choose a new image' : 'Select to update image' }}
                            </label>
                        </div>
                    </div>
                    <label>Name</label>
                    <input class="account-input" type="text" name="name" placeholder="Enter name" value="{{ $user->full_name }}">
                    @if ($errors->has('name'))
                        <p class="text-danger small ">
                            <i>{{ $errors->first('name') }}</i>
                        </p>
                    @endif
                    <label>Email</label>
                    <input class="account-input" type="text" name="email" placeholder="Enter Email" value="{{ $user->email }}">
                    @if ($errors->has('email'))
                        <p class="text-danger small ">
                            <i>{{ $errors->first('email') }}</i>
                        </p>
                    @endif
                    <label>Phone</label>
                    <input class="account-input" type="tel" name="phone" placeholder="Enter Phonenumber" value="{{ $user->phone }}">
                    @if ($errors->has('phone'))
                        <p class="text-danger small ">
                            <i>{{ $errors->first('phone') }}</i>
                        </p>
                    @endif
                    <label>Prefecture</label>
                    <input class="account-input" type="text" name="prefecture" placeholder="Enter Prefecture" value="{{ $user->prefecture }}">
                    <label>City</label>
                    <input class="account-input" type="text" name="city" placeholder="Enter City" value="{{ $user->city }}">
                    <label>Address</label>
                    <input class="account-input" type="text" name="address" placeholder="Enter Address" value="{{ $user->address }}">
                    <label>Building Name</label>
                    <input class="account-input" type="text" name="building_name" placeholder="Enter Building Name" value="{{ $user->building_name }}">
                    <div>
                        <br>
                        <button type="submit" class="btn-acconut">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ url('') . '/' }}vendor/jquery/jquery.min.js"></script>
    <script>
        $(".custom-file-input").on("change", function() {
                $(this).siblings(".custom-file-label").addClass("selected").html($(this).val().split("\\")
                    .pop());
            });
    </script>
@endsection
