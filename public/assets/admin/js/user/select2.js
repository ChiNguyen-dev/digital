$(function () {
    $('.select2-role').select2({
        allowClear: true,
        placeholder: 'Chọn vai trò',
        tags: true,
        tokenSeparators: [',']
    });
});
