$(document).ready(function () {
    // SCROLL TO TOP
    const btnScrollToTop = $('.scroll-to-top');
    $(window).scroll(function () {
        btnScrollToTop.css('opacity', 1);
        $(this).scrollTop() ? btnScrollToTop.fadeIn() : btnScrollToTop.fadeOut();
    });
    btnScrollToTop.click(function () {
        $('html,body').animate({scrollTop: 0}, 500);
    });

    // CAROUSEL PLUGIN DEFINITION FOR SLIDER
    $('.wp-slider>.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: true,
        responsiveClass: true,
        autoplay: true,
        autoplayTimeout: 5000,
        responsive: {
            0: {
                items: 1,
                nav: false,
                dots: false,

            },
            600: {
                items: 1,
                nav: false,
                dots: false
            },
            1000: {
                items: 1,
                nav: true,
                loop: true
            }
        }
    })
    // CAROUSEL PLUGIN DEFINITION FOR PRODUCT
    $('.owl-carousel.items').owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        dots: true,
        responsiveClass: true,
        autoplay: true,
        autoplayTimeout: 5000,
        responsive: {
            0: {
                items: 1,
                nav: false,
                loop: false, autoplay: false,
            },
            600: {
                items: 2,
                nav: false,
                dots: true
            },
            1000: {
                items: 4,
                nav: true,
                loop: false
            }
        }
    })


    // MENU SIDEBAR
    $('.sidebar-filter > .filter-list > h5').click(function () {
        const main_filter = $(this).parents('.filter-list').parents('.sidebar-filter').find('.filter-list > div');
        main_filter.slideToggle();
        $(this).toggleClass('has-toggle');
        const subMenu = $('.sidebar-filter > .filter-list ul.sub-menu');
        subMenu.slideUp();
        subMenu.removeClass('active');
    });
    $('ul > li > div > span.icon-toggle').click(function () {
        const dataSubMenu = '.' + $(this).data('submenu');
        const menuItem = $(this).parents('div').parents('li').find(dataSubMenu);
        if (!menuItem.hasClass('active')) {
            $(this).parents('div').parents('li').find(dataSubMenu).find('ul.sub-menu').slideUp();
            $(dataSubMenu).removeClass('active');
            $(dataSubMenu).slideUp();
            menuItem.addClass('active');
            menuItem.slideDown();
        } else {
            menuItem.removeClass('active');
            menuItem.slideUp();
        }
    });

    function modal(element) {
        element.mouseover(function () {
            $('.modal').css('display', 'block');
        });
        element.mouseleave(function () {
            $('.modal').css('display', 'none');
        });
    }

    // MODAL
    modal($('.mega-menu .list-menu > li'))
    modal($('.wp__header .header-under .child-content .my-account'));

    // MENU RESPONSIVE
    $('ul.list-menu-responsive li .title i').click(function () {
        const subMenu = $(this).parent('.title').next();
        subMenu.find('ul.sub-menu').slideUp();
        if (subMenu.hasClass('active')) {
            subMenu.removeClass('active');
            subMenu.slideUp();
            $(this).removeClass('fa-minus');
            $(this).addClass('fa-plus');
            subMenu.find('i').removeClass('fa-minus');
            subMenu.find('i').addClass('fa-plus');
        } else {
            $(this).removeClass('fa-plus');
            $(this).addClass('fa-minus');
            subMenu.addClass('active');
            subMenu.slideDown();
        }
    });


    // ANIMATION
    const menuMobile = $('.menu_sidebar_mobile');
    $('.sidebar-title i').click(function () {
        menuMobile.addClass('animate__slideOutLeft');
    })
    $('.icon-respon > i').click(function () {
        menuMobile.css('display', 'block');
        menuMobile.removeClass('animate__slideOutLeft');
        menuMobile.addClass('animate__slideInLeft');
    })

    const search = $('.wp__header .header-under .child-content .header-search');
    const boxSearch = $('.block-search');
    const closeSearch = $('span.btn-close');
    const ul = $('.list-item-search');
    const box_item_search = $('#search-result-print');
    search.click(function () {
        boxSearch.css('display', 'block');
        boxSearch.removeClass('animate__zoomOut');
        boxSearch.addClass('animate__zoomIn');
    });
    closeSearch.click(function () {
        ul.text('');
        box_item_search.css('display', 'none');
        boxSearch.removeClass('animate__zoomIn');
        boxSearch.addClass('animate__zoomOut');
        setTimeout(function () {
            boxSearch.css('display', 'none');
        }, 1000)
    });

    // LOADING
    setTimeout(function () {
        $('#loading').css('display', 'none');
    }, 1500);

    // autocomplete
    $('.block-search > form > input').keyup(function () {
        const url = $(this).data('url');
        const data = {'name': $(this).val()};
        if (data.name !== '') {
            $.ajax({
                url: url,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: data,
                success: function (response) {
                    if (response.code === 200) {
                        box_item_search.css('display', 'block');
                        ul.text('');
                        $.each(response.data, function (index, product) {
                            console.log(product)
                            ul.append(`<li>
                            <a href="">
                                <div class="thumbnail">
                                    <img src="${product.feature_image_path}" alt="">
                                </div>
                                <div class="infor">
                                    <h6>${product.name}</h6>
                                    <div class="span">412.000đ</div>
                                </div>
                            </a>
                        </li>`);
                        })
                    }
                },
                error: function (xhr, ajaxOptions, throwError) {
                    alert(xhr.status);
                    alert(throwError)
                }
            })
        } else {
            ul.text('');
            box_item_search.css('display', 'none');
        }
    });
});
