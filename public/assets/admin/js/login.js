$(function () {
    let now = new Date(Date.now());
    let formatted = now.getHours() + ":" + now.getMinutes() + ', ' + now.getDay() + '/' + now.getMonth() + '/' + now.getFullYear();
    $('.signin__date').text(formatted);
    const inputPass = $('.form__group--pass').find('input[type="password"]');
    inputPass.after('<span class="form__group--pass__eye"><i class="fa-regular fa-eye"></i></span>');
    $(document).on('click', '.form__group--pass .form__group--pass__eye', function () {
        const icon = $(this).parent('.form__group--pass').find('i');
        if (icon.hasClass('fa-eye-slash')) {
            inputPass.attr('type', 'password');
            icon.removeClass('fa-eye-slash');
            icon.addClass('fa-eye');
        } else {
            inputPass.attr('type', 'text');
            icon.removeClass('fa-eye');
            icon.addClass('fa-eye-slash');
        }
        return false;
    })
})
