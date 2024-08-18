@extends('admin.master')
@section('main')
    <!-- Content Wrapper -->


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thêm màu</h1>
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
                    <form action="{{ route('admin.color.add') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Tên màu</label>
                            <input required type="text" class="form-control" id="" aria-describedby=""
                                name="color_name" placeholder="Nhập tên màu">
                        </div>
                        <div class="form-group">
                            <label for="">Mã màu</label>
                            <input required type="text" class="form-control" id="" aria-describedby=""
                                name="color_hex" placeholder="Nhập tên màu">
                        </div>
                        <button class="btn btn-success mt-4" type="submit">Thêm màu</button>
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

        $(document).ready(function() {
            $('#colorPicker').spectrum({
                type: "component",
                showInput: true,
                preferredFormat: "hex",
                showPalette: true,
                palette: [],
                color: "#000000", // Default color
                change: function(color) {
                    // Update the displayed color code whenever a new color is selected
                    $('#colorCode').text(color.toHexString());
                }
            });

            // Initialize the color code display when the page loads
            var defaultColor = $('#colorPicker').spectrum("get").toHexString();
            $('#colorPicker').val(defaultColor); // Set the input value
            $('#colorCode').text(defaultColor); // Display the hex code
        });
    </script>
@endsection
