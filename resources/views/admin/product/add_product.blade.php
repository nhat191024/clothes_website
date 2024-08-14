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
                            <select class="form-control selectpicker" multiple required name="category_id"
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
                        <label for="">Ảnh bánh</label>
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
                        <button id="saveAdd" class="btn btn-success mt-4" type="submit">Thêm</button>
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
        $(document).ready(function() {
            let sizeColorCount = 0;

    // Lấy dữ liệu từ biến PHP được truyền vào view
    let sizes = @json($allSize);
    let colors = @json($allColor);

    // Function to add a new size-color card
    function addSizeColorCard(sizeId = '', colorIds = []) {
        sizeColorCount++;

        // Tạo HTML cho các tùy chọn size và màu
        let sizeOptionsHTML = Object.keys(sizes).map(id => `<option value="${id}" ${id == sizeId ? 'selected' : ''}>${sizes[id]}</option>`).join('');
        let colorOptionsHTML = Object.keys(colors).map(id => {
            let color = colors[id];
            return `<option value="${id}" data-content="<span class='color-preview' style='background-color: ${color.color_hex};'></span> ${color.name}"></option>`;
        }).join('');

        let sizeColorHTML = `
            <label class="mt-2" id="label-variation-${sizeColorCount}" for="categorySelect">Chọn biến thể thứ ${sizeColorCount}</label>
            <div class="size-color-card" id="size-color-${sizeColorCount}">
                <button type="button" class="btn btn-danger remove-btn" data-id="${sizeColorCount}">Xóa</button>
                <div class="form-group">
                    <label for="size-select-${sizeColorCount}">Chọn Size ${sizeColorCount}</label>
                    <select class="selectpicker form-control" id="size-select-${sizeColorCount}" name="sizes[${sizeColorCount}][size]" data-live-search="true" required>
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
        $('.selectpicker').selectpicker('refresh'); // Refresh selectpicker to apply styling
    }

    // Function to remove a size-color card
    function removeSizeColorCard(id) {
        $(`#size-color-${id}`).remove();
        $(`#label-variation-${id}`).remove();
        if ($('#sizes-container .size-color-card').length === 0) {
            addSizeColorCard(); // Ensure at least one card is present
        }
    }

    // Add initial size-color card with default values
    addSizeColorCard('1', ['1']); // Initialize with default size ID '1' and color ID '1'

    // Add event listener to 'Thêm Size và Màu' button
    $('#add-size-color-btn').click(function() {
        addSizeColorCard();
    });

    // Event delegation to handle click event on dynamically added remove buttons
    $('#sizes-container').on('click', '.remove-btn', function() {
        let id = $(this).data('id');
        removeSizeColorCard(id);
    });

    // Handle form submission
    $('#product-form').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        let formData = new FormData(this); // Create FormData object

        // Xóa dữ liệu sizes hiện có để tránh trùng lặp
        let existingSizes = Array.from(formData.entries()).filter(entry => entry[0].startsWith('sizes['));
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
            url: $(this).attr('action'), // Use the form's action attribute
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Sản phẩm đã được lưu thành công!');
                // Handle success response
            },
            error: function(xhr, status, error) {
                alert('Có lỗi xảy ra, vui lòng thử lại.');
                // Handle error response
            }
        });
    });
            // Add the following code if you want the name of the file appear on select
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
            const token = "{{ csrf_token() }}";
        });
    </script>
    <script src="{{ URL::asset('js/admin/product_checkbox.js') }}"></script>
    <script src="{{ URL::asset('js/admin/product.js') }}"></script>
@endsection
