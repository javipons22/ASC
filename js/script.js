// Icono hamburguer efecto
jQuery(document).ready(function($){
	(function () {
        $('.menu-wrapper').on('click', function() {
            $('.hamburger-menu').toggleClass('animate');
            $('.menu-items').toggle("swing", function(){
                $('header').toggleClass('background');
                $('body').toggleClass('overflow');
            });
        })
    })();
});