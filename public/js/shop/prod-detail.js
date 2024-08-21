const sizeAndColors = [];
$(document).ready(function () {
    getSizesAndColors($('#product_id').val());
})
function getSizesAndColors(product_id) {
    $.ajax({
        url: '/shop/product/' + product_id + '/get-colors-of-sizes',
        type: 'GET',
        success: function (response) {
            $('.color-loading-circle').addClass('d-none');
            sizeAndColors.push(...Object.values(response));
            setSizeAsEnabled(sizeAndColors[0]['size_id']);
        }
    })
}

function setEnabledColorBySizeId(id) {
    disableAllColors();
    $first_color_id = 0;
    sizeAndColors.forEach(size => {
        if (size['size_id'] == id) {
            size['colors'].forEach(color => {
                ($first_color_id == 0 ? $first_color_id = color : $first_color_id);
                $('#color-label-' + color).removeClass('d-none');
            });
        }
    });
    $('.color-loading-circle').addClass('d-none');
    setColorAsEnabled($first_color_id);
}

function disableAllColors() {
    $('.color_label_class').removeClass('d-none');
    $('.color_label_class').addClass('d-none');
    $('.color-loading-circle').removeClass('d-none');
}

function setSizeAsEnabled(id) {
    setEnabledColorBySizeId(id);
}

function setColorAsEnabled($first_color_id) {
    const element = document.getElementById('color-' + $first_color_id);
    element.click();
}

