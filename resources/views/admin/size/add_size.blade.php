@extends('admin.master')
@section('main')
    <!-- Content Wrapper -->


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thêm size</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
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
                    <form action="{{ route('admin.size.add') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Tên size</label>
                            <input required type="text" class="form-control" id="" aria-describedby=""
                                name="size_name" placeholder="Nhập tên size">
                        </div>
                        <button class="btn btn-success mt-4" type="submit">Thêm size</button>
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
