
<?php
/*
Template Name: Cronologico
 */

$fecha_de_hoy = date('d/m/Y');
$mensajes = array();

function send_mail($mensaje,$to)
{
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from = "info@storecba.com";
    // $to = "info@storecba.com";
    $subject = "Turnos de hoy para servicio ";
    $message = '<html><head></head><body>';
    $message .= $mensaje;
    $message .= '</body></html>';
    $headers = "From:" . $from . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8";

    mail($to, $subject, $message, $headers);

}

// args
$args = array(
    'numberposts' => -1,
    'post_type' => 'turnos',
    'meta_key' => 'fecha',
    'meta_value' => $fecha_de_hoy,
);

// query
$the_query = new WP_Query($args);
?>

<?php if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post();?>

		<?php

        $mensaje = '<p> Turno a las ' . get_field('hora') . ' de ' . get_field('nombre') . ' ' . get_field('apellido') . ' para arreglar ' . get_field('servicio') . ' de un ' . get_field('iphone') . '</p><p>Contacto al numero ' . get_field('celular') . ' o al email ' . get_field('email') . ' </p><br>';

        array_push($mensajes, $mensaje);
        ?>

		<?php endwhile;endif;?>

<?php

$mensaje_email = '<h1>Tienes ' . sizeof($mensajes) . ' Turnos el dia de hoy</h1><br>';

foreach ($mensajes as $mensaje) {
    $mensaje_email .= $mensaje;
}

if (sizeof($mensajes) > 0) {
    echo $mensaje_email;
    send_mail($mensaje_email,"info@storecba.com");
    send_mail($mensaje_email,"cellphonecordoba@gmail.com");
}


?>
