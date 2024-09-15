@extends('admin.master')
@section('main')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">



        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Danh sách tài khoản (Người dùng)</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <a class="btn btn-primary" href="{{ route('admin.user.show_add') }}">Thêm tài khoản</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên đăng nhập</th>
                                    <th>Tên đầy đủ</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>Điểm (Point)</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên đăng nhập</th>
                                    <th>Tên đầy đủ</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>Điểm (Point)</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($allUser as $key => $item)
                                    <tr>
                                        {{-- <td>{{ ++$key }}</td> --}}
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->full_name??'Không có' }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->point }}</td>
                                        <td>{{ $item['status'] == 1 ? 'Bình thường' : ($item['status'] == 0 ? 'Đã bị khoá' : 'Không rõ') }}</td>
                                        <td class="text-center"><a class="btn btn-warning" href="{{route('admin.user.show_edit', ['id' => $item->id])}}">Sửa</a>
                                            @if ($item->status == 1)
                                                <a class="btn btn-danger"
                                                    onclick="event.preventDefault();confirm('Xác nhận khoá tài khoản với username: {{ $item->username }}?')?location.href='{{ route('admin.user.lock', ['id' => $item->id]) }}' : ''"> Khoá </a>
                                            @else
                                                <a class="btn btn-success"
                                                    onclick="event.preventDefault();confirm('Xác nhận mở tài khoản với username: {{ $item->username }}?')?location.href='{{ route('admin.user.unlock', ['id' => $item->id]) }}' : ''"> Mở khoá </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->



    </div>
    <!-- End of Content Wrapper -->
@endsection
