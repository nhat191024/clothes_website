<div class="modal fade" id="addImagesModal" tabindex="-1" role="dialog" aria-labelledby="addImagesModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addImagesModalLabel">Thêm ảnh</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input name="images" type="file" id="imageUpload" multiple>
        <div id="previewImages"></div>
        <div id="previewImagesContainer"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" id="uploadImagesBtn">Tải lên</button>
      </div>
    </div>
  </div>
</div>