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

function deleteItem() {
    const url = $(this).parent().data("url");
    const that = $(this);
    const token = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        type: "POST",
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

function updateQuantity() {
    const qty = $(this).val();
    const url = $(this).data("url");
    const data = {qty: qty};
    const token = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        type: "POST",
        headers: {"X-CSRF-TOKEN": token},
        url: url,
        data: data,
        success: (response) => {
            $(".order .total span").text(response.total);
            $(".header-cart .num-cart").text(response.qty);
        },
        error: (xhr, status, thrownError) => console.log(status, thrownError),
    });
}

function updateColor() {
    const url = $(this).data("url");
    const data = {id: $(this).val()};
    const token = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        type: "POST",
        headers: {"X-CSRF-TOKEN": token},
        url: url,
        data: data,
        success: (response) => console.log(response),
        error: (xhr, status, thrownError) => console.log(status, thrownError),
    });
}

$(document).ready(function () {
    $(".add-to-cart").on("click", addToCart);

    $(".col-remove > i").on("click", deleteItem);

    $(".qty_in_cart").on("change", updateQuantity);

    $(".color_in_cart").on("change", updateColor);

    if ($(".cart-wp").find("#table-cart").length === 0)
        $(".cart-body").css("display", "flex");
});
