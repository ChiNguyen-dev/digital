function handleAddToCart(event) {
    // DISABLE TAG <a>
    event.preventDefault();
    const url = $(this).data('url');
    const urlCart = $(this).data('cart');
    const color = $('.color-box span.active_color').data('color');
    $.ajax({
        type: "GET",
        url: url,
        data: {'color_id': color},
        success: function (data) {
            if (data.code === 200) window.location.href = urlCart;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError)
        }
    });
}

function handleDeleteItem() {
    const url = $(this).parent().data('url');
    const that = $(this);
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            if (data.code === 200) {
                that.parent().parent().remove();
                $('.order .total span').text(data.total);
                $('.header-cart .num-cart').text(data.qty);
                if (data.qty === 0) {
                    $('.cart-body').css('display', 'flex')
                    $('#table-cart').css('display', 'none')
                    $('.remind').css('display', 'none')
                    $('.order').css('display', 'none')
                }
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    })
}

function handleDelete() {
    const qty = $(this).val();
    const url = $(this).data('url');
    const data = {qty: qty};
    $.ajax({
        type: 'GET',
        url: url,
        data: data,
        success: function (data) {
            if (data.code === 200) {
                $('.order .total span').text(data.total);
                $('.header-cart .num-cart').text(data.qty);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    })
}

function handleUpdateColor() {
    const url = $(this).data('url');
    const data = {id: $(this).val()};
    $.ajax({
        type: 'GET',
        url: url,
        data: data,
        success: function (data) {
            if (data.code === 200) {
                console.log(data);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

$(document).ready(function () {
    // SHOPPING CART
    $('.add-to-cart').on('click', handleAddToCart);

    if ($('.cart-wp').find('#table-cart').length === 0) $('.cart-body').css('display', 'flex');
    $('.col-remove > i').on('click', handleDeleteItem);

    $('.qty_in_cart').on('change', handleDelete);

    $('.color_in_cart').on('change', handleUpdateColor)
});
