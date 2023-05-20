$(document).ready(function () {
    // sidebar
    const sidebar_menu = $('#sidebar-menu > .nav-link > div > i');
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
    const submenu_wrap = $('.sub-menu-wrap');
    $('.dropdown-menu-user > img.logo').click(() => submenu_wrap.toggleClass('open-menu'));
    $('.dropdown-menu-user > .arrow-user').click(() => submenu_wrap.toggleClass('open-menu'));
})
