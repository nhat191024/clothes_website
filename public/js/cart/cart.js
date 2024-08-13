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
        url: '/cart/add',
        type: 'POST',
        data: {
            _token: csrfToken,
            product_id: productId,
            color_id: color,
            size_id: size,
            quantity: $('.pro-qty input').val(),
            price: price
        },
        beforeSend: function () {
            $('#add-to-cart-btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');
            $('#add-to-cart-btn').addClass('text-white');
        },
        success: function (response) {
            $('#add-to-cart-btn').html('<span class="icon_bag_alt"></span> Added to cart!');
            $('#add-to-cart-btn').addClass('text-white');
            console.log(response);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function removeFromCart(productDetailId)
{
    if (confirm('Are you sure you want to remove this item from your cart?')) {
        $.ajax({
            url: '/cart/remove',
            type: 'POST',
            data: {
                _token: csrfToken,
                product_detail_id: productDetailId
            },
            beforeSend: function () {
                $('.cart__close_'+productDetailId).html('<span class="spinner-border spinner-border-md" role="status" aria-hidden="true"></span>');
            },
            success: function (response) {
                $('.product-'+productDetailId).addClass('d-none');
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
}

