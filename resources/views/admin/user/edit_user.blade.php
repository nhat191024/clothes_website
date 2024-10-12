@extends('admin.master')
@section('main')
    <!-- Content Wrapper -->


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Sửa người dùng</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route('admin.user.edit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Tên đăng nhập</label>
                            <input required type="text" class="form-control" id="" aria-describedby=""
                                name="username" placeholder="Nhập tên đăng nhập" value="{{ $user['username'] }}">
                            @if ($errors->has('username'))
                                <p class="text-danger small ">
                                    <i>{{ $errors->first('username') }}</i>
                                </p>
                            @endif
                            </div>
                        <div class="form-group">
                            <label for="">Tên đầy đủ</label>
                            <input type="text" class="form-control" id="" aria-describedby=""
                                name="fullname" placeholder="Nhập tên đầy đủ (Không bắt buộc)" value="{{ $user['full_name'] }}">
                                @if ($errors->has('fullname'))
                                <p class="text-danger small ">
                                    <i>{{ $errors->first('fullname') }}</i>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input required type="text" class="form-control" id="" aria-describedby=""
                                name="email" placeholder="Nhập email" value="{{ $user['email'] }}">
                            @if ($errors->has('email'))
                                <p class="text-danger small ">
                                    <i>{{ $errors->first('email') }}</i>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">SĐT</label>
                            <input required type="text" class="form-control" id="" aria-describedby=""
                                name="phone" placeholder="Nhập sđt" value="{{ $user['phone'] }}">
                            @if ($errors->has('phone'))
                                <p class="text-danger small ">
                                    <i>{{ $errors->first('phone') }}</i>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Cập nhật điểm (1 point = 1¥ sử dụng)</label>
                            <input required type="number" class="form-control" id="" aria-describedby=""
                            name="point" placeholder="" value="{{ $user['point'] }}">
                            @if ($errors->has('point'))
                                <p class="text-danger small ">
                                    <i>{{ $errors->first('point') }}</i>
                                </p>
                            @endif
                        </div>
                        <label for="">Cập nhật lại ảnh đại diện
                            @if (!empty($user['avt']))
                                (Đã phát hiện ảnh cũ của người dùng)
                            @else
                                (Hiện tại người dùng chưa có ảnh)
                            @endif
                        </label>
                        <div class="custom-file mb-3">
                            <input type="file" accept="image/*" class="custom-file-input" id="customFile"
                            name="avt">
                            <label class="custom-file-label" for="customFile">
                                @if (!empty($user['avt']))
                                    (Không bắt buộc, bỏ trống để giữ nguyên ảnh hiện tại)
                                @else
                                    (Thêm 1 file ảnh để cập nhật cho người dùng)
                                @endif
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="">Mật khẩu mới (Cấp lại mật khẩu)</label>
                            <input type="text" class="form-control" id="" aria-describedby=""
                            name="password" placeholder="(Bỏ trống để ngữ nguyên mật khẩu của người dùng)">
                            @if ($errors->has('password'))
                                <p class="text-danger small ">
                                    <i>{{ $errors->first('password') }}</i>
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <select required class="form-control" id="" aria-describedby=""
                                name="status">
                                <option value="1" {{ $user['status'] == 1 ? 'selected' : '' }}>Mở khoá (Bình thường)</option>
                                <option value="0" {{ $user['status'] == 0 ? 'selected' : '' }}>Bị khoá tài khoản</option>
                            </select>
                            @if ($errors->has('status'))
                                <p class="text-danger small ">
                                    <i>{{ $errors->first('status') }}</i>
                                </p>
                            @endif
                        </div>
                        <input type="hidden" name="id" value="{{ $id }}">
                        <button class="btn btn-warning mt-4" type="submit">Lưu thay đổi</button>
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
