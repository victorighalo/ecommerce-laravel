(function($) {
    "use strict";

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    }

    function backgroundImage() {
        var databackground = $('[data-background]');
        databackground.each(function() {
            if ($(this).attr('data-background')) {
                var image_path = $(this).attr('data-background');
                $(this).css({
                    'background': 'url(' + image_path + ')'
                });
            }
        });
    }

    function parallax() {
        $('.bg--parallax').each(function() {
            var el = $(this),
                xpos = "50%",
                windowHeight = $(window).height();
            if (isMobile.any()) {
                $(this).css('background-attachment', 'scroll');
            } else {
                $(window).scroll(function() {
                    var current = $(window).scrollTop(),
                        top = el.offset().top,
                        height = el.outerHeight();
                    if (top + height < current || top > current + windowHeight) {
                        return;
                    }
                    el.css('backgroundPosition', xpos + " " + Math.round((top - current) * 0.2) + "px");
                });
            }
        });
    }

    function menuBtnToggle() {
        var toggleBtn = $('.menu-toggle'),
            sidebar = $('.header--left'),
            header2 = $('.header--2'),
            header3 = $('.header--3'),
            menu = $('.menu');
        if (header2.length > 0) {
            toggleBtn.on('click', function() {
                var self = $(this);
                self.toggleClass('active');
                self.closest('.navigation--mobile').find('.menu--2').slideToggle();
            });
        }
        else if (sidebar.length > 0) {
            toggleBtn.on('click', function() {
                var self = $(this);
                self.toggleClass('active');
                self.closest('.header--left').toggleClass('active');
            });
        }
        else if (header3.length > 0) {
            toggleBtn.on('click', function() {
                var self = $(this);
                self.toggleClass('active');
                self.siblings('.menu').slideToggle();
            });
        }
        else {
            toggleBtn.on('click', function() {
                var self = $(this);
                self.toggleClass('active');
                $('.ps-main, .header').toggleClass('menu--active');
                $('.header--sidebar').toggleClass('active');
            });
        }
    }

    function subMenuToggle() {
        var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        if (iOS == false) {
            $('body').on('click', '.header--sidebar .menu .menu-item-has-children > a', function(event) {
                event.preventDefault();
                var current = $(this).parent('.menu-item-has-children')
                current.children('.sub-menu').slideToggle(350);
                current.children('.mega-menu').slideToggle(350);
                current.siblings().find('.sub-menu').slideUp(350);
                current.siblings().find('.mega-menu').slideUp(350);
            });
            $('body').on('click', '.header--left .menu--sidebar .menu-item-has-children > a', function(event) {
                event.preventDefault();
                var current = $(this).parent('.menu-item-has-children')
                current.children('.sub-menu').slideToggle(350);
                current.siblings().find('.sub-menu').slideUp(350);
            });
            $('body').on('click', '.header--2 .menu--2 .menu-item-has-children > a, .header--3 .menu .menu-item-has-children > a', function(event) {
                event.preventDefault();
                var current = $(this).parent('.menu-item-has-children')
                current.children('.sub-menu').slideToggle(350);
                current.siblings().find('.sub-menu').slideUp(350);
            });
        }
        else {
            $('body').on('touchstart', '.header--sidebar .menu .menu-item-has-children > a', function(event) {
                event.preventDefault();
                var current = $(this).parent('.menu-item-has-children')
                current.children('.sub-menu').slideToggle(350);
                current.children('.mega-menu').slideToggle(350);
                current.siblings().find('.sub-menu').slideUp(350);
                current.siblings().find('.mega-menu').slideUp(350);
            });
            $('body').on('touchstart', '.header--left .menu--sidebar .menu-item-has-children > a', function(event) {
                event.preventDefault();
                var current = $(this).parent('.menu-item-has-children')
                current.children('.sub-menu').slideToggle(350);
                current.siblings().find('.sub-menu').slideUp(350);
            });
            $('body').on('touchstart', '.header--2 .menu--2 .menu-item-has-children > a, .header--3 .menu .menu-item-has-children > a', function(event) {
                event.preventDefault();
                var current = $(this).parent('.menu-item-has-children')
                current.children('.sub-menu').slideToggle(350);
                current.siblings().find('.sub-menu').slideUp(350);
            });
        }
    }

    function resizeHeader() {
        var header = $('.header'),
            headerSidebar = $('.header--left'),
            menu = $('.menu'),
            checkPoint = 1200,
            windowWidth = $(window).innerWidth();
        // mobile
        if (checkPoint > windowWidth) {
            menu.find('.sub-menu').hide();
            menu.find('.menu').addClass('menu--mobile');
            menu.prependTo('.header--sidebar');
            $('.ps-sticky').addClass('desktop');
            $('.ps-form--search').prependTo('.header--sidebar');
        }
        else {
            menu.find('.sub-menu').show();
            header.removeClass('shared--mobile');
            $('.header--sidebar .menu').insertAfter('.header .navigation .ps-logo');
            menu.removeClass('menu--mobile');
            $('.header--sidebar').removeClass('active');
            $('.ps-main, .shared').removeClass('menu--active');
            $('.menu-toggle').removeClass('active');
            $('.ps-sticky').removeClass('desktop');
            $('.ps-form--search').insertAfter('.ps-cart');
            if (headerSidebar.length > 0) {
                $('.menu.menu--sidebar').find('.sub-menu').hide();
            }
        }
        /*logo*/
        if (windowWidth < 480) {

        }
        else {

        }
    }

    function stickyHeader() {
        var header = $('.header'),
            scrollPosition = 0,
            headerTopHeight = $('.header .header__top').outerHeight(),
            checkpoint = 300;
        if (header.data('sticky') == true) {
            $(window).scroll(function() {
                var currentPosition = $(this).scrollTop();
                if (currentPosition < scrollPosition) {
                    // On top
                    if (currentPosition == 0) {
                        header.removeClass('navigation--sticky unpin pin');
                        header.css("margin-top", 0);
                    }
                    // on scrollUp
                    else if (currentPosition > checkpoint) {
                        header.removeClass('unpin').addClass('navigation--sticky pin');
                    }
                }
                // On scollDown
                else {
                    if (currentPosition > checkpoint) {
                        header.addClass('navigation--sticky unpin').removeClass('pin');
                        header.css("margin-top", -headerTopHeight);
                    }
                }
                scrollPosition = currentPosition;
            });
        }

    }

    function owlCarousel() {
        var target = $('.owl-slider');
        if (target.length > 0) {
            target.each(function() {
                var el = $(this),
                    dataAuto = el.data('owl-auto'),
                    dataLoop = el.data('owl-loop'),
                    dataSpeed = el.data('owl-speed'),
                    dataGap = el.data('owl-gap'),
                    dataNav = el.data('owl-nav'),
                    dataDots = el.data('owl-dots'),
                    dataAnimateIn = (el.data('owl-animate-in')) ? el.data('owl-animate-in') : '',
                    dataAnimateOut = (el.data('owl-animate-out')) ? el.data('owl-animate-out') : '',
                    dataDefaultItem = el.data('owl-item'),
                    dataItemXS = el.data('owl-item-xs'),
                    dataItemSM = el.data('owl-item-sm'),
                    dataItemMD = el.data('owl-item-md'),
                    dataItemLG = el.data('owl-item-lg'),
                    dataNavLeft = (el.data('owl-nav-left')) ? el.data('owl-nav-left') : "<i class='fa fa-angle-left'></i>",
                    dataNavRight = (el.data('owl-nav-right')) ? el.data('owl-nav-right') : "<i class='fa fa-angle-right'></i>",
                    duration = el.data('owl-duration'),
                    datamouseDrag = (el.data('owl-mousedrag') == 'on') ? true : false;
                el.owlCarousel({
                    animateIn: dataAnimateIn,
                    animateOut: dataAnimateOut,
                    margin: dataGap,
                    autoplay: dataAuto,
                    autoplayTimeout: dataSpeed,
                    autoplayHoverPause: true,
                    loop: dataLoop,
                    nav: dataNav,
                    mouseDrag: datamouseDrag,
                    touchDrag: true,
                    autoplaySpeed: duration,
                    navSpeed: duration,
                    dotsSpeed: duration,
                    dragEndSpeed: duration,
                    navText: [dataNavLeft, dataNavRight],
                    dots: dataDots,
                    items: dataDefaultItem,
                    responsive: {
                        0: {
                            items: dataItemXS
                        },
                        480: {
                            items: dataItemSM
                        },
                        768: {
                            items: dataItemMD
                        },
                        992: {
                            items: dataItemLG
                        },
                        1200: {
                            items: dataDefaultItem
                        }
                    }
                });
            });
        }
    }

    function masonry($selector) {
        var masonryTrigger = $($selector);
        if (masonryTrigger.length > 0) {
            if (masonryTrigger.hasClass('filter')) {
                masonryTrigger.imagesLoaded(function() {
                    masonryTrigger.isotope({
                        columnWidth: '.grid-sizer',
                        itemSelector: '.grid-item',
                        isotope: {
                            columnWidth: '.grid-sizer'
                        },
                        filter: "*"
                    });
                });
                var filters = masonryTrigger.closest('.masonry-root').find('.ps-masonry-filter > li > a');
                filters.on('click', function() {
                    var selector = $(this).attr('data-filter');
                    filters.find('a').removeClass('current');
                    $(this).parent('li').addClass('current');
                    $(this).parent('li').siblings('li').removeClass('current');
                    $(this).closest('.masonry-root').find('.ps-masonry').isotope({
                        itemSelector: '.grid-item',
                        isotope: {
                            columnWidth: '.grid-sizer'
                        },
                        filter: selector
                    });
                    return false;
                });
            }
            else {
                masonryTrigger.imagesLoaded(function() {
                    masonryTrigger.masonry({
                        columnWidth: '.grid-sizer',
                        itemSelector: '.grid-item'
                    });
                });
            }
        }
    }

    function countDown() {
        var time = $(".ps-countdown");
        time.each(function() {
            var el = $(this),
                value = $(this).data('time');
            var countDownDate = new Date(value).getTime();
            var timeout = setInterval(function() {
                var now = new Date().getTime(),
                    distance = countDownDate - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24)),
                    hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
                    minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
                    seconds = Math.floor((distance % (1000 * 60)) / 1000);
                if (el.find('.days').length > 0) {
                    el.find('.days').html(days);
                    if (hours < 10) {
                        el.find('.hours').html("0" + hours);
                    }
                    else {
                        el.find('.hours').html(hours);
                    }
                }
                else {
                    if (days > 0) {
                        el.find('.hours').html(24);
                    }
                    else {
                        el.find('.hours').html(hours);
                    }
                }
                if (minutes < 10) {
                    el.find('.minutes').html("0" + minutes);
                }
                else {
                    el.find('.minutes').html(minutes);
                }
                if (seconds < 10) {
                    el.find('.seconds').html("0" + seconds);
                }
                else {
                    el.find('.seconds').html(seconds);
                }

                if (distance < 0) {
                    clearInterval(timeout);
                }
            }, 1000);
        });
    }

    function rating() {
        $('select.ps-rating').barrating({
            theme: 'fontawesome-stars'
        });
    }

    function mapConfig() {
        $.gmap3({
            key: 'AIzaSyAx39JFH5nhxze1ZydH-Kl8xXM3OK4fvcg'
        });
        var map = $('#contact-map');
        if (map.length > 0) {
            map.gmap3({
                address: map.data('address'),
                zoom: map.data('zoom'),
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: false,
            }).marker(function(map) {
                return {
                    position: map.getCenter(),
                    icon: 'images/marker.png',
                    animation: google.maps.Animation.BOUNCE
                };
            }).infowindow({
                content: map.data('address')
            }).then(function(infowindow) {
                var map = this.get(0);
                var marker = this.get(1);
                marker.addListener('click', function() {
                    infowindow.open(map, marker);
                });
            });
        }
        else {
            console.log("Notice: Don't have map on this page!!!");
        }
    }

    function slickConfig() {
        if ($('.ps-product--detail').length > 0) {
            var primary = $('.ps-product__image'),
                second = $('.ps-product__variants'),
                vertical;
            if ($('.ps-product--detail').hasClass('second')) {
                vertical = false
            }
            else {
                vertical = true;
            }

            primary.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: '.ps-product__variants',
                dots: false,
                arrows: false,

            });
            second.slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: false,
                arrow: false,
                focusOnSelect: true,
                asNavFor: '.ps-product__image',
                vertical: vertical,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            arrows: false,
                            slidesToShow: 4,
                            vertical: false
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 3,
                            vertical: false
                        }
                    },
                ]
            });
        }
    }

    function productVariants() {
        var variants = $('.ps-product .ps-product__variants');
        variants.each(function() {
            var $this = $(this);
            if ($this.find('.item').length > 5) {
                $this.owlCarousel({
                    margin: 10,
                    autoplay: false,
                    autoplayTimeout: 1000,
                    loop: false,
                    nav: true,
                    autoplaySpeed: 800,
                    navSpeed: 650,
                    dragEndSpeed: 650,
                    navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
                    items: 5,
                    responsive: {
                        0: {
                            items: 3
                        },
                        480: {
                            items: 4
                        },
                        768: {
                            items: 5
                        },
                        992: {
                            items: 5
                        },
                        1200: {
                            items: 5
                        }
                    }
                })
            }
        });

    }

    function bootstrapSelect() {
        $('select.ps-select').selectpicker();
    }

    function inputNumberChange() {
        var number = $('.ps-number');
        number.each(function() {
            var el = $(this),
                numberValue = el.find('input').val();
            el.find('.up').on('click', function(e) {
                e.preventDefault();
                numberValue++;
                el.find('input').val(numberValue);
                el.find('input').attr('value', numberValue);
            });
            el.find('.down').on('click', function(e) {
                e.preventDefault();
                if (numberValue > 1) {
                    numberValue--;
                    el.find('input').val(numberValue);
                    el.find('input').attr('value', numberValue);
                }

            })
        });
        $('.form-group--number').each(function() {
            var el = $(this),
                numberValue = el.find('input').val();
            el.find('.plus').on('click', function(e) {
                e.preventDefault();
                numberValue++;
                el.find('input').val(numberValue);
                el.find('input').attr('value', numberValue);
            });
            el.find('.minus').on('click', function(e) {
                e.preventDefault();
                if (numberValue > 1) {
                    numberValue--;
                    el.find('input').val(numberValue);
                    el.find('input').attr('value', numberValue);
                }

            })
        });
    }

    function productFilterToggle() {
        $('.ps-filter__trigger').on('click', function(e) {
            e.preventDefault();
            var el = $(this);
            el.find('.ps-filter__icon').toggleClass('active');
            el.closest('.ps-filter').find('.ps-filter__content').slideToggle();
        });
    }

    function bannerSync() {
        var banner = $('.ps-fashion3--banner'),
            windowWidth = $(window).innerWidth();
        if (banner.length > 0) {
            var list = banner.find('.right .ps-list--banner'),
                bannerHeight = banner.find('.left').innerHeight(),
                listItem = list.find('li a'),
                owl = $('.ps-slider--fashion3');
            if (windowWidth > 1200) {
                listItem.css('height', bannerHeight / 5);
            }
            else {
                listItem.css('height', 'auto');
            }

            list.find('li').each(function(index, el) {
                var link = $(this).find('a');
                link.on('click', function(event) {
                    event.preventDefault();
                    link.closest('li').addClass('active');
                    link.closest('li').siblings('li').removeClass('active');
                    owl.trigger('to.owl.carousel', [index, 500, true]);
                });
            });
        }
    }

    function filterSlider() {
        var el = $('.ps-slider');
        var min = el.siblings().find('.ps-slider__min');
        var max = el.siblings().find('.ps-slider__max');
        var defaultMinValue = el.data('default-min');
        var defaultMaxValue = el.data('default-max');
        var maxValue = el.data('max');
        var step = el.data('step');
        if (el.length > 0) {
            el.slider({
                min: 0,
                max: maxValue,
                step: step,
                range: true,
                values: [defaultMinValue, defaultMaxValue],
                slide: function(event, ui) {
                    var values = ui.values;
                    min.text('$' + values[0]);
                    max.text('$' + values[1]);
                }
            });
            var values = el.slider("option", "values");
            console.log(values[1]);
            min.text('$' + values[0]);
            max.text('$' + values[1]);
        }
        else {
            // return false;
        }
    }

    function productLightbox() {
        $('.ps-product__image').lightGallery({
            selector: '.item a',
            thumbnail: true
        });
        $('.ps-video').lightGallery();
    }

    function accordion() {
        $('.ps-accordion').find('.ps-accordion__content').hide();
        $('.ps-accordion.active').find('.ps-accordion__content').show();
        $('.ps-accordion .ps-accordion__header').on('click', function(e) {
            e.preventDefault();
            var hasSub = $(this).closest('.ps-accordion');
            if (hasSub.hasClass('active')) {
                hasSub.removeClass('active');
                hasSub.find('.ps-accordion__content').slideUp(350);
            }
            else {
                hasSub.addClass('active');
                hasSub.find('.ps-accordion__content').slideDown(350);
            }
            hasSub.siblings('.ps-accordion').removeClass('active');
            hasSub.siblings('.ps-accordion').find('.ps-accordion__content').slideUp(350);
        });
    }

    function handleModal() {
        var modal_link = $('.ps-modal-open');
        modal_link.on('click', function(e) {
            e.preventDefault();
            var $this = $(this),
                target = $this.attr('href');
            if ($('' + target).length > 0) {
                $('' + target).addClass('active');
            }
            else {
                console.log("Modal not found!");
            }
        })
        $('.ps-modal__close').on('click', function(e) {
            e.preventDefault();
            $(this).closest('.ps-modal').removeClass('active');
        })
    }

    function productThumbnailChange() {
        var originImageData;
        $('.ps-product__variants .item').on('click', function() {
            var image = $(this).find('img').attr('src');
            console.log(image);
            var originImage = $(this).closest('.ps-product').find('.ps-product__thumbnail > img');
            originImageData = originImage.attr('src');
            originImage.attr('src', image);
        });
    }

    $(document).ready(function() {
        backgroundImage();
        parallax();
        bootstrapSelect();
        menuBtnToggle();
        subMenuToggle();
        masonry('.ps-masonry');
        stickyHeader();
        mapConfig();
        rating();
        countDown();
        slickConfig();
        productVariants();
        inputNumberChange();
        productFilterToggle();
        filterSlider();
        productLightbox();
        accordion();
        handleModal();
        productThumbnailChange();
    });

    $(window).on('load', function() {
        owlCarousel();
        $('.ps-loading').addClass('loaded');
    });

    $(window).on('load resize', function() {
        resizeHeader();
        bannerSync();
    });
})(jQuery);
