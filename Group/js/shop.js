'use strict';

$(document).ready(function(){
    $('.t-shirt').slick({
        autoplay: false,
        infinite: true,
        arrows: false,
        dots: true,
        fade: false, // Nice transition for product images
        speed: 500,
        variableWidth:false,
    });
});