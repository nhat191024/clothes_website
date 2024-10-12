@extends('admin.master')
@section('main')
    <!-- Content Wrapper -->


    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Thêm voucher</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route('admin.voucher.add') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">

                            <label for="voucherCodeField">VOUCHER CODE</label>
                            <button class="btn btn-primary" id="generateVoucherCodeBtn" onclick="generateVoucherCode()" type="button" style="margin: 5px">Tạo Mã</button>
                            <input maxlength="255" required type="text" class="form-control" id="voucherCodeField" aria-describedby=""
                                name="code" placeholder="Nhập mã hoặc bấm TẠO">
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <input type="text" class="form-control" id="description" aria-describedby=""
                                name="description" placeholder="Nhập mô tả cho voucher">
                        </div>
                        <div class="form-group">
                            <label for="discount_percentage">Giá giảm</label>
                            <input required type="number" class="form-control" id="discount_percentage" aria-describedby=""
                                name="discount_percentage" placeholder="Nhập giá giảm">
                        </div>
                        <div class="form-group">
                            <label for="min_price">Giá đơn tối thiểu để áp dụng Voucher</label>
                            <input required type="number" class="form-control" id="min_price" aria-describedby=""
                                name="min_price" placeholder="Nhập tối thiểu">
                        </div>
                        <div class="form-group">
                            <label for="quantity">Số lần sử dụng</label>
                            <input required type="number" class="form-control" id="quantity" aria-describedby=""
                                name="quantity" placeholder="Nhập số lần sử dụng">
                        </div>
                        <div class="form-group">
                            <label for="start_date">Ngày hiệu lực (Định dạng: Năm/Tháng/Ngày)</label>
                            <input required type="date" class="form-control" id="start_date" aria-describedby=""
                                name="start_date" placeholder="Ngày kết thúc">
                        </div>
                        <div class="form-group">
                            <label for="end-time">Ngày hết hạn (Định dạng: Năm/Tháng/Ngày)</label>
                            <input required type="date" class="form-control" id="end-time" aria-describedby=""
                                name="end_date" placeholder="Ngày kết thúc">
                        </div>
                        <div class="form-group">
                            <label for="new_customer">Voucher cho khách hàng mới (Voucher này sẽ chỉ được dùng 1 lần duy nhất)</label><br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="new_customer" name="is_for_new_comers">
                                <label class="form-check-label" for="new_customer">
                                    Đánh dấu là cho khách hàng mới
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-success mt-4" type="submit">Thêm</button>
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
