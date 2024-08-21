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
                    <form action="{{ route('admin.product.add') }}" method="post" id="product-form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="categorySelect">Chọn danh mục</label>
                            <select class="form-control selectpicker" multiple required name="category_id[]"
                                id="categorySelect">
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
                        <label for="">Ảnh sản phẩm</label>
                        <div class="custom-file">
                            <input required type="file" accept="image/*" class="custom-file-input" id="customFile"
                                name="product_image">
                            <label class="custom-file-label" for="customFile">Chọn ảnh</label>
                        </div>
                        <div class="mt-2" id="sizes-container">
                            <!-- màu và size -->
                        </div>
                        <span class="small text-danger" id="error"></span> <br>
                        <a class="btn btn-primary mt-4" onclick="history.back()">Quay lại</a>
                        <button type="button" class="btn btn-primary mt-4" id="add-size-color-btn">Thêm Size và
                            Màu</button>
                        <button id="saveAdd" class="btn btn-success mt-4" type="submit">Lưu</button>
                    </form>

                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
    @include('admin.modal.loading');
    @include('admin.modal.success');


    <!-- End of Content Wrapper -->
    <script>
        $(document).ready(function() {
            // Lấy mã CSRF từ meta tag
            let csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Thiết lập mã CSRF cho tất cả các yêu cầu AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            let sizeColorCount = 0;
            let selectedSizes = []; // Mảng lưu các size đã chọn

            // Lấy dữ liệu từ biến PHP được truyền vào view
            let sizes =
                @json($allSize); // Đảm bảo rằng $allSize và $allColor được định nghĩa trong view PHP
            let colors = @json($allColor);

            // Function to add a new size-color card
            function addSizeColorCard(sizeId = '', colorIds = []) {
                sizeColorCount++;

                let sizeOptionsHTML = Object.keys(sizes).map(id => {
                    if (selectedSizes.includes(id) && id != sizeId) {
                        return `<option value="${id}" style="display:none;">${sizes[id]}</option>`; // Ẩn tùy chọn size đã chọn
                    } else {
                        return `<option value="${id}" ${id == sizeId ? 'selected' : ''}>${sizes[id]}</option>`;
                    }
                }).join('');

                let colorOptionsHTML = Object.keys(colors).map(id => {
                    let color = colors[id];
                    let selected = colorIds.includes(id) ? 'selected' : '';
                    return `<option value="${id}" ${selected} data-content="<span class='color-preview' style='background-color: ${color.color_hex};'></span> ${color.name}"></option>`;
                }).join('');

                let sizeColorHTML = `
            <label class="mt-2" id="label-variation-${sizeColorCount}" for="categorySelect">Chọn biến thể thứ ${sizeColorCount}</label>
            <div class="size-color-card" id="size-color-${sizeColorCount}">
                <button type="button" class="btn btn-danger remove-btn" data-id="${sizeColorCount}">Xóa</button>
                <div class="form-group">
                    <label for="size-select-${sizeColorCount}">Chọn Size ${sizeColorCount}</label>
                    <select class="selectpicker form-control size-select" id="size-select-${sizeColorCount}" name="sizes[${sizeColorCount}][size]" data-live-search="true" required>
                        <option value="">Chọn Size</option>
                        ${sizeOptionsHTML}
                    </select>
                </div>
                <div class="form-group">
                    <label for="color-select-${sizeColorCount}">Chọn Màu ${sizeColorCount}</label>
                    <select multiple class="selectpicker form-control" id="color-select-${sizeColorCount}" name="sizes[${sizeColorCount}][colors][]" data-live-search="true" required>
                        ${colorOptionsHTML}
                    </select>
                </div>
            </div>
        `;
                $('#sizes-container').append(sizeColorHTML);
                $('.selectpicker').selectpicker('refresh'); // Refresh selectpicker để áp dụng styling

                // Cập nhật danh sách size đã chọn khi thay đổi
                $(`#size-select-${sizeColorCount}`).on('change', function() {
                    updateSelectedSizes();
                });

                // Cập nhật danh sách size đã chọn khi khởi tạo
                updateSelectedSizes(); // Đảm bảo rằng updateSelectedSizes được gọi
            }

            // Function để cập nhật mảng selectedSizes và hide size trùng
            function updateSelectedSizes() {
                selectedSizes = [];

                // Duyệt qua tất cả các select size để lấy giá trị đã chọn
                $('.size-select').each(function() {
                    let selectedSize = $(this).val();
                    if (selectedSize) {
                        selectedSizes.push(selectedSize);
                    }
                });

                console.log('Selected Sizes:', selectedSizes); // Debug thông tin size đã chọn

                // Ẩn size đã chọn trên các select khác
                $('.size-select').each(function() {
                    let currentSelect = $(this);
                    let currentValue = currentSelect.val();

                    currentSelect.find('option').each(function() {
                        let optionValue = $(this).val();
                        if (selectedSizes.includes(optionValue) && optionValue != currentValue) {
                            $(this).hide(); // Ẩn tùy chọn size đã chọn
                        } else {
                            $(this).show(); // Hiển thị tùy chọn size chưa chọn
                        }
                    });

                    currentSelect.selectpicker('refresh'); // Refresh selectpicker để cập nhật giao diện
                });
            }

            // Function to remove a size-color card
            function removeSizeColorCard(id) {
                $(`#size-color-${id}`).remove();
                $(`#label-variation-${id}`).remove();

                // Cập nhật lại danh sách size khi một biến thể bị xóa
                updateSelectedSizes();

                if ($('#sizes-container .size-color-card').length === 0) {
                    addSizeColorCard(); // Đảm bảo có ít nhất một card
                }
            }

            // Add initial size-color card with default values
            addSizeColorCard('1', ['1']); // Khởi tạo với size ID '1' và màu ID '1'

            // Thêm event listener cho nút "Thêm Size và Màu"
            $('#add-size-color-btn').click(function() {
                addSizeColorCard();
            });

            // Event delegation để xử lý sự kiện click trên nút xóa được thêm động
            $('#sizes-container').on('click', '.remove-btn', function() {
                let id = $(this).data('id');
                console.log(`Remove button clicked: ${id}`); // Debug thông tin nút xóa đã nhấn
                removeSizeColorCard(id);
            });

            // Xử lý khi submit form
            $('#product-form').submit(function(event) {
                event.preventDefault(); // Ngăn chặn submit mặc định

                let formData = new FormData(this); // Tạo đối tượng FormData

                // Kiểm tra trùng lặp size
                let sizesUsed = [];
                let hasDuplicates = false;

                $('#sizes-container .size-color-card').each(function() {
                    let sizeId = $(this).find('select[name*="[size]"]').val();
                    if (sizeId) {
                        if (sizesUsed.includes(sizeId)) {
                            hasDuplicates = true;
                            return false; // Dừng vòng lặp
                        }
                        sizesUsed.push(sizeId);
                    }
                });

                if (hasDuplicates) {
                    alert('Có size trùng lặp. Vui lòng kiểm tra lại.');
                    return;
                }

                $('#loadingModal').modal('show');

                // Xóa dữ liệu sizes hiện có để tránh trùng lặp
                let existingSizes = Array.from(formData.entries()).filter(entry => entry[0].startsWith(
                    'sizes['));
                existingSizes.forEach(([key]) => formData.delete(key));

                // Thêm dữ liệu sizes và colors vào FormData
                $('#sizes-container .size-color-card').each(function(index) {
                    let sizeId = $(this).find('select[name*="[size]"]').val();
                    let colorIds = $(this).find('select[name*="[colors][]"]').val();
                    if (sizeId) {
                        formData.append(`sizes[${index}][size]`, sizeId);
                        colorIds.forEach(colorId => {
                            formData.append(`sizes[${index}][colors][]`, colorId);
                        });
                    }
                });

                $.ajax({
                    url: $(this).attr('action'), // Sử dụng thuộc tính action của form
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#loadingModal').modal('hide');
                        $('#successModal').modal('show');
                        $('#successModal').data('link', response.link);
                    },
                    error: function(xhr, status, error) {
                        $('#loadingModal').modal('hide');
                        alert('Có lỗi xảy ra, vui lòng thử lại.');
                        // Xử lý phản hồi lỗi
                    }
                });
            });


            // Add the following code if you want the name of the file appear on select
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
            const token = "{{ csrf_token() }}";

            $('#successModal').on('hidden.bs.modal', function() {
                let link = $(this).data('link');
                if (link) {
                    window.location.replace(link);
                }
            });
        });
    </script>
    <script src="{{ URL::asset('js/admin/product_checkbox.js') }}"></script>
    <script src="{{ URL::asset('js/admin/product.js') }}"></script>
@endsection
