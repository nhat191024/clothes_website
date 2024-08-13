var color = $('input[name="color__radio"]:checked').val();
var size = $('.size__btn label.active').find('input[name="size__radio"]').val();
var price = $('#product__price').val();
$(document).ready(function () {
    $('input[name="color__radio"]').on('change', function() {
        var selectedColor = $('input[name="color__radio"]:checked').val();
        color = selectedColor;
    });

    $('.size__btn').on('click', 'label', function() {
        $('.size__btn label').removeClass('active');
        $(this).addClass('active');
        var selectedSize = $(this).find('input[name="size__radio"]').val();
        size = selectedSize;
    });
})

function addToCart(productId) {
    $.ajax({
        url: '/cart/add-to-cart',
        type: 'POST',
        data: {
            _token: csrfToken,
            productId: productId,
            color: color,
            size: size,
            quantity: $('.pro-qty input').val(),
            price: price
        },
        // add before submit
        beforeSend: function () {
            $('#add-to-cart-btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');
            $('#add-to-cart-btn').addClass('text-white');
        },
        success: function (response) {
            $('#add-to-cart-btn').html('<span class="icon_bag_alt"></span> Added to cart!');
            $('#add-to-cart-btn').addClass('text-white');
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}


