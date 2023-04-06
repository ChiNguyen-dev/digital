$(function () {
    const animateIn = "animate__zoomIn";
    const animateOut = "animate__zoomOut";
    const modelAddressElement = $(".modal-address");
    const op_addressElement = $(".op_address.opened");

    $(".title-head button").click(function () {
        modelAddressElement.removeClass(animateOut);
        modelAddressElement.addClass(animateIn);
        modelAddressElement.css("display", "block");
        op_addressElement.css("display", "block");
    });

    $(".pop_bottom .btn-row .btn-close").click(function () {
        modelAddressElement.removeClass(animateIn);
        modelAddressElement.addClass(animateOut);
        setTimeout(() => {
            modelAddressElement.css("display", "none");
            op_addressElement.css("display", "none");
        }, 500);
    });

    $(".closed_pop > i").click(function () {
        modelAddressElement.removeClass(animateIn);
        modelAddressElement.addClass(animateOut);
        setTimeout(() => {
            modelAddressElement.css("display", "none");
            op_addressElement.css("display", "none");
        }, 500);
    });
});
