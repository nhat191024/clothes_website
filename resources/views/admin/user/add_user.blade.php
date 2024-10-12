@extends('admin.master')
@section('main')
    <!-- Content Wrapper -->


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thêm người dùng</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route('admin.user.add') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Tên đăng nhập</label>
                            <input required type="text" class="form-control" id="" aria-describedby=""
                                name="username" placeholder="Nhập tên đăng nhập" value="{{ old('username') ?? '' }}">
                            @if ($errors->has('username'))
                                <p class="text-danger small ">
                                    <i>{{ $errors->first('username') }}</i>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Mật khẩu đăng nhập</label>
                            <input type="text" class="form-control" id="" aria-describedby=""
                            name="password" placeholder="Nhập mật khẩu người dùng" value="{{ old('password') ?? '' }}">
                            @if ($errors->has('password'))
                                <p class="text-danger small ">
                                    <i>{{ $errors->first('password') }}</i>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Tên đầy đủ</label>
                            <input type="text" class="form-control" id="" aria-describedby=""
                                name="fullname" placeholder="Nhập tên đầy đủ" value="{{ old('fullname') ?? '' }}">
                            @if ($errors->has('fullname'))
                                <p class="text-danger small ">
                                    <i>{{ $errors->first('fullname') }}</i>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" id="" aria-describedby=""
                                name="email" placeholder="Nhập email" value="{{ old('email') ?? '' }}">
                            @if ($errors->has('email'))
                                <p class="text-danger small ">
                                    <i>{{ $errors->first('email') }}</i>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">SĐT</label>
                            <input type="text" class="form-control" id="" aria-describedby=""
                                name="phone" placeholder="Nhập sđt" value="{{ old('phone') ?? '' }}">
                            @if ($errors->has('phone'))
                                <p class="text-danger small ">
                                    <i>{{ $errors->first('phone') }}</i>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <select required class="form-control" id="" aria-describedby=""
                                name="status">
                                <option value="1">Mở khoá (Bình thường)</option>
                                <option value="0">Bị khoá tài khoản</option>
                            </select>
                        </div>
                        <button class="btn btn-success mt-4" type="submit">Tạo người dùng</button>
                    </form>

                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->



    <!-- End of Content Wrapper -->
    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
