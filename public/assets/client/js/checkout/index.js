function handleChange() {
    const url = $(this).data('url');
    const id = $(this).val();
    const type = $(this).data('type');
    $.ajax({
        type: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'id': id, 'type': type},
        url: url,
        success: function (data) {
            console.log(data)
            if (type === 1) {
                $('#district').find('option').remove();
                data.data.map(function (v, i) {
                    $('#district').append(`<option value="${v.maqh}">${v.name}</option>`)
                })
            }
            if (type === 2) {
                $('#ward').find('option').remove();
                data.data.map(function (v, i) {
                    $('#ward').append(`<option value="${v.xaid}">${v.name}</option>`)
                })
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError)
        }
    });
}

$(document).ready(function () {
    $('.select-address').on('change', handleChange)
});
