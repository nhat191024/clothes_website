@extends('admin.master')
@section('main')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Danh sách màu</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <a class="btn btn-primary" href="{{ route('admin.color.show_add') }}">Thêm màu</a>
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
                                    <th>Tên màu</th>
                                    <th>Mã màu</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên màu</th>
                                    <th>Mã màu</th>
                                    <th>Chức năng</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($allColor as $key => $item)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['color_hex'] }} <span class='color-preview' style='background-color: {{$item['color_hex']}};'></span></td>
                                        <td class="text-center">
                                            <a class="btn btn-warning"
                                                href="{{ route('admin.color.show_edit', ['id' => $item->id]) }}">
                                                Sửa
                                            </a>
                                            @if ($item['deleted_at'] == null)
                                                <a class="btn btn-danger"
                                                    href="{{ route('admin.color.delete', ['id' => $item['id']]) }}"
                                                    onclick="return confirm('Bạn chắc chắn muốn ẩn màu')">
                                                    Ẩn
                                                </a>
                                            @else
                                                <a class="btn btn-secondary"
                                                    href="{{ route('admin.color.restore', ['id' => $item['id']]) }}"
                                                    onclick="return confirm('Bạn chắc chắn muốn khôi phục màu')">
                                                    Hiện
                                                </a>
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
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "ordering": false // Tắt tính năng tự động sắp xếp
            });
        });
    </script>
    <!-- End of Content Wrapper -->
@endsection
