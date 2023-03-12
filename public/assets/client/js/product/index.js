$(document).ready(function () {
    $('.sort-by-select > select').change(function () {
        window.location.href = $(this).val();
    });
    // IMAGE DETAIL PRODUCT
    const thumbnail = $('.carousel-detail ul.thumbnail-main li.carousel__thumbnail-item');
    thumbnail.click(function () {
        thumbnail.removeClass('active');
        const image = $(this).find('img').attr('src');
        $(this).addClass('active');
        $('.slider__detail .thumbnail-item img').attr('src', image);
    });
    $('.slider__detail .next-prev .btn-next').click(function (event) {
        event.preventDefault();
        $('.carousel-detail ul.thumbnail-main li.carousel__thumbnail-item.active').next().click();
    });
    $('.slider__detail .next-prev .btn-prev').click(function (event) {
        event.preventDefault();
        $('.carousel-detail ul.thumbnail-main li.carousel__thumbnail-item.active').prev().click();
    });
    // ZOOM IMAGE
    // $('.slider__detail .thumbnail-item img').imagezoomsl(function () {
    //     zoomrange:[3, 3];
    // });

    // VIEW MORE DESCRIPTION PRODUCT
    $('.more').click(function () {
        const descMain = $('#desc-product');
        const icon = $(this).find('i');
        const titleBtn = $(this).find('span');
        if (descMain.hasClass('active')) {
            descMain.removeClass('active');
            descMain.css("max-height", "1620px");
            titleBtn.text('Xem thêm đặc điểm nổi bật');
            icon.removeClass('fa-caret-up');
            icon.addClass('fa-caret-down');
        } else {
            descMain.addClass('active');
            titleBtn.text('Thu gọn đặc điểm nổi bật');
            icon.removeClass('fa-caret-down');
            icon.addClass('fa-caret-up');
            descMain.css('max-height', '50000px');
        }
    });

    // CHOOSE COLOR PRODUCT
    $('.color-box span i').click(function () {
        $('.color-box span').removeClass('active_color');
        $(this).parent().addClass('active_color');
    });
});
