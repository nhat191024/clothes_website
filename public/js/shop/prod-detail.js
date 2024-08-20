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
            sizeAndColors.push(response);
            setSizeAsEnabled(sizeAndColors[0][0]['size_id']);
        }
    })
}

function setEnabledColorBySizeId(id)
{
    disableAllColors();
    $colorsOfSize = sizeAndColors[0].find(element => element['size_id'] == id)['colors']
    console.log($colorsOfSize);
    $colorsOfSize.forEach(color => {
        $('#color-label-'+color['color_id']).removeClass('d-none');
    });
    $first_color_id = $colorsOfSize[0]['color_id'];
    $('.color-loading-circle').addClass('d-none');
    setColorAsEnabled($first_color_id);
}

function disableAllColors()
{
    $('.color_label_class').removeClass('d-none');
    $('.color_label_class').addClass('d-none');
    $('.color-loading-circle').removeClass('d-none');
}

function setSizeAsEnabled(id)
{
    setEnabledColorBySizeId(id);
}

function setColorAsEnabled($first_color_id)
{
    const element = document.getElementById('color-'+$first_color_id);
    element.click();
}

