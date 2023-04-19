function handleDelete(event) {
    event.preventDefault();
    const urlRequest = $(this).data('url');
    const id = $(this).data('id');
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
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: urlRequest,
                data: {id: id},
                success: (response) => {
                    console.log(response);
                    that.parent('td').parent('tr').remove();
                    Swal.fire(
                        'Đã xóa!',
                        'Your file has been deleted.',
                        'success'
                    );
                },
                error: (xhr, message, throwError)=> console.log(message, throwError)
            });
        }
    })
}

$(document).ready(function () {
    $(document).on('click', '.btn-delete', handleDelete);
})
