$(document).ready(function() {

    updateCartCount();
})

function updateCartCount() {
    $.ajax({
        url: "/cart/getCount",
        method: "GET",
        success: function(data) {
            if(data<=0){
                $('.cartAmount').addClass('d-none');
            }
            $('.cartAmount').text(data);
            addedToCartEffect();
        }
    });
}

function addedToCartEffect() {
    const cartAmount = $('.cartAmount');
    cartAmount.addClass('addedToCart');
    setTimeout(function() {
        cartAmount.removeClass('addedToCart');
    }, 500);

}
