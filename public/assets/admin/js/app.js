$(document).ready(function () {
    // sidebar
    let sidebar_menu = $('#sidebar-menu > .nav-link > div > i');
    sidebar_menu.on('click', function () {
        if (!$(this).parent().parent().hasClass('active')) {
            $('.sub-menu').slideUp();
            $('#sidebar-menu .nav-link i').removeClass('active');
            $(this).parent().parent().find('.sub-menu').slideDown();
            $('#sidebar-menu .nav-link').removeClass('active');
            $(this).parent().parent().addClass('active');
            if ($(this).parent().parent().find('.sub-menu').length !== 0) $(this).addClass('active');
            return false;
        } else {
            $('.sub-menu').slideUp();
            $('#sidebar-menu .nav-link i').removeClass('active');
            $(this).parent().parent().removeClass('active');
            return false;
        }
    });
    $('.select2-role').select2({
        allowClear: true,
        placeholder: 'Chọn vai trò',
        tags: true,
        tokenSeparators: [',']
    });
})
