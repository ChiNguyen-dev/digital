function chooseAddress() {
    const value = $(this).val();
    const url = $(this).data("url");
    const key = $(this).data("key");
    const token = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        type: "post",
        headers: { "X-CSRF-TOKEN": token },
        data: { id: value, key: key },
        url: url,
        success: (response) => {
            console.log(response);
            if (key == "province") {
                const district = $("#district");
                district.find("option").remove();
                district.attr('disabled', false);
                response.data.map((value, index) => {
                    district.append(
                        `<option value="${value.maqh}">${value.name}</option>`
                    );
                });
            }
            if (key == "district") {
                const ward = $("#ward");
                ward.find("option").remove();
                ward.attr('disabled', false);
                response.data.map((value, index) => {
                    ward.append(
                        `<option value="${value.xaid}">${value.name}</option>`
                    );
                });
            }
        },
        error: (xhr, textStatus, errorThrown) =>
            console.log(textStatus, errorThrown),
    });
}

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

    $("#email").change(function () {
        const value = $(this).val();
        const url = $(this).data("url");
        const data = { email: value };
        const token = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            type: "POST",
            headers: { "X-CSRF-TOKEN": token },
            data: data,
            url: url,
            success: (response) => {
                console.log(response.message);
                $("#error-email").css("display", "none");
                $(".btn-sm").attr("disabled", false);
            },
            error: (xhr, textStatus, errorThrown) => {
                console.log(xhr.responseJSON.message,textStatus, errorThrown);
                if (xhr.status == 422) {
                    $("#error-email").text(xhr.responseJSON.message);
                    $("#error-email").css("display", "block");
                    $(".btn-sm").attr("disabled", true);
                }
            },
        });
    });

    $("#province").on("change", chooseAddress);
    $("#district").on("change", chooseAddress);
});
