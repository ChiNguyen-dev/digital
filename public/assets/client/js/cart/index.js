function addToCart(event) {
    event.preventDefault();
    const url = $(this).data("url");
    const urlCart = $(this).data("cart");
    const color = $(".color-box span.active_color").data("color");
    const token = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        type: "POST",
        headers: {"X-CSRF-TOKEN": token},
        url: url,
        data: {color_id: color},
        success: (response) => {
            $(".header-cart .num-cart").text(response.quantity);
            if (response.isLogin) (window.location.href = urlCart)
        },
        error: (xhr, status, thrownError) => console.log(status, thrownError),
    });
}

function remove() {
    const url = $(this).parent().data("url");
    const that = $(this);
    const token = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        type: "DELETE",
        headers: {"X-CSRF-TOKEN": token},
        url: url,
        success: (response) => {
            that.parent().parent().remove();
            $(".order .total span").text(response.total);
            $(".header-cart .num-cart").text(response.qty);
            if (response.qty === 0) {
                $(".cart-body").css("display", "flex");
                $("#table-cart").css("display", "none");
                $(".remind").css("display", "none");
                $(".order").css("display", "none");
            }
        },
        error: (xhr, status, thrownError) => console.log(status, thrownError),
    });
}

function changeQuantity() {
    const qty = $(this).val();
    const url = $(this).data("url");
    const data = {qty: parseInt(qty)};
    const token = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        type: "PUT",
        headers: {"X-CSRF-TOKEN": token},
        url: url,
        data: data,
        success: (response) => {
            console.log(response)
            $(".order .total span").text(response.total);
            $(".header-cart .num-cart").text(response.qty);
        },
        error: (xhr, status, thrownError) => console.log(status, thrownError),
    });
}

function changeColor() {
    const url = $(this).data("url");
    const data = {color_id: parseInt($(this).val())};
    const token = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        type: "PUT",
        headers: {"X-CSRF-TOKEN": token},
        url: url,
        data: data,
        success: (response) => console.log(response),
        error: (xhr, status, thrownError) => console.log(status, thrownError),
    });
}

$(document).ready(function () {
    $(".add-to-cart").on("click", addToCart);

    $(".col-remove > i").on("click", remove);

    $(".qty_in_cart").on("change", changeQuantity);

    $(".color_in_cart").on("change", changeColor);

    if ($(".cart-wp").find("#table-cart").length === 0) $(".cart-body").css("display", "flex");
});
