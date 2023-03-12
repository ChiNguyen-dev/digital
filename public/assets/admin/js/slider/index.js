function handleDelete(event) {
    event.preventDefault();
    const urlRequest = $(this).data('url');
    const that = $(this);
    Swal.fire({
        title: 'Bạn có chắc không?',
        text: "Bạn sẽ không thể khôi phục nó lại!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Hủy bỏ',
        confirmButtonText: 'Xóa!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: urlRequest,
                success: function (data) {
                    console.log(data)
                    if (data.code === 200) {
                        that.parent('td').parent('tr').remove();
                    }
                    Swal.fire(
                        'Đã xóa!',
                        'Your file has been deleted.',
                        'success'
                    )
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError)
                }
            });
        }
    })
}

$(document).ready(function () {
    $(this).on('click', '.btn-delete', handleDelete);
})
