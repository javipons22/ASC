// Icono hamburguer efecto
jQuery(document).ready(function($) {
    (function() {
        $('.menu-wrapper').on('click', function() {
            $('.hamburger-menu').toggleClass('animate');
            $('.menu-items').slideToggle(function() {
                $('header').toggleClass('background');
                $('body').toggleClass('overflow');
            });
        })
    })();
    (function() {
        $('.boton-caracteristicas').on('click', function() {
            $('.boton-caracteristicas svg').toggleClass('rotate');
            window.scrollTo(0, 0);
            $('.caracteristicas').fadeToggle();
            // seteamos un timeout para que no desaparezca abruptamente el contenido y se vea mejor
            setTimeout(function() { $('.iphone, .container-boton-footer,footer').toggleClass('noDisplay'); }, 200);

        })
    })();

    (function() {
        $('.faq-titulo').on('click', function() {
            console.log("ok");
            $('.faq-pregunta').slideToggle(function() {
                $('faq-pregunta').css("display", "inline");
            });
        })
    })();


    // El plugin de jquery "datetimepicker" nos permite elegir las horas disponibles de turnos ( en el array allow times)
    $.datetimepicker.setLocale('es');
    // usamos la app para tiempo aca y para fecha en el otro , el id selecciona el input en page_turnos.php
    $('#timepicker').datetimepicker({
        datepicker: false,
        format: 'H:i',
        allowTimes: [
            '10:30', '11:00', '12:00',
            '13:00', '17:30', '18:00',
            '19:00', '20:00'
        ],
        roundTime: 'floor',
        inline: true,
    });

    $('#datepicker').datetimepicker({
        timepicker: false,
        format: 'd/m/Y',
        minDate: 0, // para que la fecha minima sea hoy
        disabledWeekDays: [0],
        inline: true
    });

});

jQuery('.caracteristicas').hide();
var show = typeof showButtons == 'undefined' ? true : false;

if (!show) {
    jQuery(".container-boton-footer").css('display', 'none');
}