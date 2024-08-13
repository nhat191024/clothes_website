
document.addEventListener('DOMContentLoaded', function () {
    const seeMoreButton = document.getElementById('see-more');
    if (seeMoreButton) {
        seeMoreButton.addEventListener('click', function () {
            const hiddenItems = document.querySelectorAll('.color-item.hidden');
            hiddenItems.forEach(item => {
                item.classList.remove('hidden');
            });
            seeMoreButton.style.display = 'none';
        });
    }
});

$(document).ready(function () {
    let filterData = {
        category: [],
        color: [],
        size: [],
        max: null,
        min: null
    };

    $('#removeFilter').on('click', function () {
        window.location.reload();
    });

    $('#filter').on('click', function () {
        resetFilter();
        $('.category-filter:checked').each(function() {
            filterData.category.push(parseInt($(this).val(), 10));
            filterData.category.push($(this).data("parentcategory"));
        });
        filterData.category = [...new Set(filterData.category)];
        filterData.size = getCheckedValues('.size-filter');
        filterData.color = getCheckedValues('.color-filter');
        filterData.min = parseCurrency($('#minamount').val());
        filterData.max = parseCurrency($('#maxamount').val());
        applyFilters(filterData);
    });


    function applyFilters(filterData) {
        $.ajax({
            url: "/shop/filter-products",
            type: "GET",
            data: filterData,
            beforeSend: function () {
                setFilterButton('Searching...', 'orange', false);
            },
            success: function (response) {
                updateProductList(response);
                setFilterButton('Filtered', 'green', true);
                $('#removeFilter').removeClass('hidden');
            },
            error: function (xhr, status, error) {
                setFilterButton('Filter', 'red', true);
            },
        });
    }

    function setFilterButton(text,color,enabled) {
        $('#filter').text(text);
        $('#filter').css('border-color', color);
        $('#filter').prop('disabled', !enabled);
    }

    function updateProductList(response) {
        let products = response.data;
        let productHtml = '';
        if (products.length === 0) {
            productHtml = '<p class="col-12 text-center">No products found with the selected filters. <br> Click "RESET" to see all products available.</p>';
        }
        products.forEach(product => {
            productHtml += `
                <div class="col-lg-4 col-md-6">
                    <div class=".product__item" <div class=".product__item"  style="cursor: pointer" onclick="window.location='/shop/product/${product.id}'">>
                        <div class="product__item__pic set-bg" data-setbg="${product.img}" style="background-image: url(&quot;${product.img}&quot;);">
                            <div class="label new">New</div>
                            <ul class="product__hover">
                                <li><a href="img/shop/shop-1.jpg" class="image-popup"><span class="arrow_expand"></span></a></li>
                                <li><a href="/shop/product/${product.id}"><span class="icon_bag_alt"></span></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="/shop/product/${product.id}">${product.name}</a></h6>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa=star"></i>
                            </div>
                            <div class="product__price">¥${product.price}</div>
                        </div>
                    </div>
                </div>
            `;
        });
        $('#products-list').html(productHtml);
    }

    function resetFilter() {
        filterData.category = [];
        filterData.color = [];
        filterData.size = [];
        filterData.max = null;
        filterData.min = null;
    }
});
