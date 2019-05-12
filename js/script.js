// Icono hamburguer efecto
jQuery(document).ready(function($){
	(function () {
        $('.menu-wrapper').on('click', function() {
            $('.hamburger-menu').toggleClass('animate');
            $('.menu-items').slideToggle( function(){
                $('header').toggleClass('background');
                $('body').toggleClass('overflow');
            });
        })
    })();
    (function () {
        $('.titulo-pagina .container span').on('click', function() {
            $('.titulo-pagina .container span svg').toggleClass('rotate');
            $('.caracteristicas').slideToggle();
            // seteamos un timeout para que no desaparezca abruptamente el contenido y se vea mejor
            setTimeout(function(){ $('.iphone, .container-boton-footer').toggleClass('noDisplay'); }, 200);
            
        })
    })();
});

jQuery('.caracteristicas').hide();
var show = typeof showButtons == 'undefined' ? true : false;

if (!show){
    jQuery(".container-boton-footer").css('display','none');
}
