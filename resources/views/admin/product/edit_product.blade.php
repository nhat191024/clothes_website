@extends('admin.master')
@section('main')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">{{ isset($productDetails) ? 'Sửa sản phẩm' : 'Thêm sản phẩm' }}</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <form
                        action="{{ isset($productDetails) ? route('admin.product.edit', $productDetails->id) : route('admin.product.add') }}"
                        method="post" id="product-form" enctype="multipart/form-data">
                        @csrf
                        @if (isset($productDetails))
                            @method('POST')
                        @endif

                        <div class="form-group">
                            <label for="categorySelect">Chọn danh mục</label>
                            <select class="form-control selectpicker" multiple required name="category_id[]"
                                id="categorySelect">
                                @foreach ($allCategory as $key => $item)
                                    <option
                                        {{ in_array($item['id'], old('category_id', $productDetails->categories ?? [])) ? 'selected' : '' }}
                                        value="{{ $item['id'] }}">
                                        {{ $item['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="productName">Tên sản phẩm</label>
                            <input maxlength="255" required type="text" class="form-control" id="productName"
                                name="product_name" value="{{ old('product_name', $productDetails->name ?? '') }}"
                                placeholder="Nhập tên sản phẩm">
                        </div>

                        <div class="form-group">
                            <label for="productDescription">Nội dung giới thiệu</label>
                            <input type="text" class="form-control" id="productDescription" name="product_description"
                                value="{{ old('product_description', $productDetails->description ?? '') }}"
                                placeholder="Nhập nội dung sản phẩm">
                        </div>

                        <div class="form-group">
                            <label for="productPrice">Giá</label>
                            <input type="number" class="form-control" id="productPrice" name="product_price"
                                value="{{ old('product_price', $productDetails->price ?? '') }}"
                                placeholder="Nhập giá sản phẩm">
                        </div>

                        <div class="form-group">
                            <label for="customFile">Ảnh sản phẩm</label>
                            <div class="custom-file">
                                <input type="file" accept="image/*" class="custom-file-input" id="customFile"
                                    name="product_image">
                                <label class="custom-file-label" for="customFile">
                                    {{ isset($productDetails->image) ? 'Chọn ảnh mới' : 'Chọn ảnh' }}
                                </label>
                            </div>
                            @if (isset($productDetails->image))
                                <div class="mt-3">
                                    <label>Ảnh cũ:</label>
                                    <div>
                                        <img src="{{ url('') . '/img/client/shop/' . $productDetails->image }}"
                                            alt="Ảnh sản phẩm" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-2" id="sizes-container">
                            <!-- Existing size and color variants will be populated here -->
                        </div>
                        <input type="hidden" value="{{ $productDetails->id }}" name="id">

                        <span class="small text-danger" id="error"></span> <br>
                        <a class="btn btn-primary mt-4" onclick="history.back()">Quay lại</a>
                        <button type="button" class="btn btn-primary mt-4" id="add-size-color-btn">Thêm Size và
                            Màu</button>
                        <button id="saveAdd" class="btn btn-success mt-4"
                            type="submit">{{ isset($productDetails) ? 'Cập nhật' : 'Lưu' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('admin.modal.loading')
    @include('admin.modal.success')

    <!-- Script Section -->
    <script>
        $(document).ready(function() {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            let sizeColorCount = 0;
            let selectedSizes = [];
            let sizes = @json($allSize);
            let colors = @json($allColor);
            let productDetails = @json($productDetails); // Get product details for editing

            // Add size-color cards from existing product details
            if (productDetails && productDetails.sizes) {
                productDetails.sizes.forEach((sizeDetail, index) => {
                    addSizeColorCard(sizeDetail.size, sizeDetail.colors);
                });
            } else {
                addSizeColorCard(); // Add an initial card for new products
            }

            function addSizeColorCard(sizeId = '', colorIds = []) {
                sizeColorCount++;
                let sizeOptionsHTML = Object.keys(sizes).map(id => {
                    return `<option value="${id}" ${id == sizeId ? 'selected' : ''}>${sizes[id]}</option>`;
                }).join('');

                let colorOptionsHTML = Object.keys(colors).map(id => {
                    let color = colors[id]; // Dữ liệu màu sắc
                    let selected = colorIds.includes(parseInt(id)) ? 'selected' :
                        ''; // Chuyển đổi ID màu sang số
                    return `
        <option value="${id}" ${selected} data-content="<span class='color-preview' style='background-color: ${color.color_hex};'></span> ${color.name}">
            ${color.name}
        </option>
    `;
                }).join('');

                let sizeColorHTML = `
    <label class="mt-2" id="label-variation-${sizeColorCount}" for="categorySelect">Chọn biến thể thứ ${sizeColorCount}</label>
    <div class="size-color-card" id="size-color-${sizeColorCount}">
        <button type="button" class="btn btn-danger remove-btn" data-id="${sizeColorCount}">Xóa</button>
        <div class="form-group">
            <label for="size-select-${sizeColorCount}">Chọn Size ${sizeColorCount}</label>
            <select class="selectpicker form-control size-select" id="size-select-${sizeColorCount}" name="sizes[${sizeColorCount}][size]" required>
                <option value="">Chọn Size</option>
                ${sizeOptionsHTML}
            </select>
        </div>
        <div class="form-group">
            <label for="color-select-${sizeColorCount}">Chọn Màu ${sizeColorCount}</label>
            <select multiple class="selectpicker form-control color-select" id="color-select-${sizeColorCount}" name="sizes[${sizeColorCount}][colors][]" data-live-search="true" required>
                ${colorOptionsHTML}
            </select>
        </div>
    </div>
`;
                $('#sizes-container').append(sizeColorHTML);
                $('.selectpicker').selectpicker('refresh'); // Refresh selectpicker after adding options
            }

            function updateSelectedSizes() {
                selectedSizes = [];
                $('.size-select').each(function() {
                    let selectedSize = $(this).val();
                    if (selectedSize) selectedSizes.push(selectedSize);
                });

                $('.size-select').each(function() {
                    let currentSelect = $(this);
                    let currentValue = currentSelect.val();
                    currentSelect.find('option').each(function() {
                        $(this).toggle(!selectedSizes.includes($(this).val()) || $(this).val() ==
                            currentValue);
                    });
                    currentSelect.selectpicker('refresh');
                });
            }

            $('#add-size-color-btn').click(function() {
                addSizeColorCard();
                updateSelectedSizes(); // Gọi hàm này sau khi thêm một size-color card mới
            });

            $('#sizes-container').on('click', '.remove-btn', function() {
                removeSizeColorCard($(this).data('id'));
                updateSelectedSizes(); // Gọi hàm này sau khi xóa một size-color card
            });

            function removeSizeColorCard(id) {
                $(`#size-color-${id}`).remove();
                $(`#label-variation-${id}`).remove();
                updateSelectedSizes();
                if ($('#sizes-container .size-color-card').length === 0) addSizeColorCard();
            }

            $('#product-form').submit(function(event) {
                event.preventDefault();
                let formData = new FormData(this);
                let sizesUsed = [];
                let hasDuplicates = false;

                $('#sizes-container .size-color-card').each(function() {
                    let sizeId = $(this).find('select[name*="[size]"]').val();
                    if (sizeId) sizesUsed.includes(sizeId) ? hasDuplicates = true : sizesUsed.push(
                        sizeId);
                });

                if (hasDuplicates) {
                    alert('Có size trùng lặp. Vui lòng kiểm tra lại.');
                    return;
                }

                $('#loadingModal').modal('show');
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#loadingModal').modal('hide');
                        $('#successModal').modal('show').data('link', response.link);
                    },
                    error: function() {
                        $('#loadingModal').modal('hide');
                        alert('Có lỗi xảy ra, vui lòng thử lại.');
                    }
                });
            });

            $('#sizes-container').on('change', '.size-select', function() {
                updateSelectedSizes();
            });

            $(".custom-file-input").on("change", function() {
                $(this).siblings(".custom-file-label").addClass("selected").html($(this).val().split("\\")
                    .pop());
            });

            $('#successModal').on('hidden.bs.modal', function() {
                if ($(this).data('link')) window.location.replace($(this).data('link'));
            });
            console.log(@json($allColor));
            console.log(colors);
        });
    </script>
@endsection
