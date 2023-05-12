function handleChange() {
    const url = $(this).data("url");
    const id = $(this).val();
    const key = $(this).data("key");
    const token = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        type: "POST",
        headers: { "X-CSRF-TOKEN": token },
        data: { id: id, key: key },
        url: url,
        success: (response) => {
            if (key === "province") {
                const district = $("#district");
                district.attr("disabled", false);
                response.data.map((value, index) =>
                    district.append(
                        `<option value="${value.maqh}">${value.name}</option>`
                    )
                );
            }
            if (key === "district") {
                const ward = $("#ward");
                ward.attr("disabled", false);
                response.data.map((value, index) =>
                    ward.append(
                        `<option value="${value.xaid}">${value.name}</option>`
                    )
                );
            }
        },
        error: (xhr, textStatus, thrownError) =>
            console.log(textStatus, thrownError),
    });
}

$(document).ready(function () {
    $(".choose-address").on("change", handleChange);

    $("#different-address").change(function () {
        const value = $(this).val();
        const url = $(this).data("url");
        const province = $("#province");
        const district = $("#district");
        const ward = $("#ward");
        $.ajax({
            type: "GET",
            url: url,
            success: (response) => {
                $(".append").remove();
                $("#name").attr("value", "");
                $("#phone_number").attr("value", "");
                $("#email").attr("value", "");
                $("#address").attr("value", "");
                province.attr("disabled", false);
                if (value) {
                    province.attr("disabled", true);
                    district.attr("disabled", true);
                    ward.attr("disabled", true);
                    district.text("");
                    ward.text("");
                    province.append(`<option selected class="append">---</option>`);
                    district.append(`<option selected>---</option>`);
                    ward.append(`<option selected>---</option>`);
                    $("#name").attr("value", response.data.name);
                    $("#phone_number").attr("value",response.data.phone_number);
                    $("#email").attr("value", response.data.email);
                    $("#address").attr("value", response.data.address);
                }
            },
            error: (xhr, textStatus, thrownError) =>
                console.log(textStatus, thrownError),
        });
    });
});
