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
        $('.boton-caracteristicas').on('click', function() {
            $('.boton-caracteristicas svg').toggleClass('rotate');
            window.scrollTo(0,0);
            $('.caracteristicas').fadeToggle();
            // seteamos un timeout para que no desaparezca abruptamente el contenido y se vea mejor
            setTimeout(function(){ $('.iphone, .container-boton-footer,footer').toggleClass('noDisplay'); }, 200);
            
        })
    })();

    (function () {
        $('.faq-titulo').on('click', function() {
            console.log("ok");
            $('.faq-pregunta').slideToggle( function(){
                $('faq-pregunta').css("display","inline");
            });
        })
    })();
});

jQuery('.caracteristicas').hide();
var show = typeof showButtons == 'undefined' ? true : false;

if (!show){
    jQuery(".container-boton-footer").css('display','none');
}
