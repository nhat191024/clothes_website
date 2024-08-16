var product_name = $('#name').text();
var color = $('input[name="color__radio"]:checked').val();
var size = $('.size__btn label.active').find('input[name="size__radio"]').val();
const csrfToken = $('meta[name="csrf-token"]').attr('content');

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

    // $('')
    $('.qtybtn').on('click', function() {
        var $input = $(this).siblings('input[name="product-quantity"]');
        var currentQuantity = parseInt($input.val());
        var productDetailId = $input.attr('id').split('-')[1];

        if ($(this).hasClass('inc')) {
            updateQuantity(productDetailId, currentQuantity + 1);
        } else if ($(this).hasClass('dec') && currentQuantity > 1) {
            updateQuantity(productDetailId, currentQuantity - 1);
        } else if (currentQuantity <= 0) {
            removeFromCart(productDetailId);
        }
    });

    $('input[name="product-quantity"]').on('change', function() {
        var productDetailId = $(this).attr('id').split('-')[1];
        var quantity = $(this).val();
        updateQuantity(productDetailId, quantity);

    });

    $('#apply_voucher').on('click', function() {
        event.preventDefault();
        var voucherCode = $('#voucher_code').val();

        applyVoucher(voucherCode);
    })
})

function applyVoucher(voucherCode){
    // $subtotal = $('#subtotal').text();
    $.ajax({
        url: '/cart/applyVoucher',
        type: 'POST',
        data: {
            _token: csrfToken,
            voucher_code: voucherCode
        },
        beforeSend: function () {
            $('#apply_voucher').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Apply');
        },
        success: function (response) {
            $('#voucher_label').removeClass('d-none');
            $('#apply_voucher').html('<i class="fa fa-check mr-2"></i>Apply');
            $('#voucher_error').html(response['checkResult']['message']);
            if (response['discount'] == 0) {
                $('#total').html(formatPrice(response['subtotal']));
                $('#voucher_label').addClass('d-none');
                return;
            }
            $('#voucher').html('-'+formatPrice(response['discount']));
            $('#total').html(formatPrice(response['subtotal'] - response['discount']));
        },
        error: function (error) {
            $('#voucher_error').html('Failed to apply voucher. Please try again.');
        }
    });
}

function addToCart(productId) {
    $.ajax({
        url: '/cart/add',
        type: 'POST',
        data: {
            _token: csrfToken,
            name: product_name,
            product_id: productId,
            color_id: color,
            size_id: size,
            quantity: $('.pro-qty input').val(),
        },
        beforeSend: function () {
            $('#add-to-cart-btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');
            $('#add-to-cart-btn').addClass('text-white');
        },
        success: function (response) {
            $('#add-to-cart-btn').html('<span class="icon_bag_alt"></span> Added!');
            $('#add-to-cart-btn').addClass('text-white');

        },
        error: function (error) {

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
                updatePrices(productDetailId,response['subtotal'],response['total']);
                $('.product-'+productDetailId).addClass('d-none');
            },
            error: function (xhr, status, error) {

            }
        });
    }
}

function updateQuantity(product_detail_id,quantity)
{

    $.ajax({
        url: '/cart/updateQuantity',
        type: 'POST',
        data: {
            _token: csrfToken,
            product_detail_id: product_detail_id,
            quantity: quantity
        },
        beforeSend: function () {
            $('.cart__close_'+product_detail_id).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        },
        success: function (response) {
            updatePrices(product_detail_id,response.subtotal,response.total);
            // $('#productDetail-'+product_detail_id).val(response);
            $('.cart__close_'+product_detail_id).html('<span class="icon_close"></span>');
        }
    });
}


function updatePrices(product_detail_id,subtotal)
{
    $discountAmount = 0;
    $.ajax({
        url: '/cart/getVoucherDiscount',
        type: 'GET',
        success: function (response) {
            $discountAmount = response;
            var product_price = $('.cart__price-' + product_detail_id).data('id');
            var outputPrice = formatPrice(product_price * $('#productDetail-' + product_detail_id).val());
            $('#cart__total-' + product_detail_id).text(outputPrice);
            var outputSubtotal = formatPrice(subtotal);
            $('#subtotal').text(outputSubtotal);

            if ($discountAmount > 0) {
                $('#voucher').html('-' + formatPrice($discountAmount));
            } else {
                $('#voucher').html('-0');
            }
            var outputTotal = formatPrice(subtotal - $discountAmount);
            $('#total').text(outputTotal);
        }
    });


}

function formatPrice(price)
{
    return new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(price);
}
