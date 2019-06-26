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

    var horasDisponibles = [
        '10:30', '11:00', '12:00',
        '13:00', '17:30', '18:00',
        '19:00', '20:00'
    ];

    function mostrarHoras(horas) {
        // Si no pasamos el parametro horas se hace el default de horas Disponibles
        if (!horas) {
            horas = [
                '10:30', '11:00', '12:00',
                '13:00', '17:30', '18:00',
                '19:00', '20:00'
            ];
        }
        $('#timepicker').datetimepicker({
            datepicker: false,
            format: 'H:i',
            allowTimes: horas,
            roundTime: 'floor',
            inline: true,
        });
    }
    // Como dice la funcion , si existe un turno en dicha fecha , borramos de las horas disponibles la hora de ese turno
    function borrarHorasSeleccionadas(fecha, horas) {

        // JsonPhp2 esta creado en page-servicios.php de ahi vemos si el objeto JSON tiene la fecha seleccionada
        if (jsonPhp2[fecha] != undefined) {

            // Esto es para que el array usado sea un valor distinto , porque los arrays se pasan by reference
            arrayHoras = horas.concat();

            // Si existe la fecha obtenemos la hora con jsonPhp2[fecha] y la quitamos del array horasDisponibles
            var index = arrayHoras.indexOf(jsonPhp2[fecha]);
            if (index > -1) {
                arrayHoras.splice(index, 1);
            }
            mostrarHoras(arrayHoras);
        } else {
            mostrarHoras();
        }
    }

    // El plugin de jquery "datetimepicker" nos permite elegir las horas disponibles de turnos ( en el array allow times)
    $.datetimepicker.setLocale('es');

    // usamos la app para tiempo aca (a traves de funcion mostrarHoras() y para fecha en el otro , el id selecciona el input en page_turnos.php
    // Mostramos por default el timepicker
    mostrarHoras();

    $('#datepicker').datetimepicker({
        onSelectDate: function(ct, $i) {
            var dia = ct.getDate();
            //Obtenemos el mes en formato ej: 06 (para junio) , sin estas funciones seria 5 , porque cuenta los meses de 0 y sin el 0
            var mes = ("0" + (ct.getMonth() + 1)).slice(-2);
            var año = ct.getFullYear();
            fechaSeleccionada = dia + "/" + mes + "/" + año;
            borrarHorasSeleccionadas(fechaSeleccionada, horasDisponibles);
        },
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