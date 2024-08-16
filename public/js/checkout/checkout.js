$(document).ready(function () {
    $('form').on('submit', function (e) {
        e.preventDefault();
        checkout();
    });

    $('#delivery').on('change', function () {
        addNewOption();
    });

})

function addNewOption() {
    const deliverySelect = $('#delivery');
    const paymentSelect = $('#payment');
    if (deliverySelect.val() == 0) {
        paymentSelect.empty();

        const options = [
            { value: 0, text: '銀行振込 (Bank Transfer)' },
            { value: 1, text: '店頭で支払う (Pay at store)' },
        ];

        options.forEach(option => {
            const newOption = $('<option>', {
                value: option.value,
                text: option.text
            });
            paymentSelect.append(newOption);
        });
    } else {
        paymentSelect.empty();

        const options = [
            { value: 0, text: 'Bank Transfer' },
            { value: 2, text: 'Cash on Delivery - COD' },
        ];

        options.forEach(option => {
            const newOption = $('<option>', {
                value: option.value,
                text: option.text
            });
            paymentSelect.append(newOption);
        });
    }
}

function checkout() {
    $('#checkout-preloader').css('visibility', 'visible');

    const fullName = $('#fullName');
    const prefecture = $('#prefecture');
    const city = $('#city');
    const address = $('#address');
    const buildingName = $('#buildingName') === '' ? 'null' : $('#buildingName').val() ;
    const phoneNumber = $('#phoneNumber');
    const email = $('#email');
    const delivery = $('#delivery');
    const payment = $('#payment');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "/checkout/confirm",
        method: "POST",
        data: {
            _token: csrfToken,
            'fullName': fullName.val(),
            'prefecture': prefecture.val(),
            'city': city.val(),
            'address': address.val(),
            'buildingName': buildingName,
            'phoneNumber': phoneNumber.val(),
            'email': email.val(),
            'delivery': delivery.val(),
            'payment': payment.val(),
        },
        success: function (data) {
            $('#checkout-preloader').css('visibility', 'hidden');
            if (data.message === 'success' && payment.val() == 0) {
                // const imageUrl = "https://api.vietqr.io/image/970436-0941000019966-w4UqEbj.jpg" + data.QR;
                $('#myModal').modal('show');
                // $('#modalImage').attr('src', imageUrl);
            } else {
                window.location.href = '/';
            }
        }
    });
}

function home() {
    window.location.href = '/';
}
