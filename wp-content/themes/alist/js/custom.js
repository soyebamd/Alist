/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

$(document).ready(function () {
    var sidebar = $('div.sidebar-nav');
    var innerPage = $('div.inner-page-content');
    var sidebarNavHeight = sidebar.height();
    var innerPageHeight = innerPage.height();
    if(sidebarNavHeight > innerPageHeight){
        sidebar.css('height', innerPageHeight);
        sidebar.css('overflow-y', 'scroll');
    }
    
//    $('.scrollbar-inner').scrollbar();
    
    $("#owl-demo").owlCarousel({
        items: 8,
        lazyLoad: true,
        navigation: true
    });
});

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

$(".mobile-nav li.menu-item-has-children").click(function () {
    $(this).children("ul").toggle(500);
});
$(".sidebar-toggle a").click(function () {
    $(".sidebar-nav ul").toggle(500);
});



$(window).scroll(function () {
    if ($(this).scrollTop() > 148) {
        $('.sidebar-nav').addClass("fixed-sidebar");
    }
    else {
        $('.sidebar-nav').removeClass("fixed-sidebar");
    }
});


$(document).ready(function () {
    /* Check width on page load*/
    if ($(window).width() < 767) {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 217) {
                $('.sidebar-nav').addClass("fixed-sidebar");
            }
            else {
                $('.sidebar-nav').removeClass("fixed-sidebar");
            }
        });
    }
});

$(".menu ul li.menu-item-has-children").hover(function () {
    $('.overly-img').show();
}, function () {
    $('.overly-img').hide();
});

$('#testimonials-slider, #carousel-example-generic').carousel({
    interval: 4000
});

$(document).ready(function () {
  $( 'p:empty' ).remove();
});

$(document).ready(function () {
  $(".jobs-container div:odd").css({"background-color": "rgba(176, 178, 174, 0.11)", "margin-bottom": "2%", "margin-top": "2%", "padding-top": "2%", "padding-bottom": "2%"});
});