@extends('admin.master')
@section('main')
    <div class="container-fluid">
        @if (session('success'))
            <div id="success-alert" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div id="alert" class="alert alert-success d-none"></div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Kho ảnh sản phẩm: <strong>{{ $productDetails->name }}
                            </strong></h1>
                        <button id="addImagesBtn" class="btn btn-primary float-right">Thêm</button>
                        <button type="button" class="btn btn-danger float-right mr-2" data data-toggle="modal"
                            data-target="#confirmDeleteModal">Xóa tất cả</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($images as $image)
                                <div class="col-md-3 mb-4">
                                    <div class="card">
                                        <img src="{{ url('img/product/' . $image->img) }}" class="card-img-top"
                                            alt="Image">
                                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                            <button id="delete-image-btn" type="button"
                                                class="btn btn-danger btn-sm text-center"
                                                onclick="deleteImage(`{{ route('admin.product.delete_photo', ['id' => $image->id]) }}`)">
                                                Xóa
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.modal.confirm_delete')
    @include('admin.modal.loading')
    @include('admin.modal.wating')
    @include('admin.modal.add_image')
{{-- <script src="{{ url('js/jquery-3.7.0.min.js') }}"></script> --}}
<script>
    function deleteImage(route) {
        $('#confirmDeleteModal').modal('show');
        $('#confirmDeleteModal').find('.delete').attr('href', route);
    }
    $(document).ready(function() {

        // Hiển thị modal khi bấm nút "Thêm"
        $('#addImagesBtn').click(function() {
            $('#addImagesModal').modal('show');
        });

        // Xử lý sự kiện khi người dùng chọn ảnh
        $('#imageUpload').on('change', function() {
            // Lấy danh sách tệp đã chọn
            var files = $(this)[0].files;

            // Hiển thị số lượng tệp đã chọn
            console.log("Số lượng ảnh đã chọn: " + files.length);

            // Hiển thị tên của các tệp đã chọn
            for (var i = 0; i < files.length; i++) {
                console.log("Tên tệp đã chọn: " + files[i].name);
            }
        });

        var imageUpload = document.getElementById('imageUpload');
        var previewImagesContainer = document.getElementById('previewImagesContainer');

        $(imageUpload).on('change', function(event) {
            var files = event.target.files;
            $(previewImagesContainer).html('');

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = $('<img>').attr('src', e.target.result).addClass('preview-image');
                    $(previewImagesContainer).append(img);
                };
                reader.readAsDataURL(files[i]);
            }
        });
        // Xử lý sự kiện khi người dùng bấm nút "Tải lên"
        // Xử lý sự kiện khi người dùng bấm nút "Tải lên"
        $('#uploadImagesBtn').click(function() {
            // Tạo đối tượng FormData
            var formData = new FormData();

            // Lấy danh sách các tệp đã chọn
            var files = $('#imageUpload')[0].files;
            formData.append('id', `{{ $productDetails->id }}`);
            // Thêm dữ liệu ảnh vào FormData
            for (var i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }

            // Thêm CSRF token vào FormData
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            // Gửi dữ liệu ảnh lên server thông qua Ajax
            $.ajax({
                url: `{{ route('admin.product.add_photo') }}`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    // Hiển thị modal waiting trước khi gửi yêu cầu
                    $('#waitingModal').modal('show');
                },
                success: function(response) {
                    // Xử lý phản hồi từ server
                    // Đặt thông báo vào biến JavaScript
                    var successMessage = 'Tải ảnh lên thành công';

                    // Lưu thông báo vào localStorage
                    localStorage.setItem('successMessage', successMessage);
                    location.reload();
                },
                error: function(error) {
                    // Xử lý lỗi nếu có
                    console.log(error);
                },
                complete: function() {
                    // Ẩn modal waiting sau khi yêu cầu hoàn thành
                    $('#waitingModal').modal('hide');
                }
            });

            // Đóng modal
            $('#addImagesModal').modal('hide');
        });

        $('#addImagesModal').on('hidden.bs.modal', function() {
            // Xóa tất cả các ảnh đã hiển thị
            $('.preview-image').remove();
            $('#previewImages').remove();
            // Xóa giá trị input file để cho phép chọn ảnh mới
            $('#imageUpload').val('');
        });

        // Xử lý sự kiện khi người dùng click vào button xóa
        $('#delete-image-btn').click(function() {
            var imageId = $(this).data('image-id');
            console.log('Image ID:', imageId);
            let deleteUrl = `{{ route('admin.product.delete_photo', ['id' => '']) }}`.slice(0, -2) +
                imageId + '}}';

            // Truyền giá trị imageId vào modal xác nhận xóa
            $('#confirmDeleteModal').find('.btn-danger').attr('href',
                deleteUrl);
        });

        setTimeout(function() {
            $('#success-alert').hide();
            $('#alert').hide();
        }, 3000);

        var successMessage = localStorage.getItem('successMessage');
        if (successMessage) {
            console.log(successMessage);
            // Hiển thị thông báo
            // document.getElementById('success-alert').style.display = 'block';
            $('#alert').text(successMessage).removeClass('d-none');

            // Xóa thông báo khỏi localStorage
            localStorage.removeItem('successMessage');
        }
    });
</script>
@endsection
