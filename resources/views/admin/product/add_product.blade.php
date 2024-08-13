@extends('admin.master')
@section('main')
    <!-- Content Wrapper -->


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thêm sản phẩm</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route('admin.product.add') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="categorySelect">Chọn danh mục</label>
                            <select  class="form-control selectpicker" multiple required name="category_id" id="categorySelect">
                                @foreach ($allCategory as $key => $item)
                                    <option {{ $key == 0 ? 'selected' : '' }} value="{{ $item['id'] }}">
                                        {{ $item['name'] }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tên sản phẩm</label>
                            <input maxlength="255" required type="text" class="form-control" id="productName"
                                aria-describedby="" name="product_name" placeholder="Nhập tên sản phẩm">
                        </div>
                        <div class="form-group">
                            <label for="">Nội dung giới thiệu</label>
                            <input type="text" class="form-control" id="productDescription" aria-describedby=""
                                name="product_description" placeholder="Nhập nội dung sản phẩm">
                        </div>
                        <div class="form-group">
                            <label for="">Giá</label>
                            <input type="number" class="form-control" id="productPrice" aria-describedby=""
                                name="product_price" placeholder="Nhập giá sản phẩm">
                        </div>
                        <label for="">Ảnh bánh</label>
                        <div class="custom-file">
                            <input
                            required
                             type="file" accept="image/*" class="custom-file-input" id="customFile"
                                name="product_image">
                            <label class="custom-file-label" for="customFile">Chọn ảnh</label>
                        </div>
                        <div class="form-group">
                            <label for="sizeSelect">Chọn size</label>
                            <select multiple class="selectpicker form-control" required name="size_id" id="sizeSelect">
                                @foreach ($allSize as $key => $item)
                                    <option {{ $key == 0 ? 'selected' : '' }} value="{{ $item['id'] }}">
                                        {{ $item['name'] }} </option>
                                @endforeach
                            </select>
                        </div>
                        <span class="small text-danger" id="error"></span> <br>
                        <a class="btn btn-primary mt-4" onclick="history.back()">Quay lại</a>
                        <button id="saveAdd" class="btn btn-success mt-4" type="submit" >Thêm</button>
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
        const token = "{{ csrf_token() }}";
    </script>
    <script src="{{ URL::asset('js/admin/product_checkbox.js') }}"></script>
    <script src="{{ URL::asset('js/admin/product.js') }}"></script>
@endsection
