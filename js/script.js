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

function splitScroll() {
    const controller =new ScrollMagic.Controller();

    new ScrollMagic.Scene({
        duration: '100%',
        triggerElement: '',
        triggerHook: 0
    })
    .setPin('')
    .addIndicators()
    .addTo(controller);
}
