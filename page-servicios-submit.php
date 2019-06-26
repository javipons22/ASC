<?php
/*
Template Name: Servicio Submit
 */
get_header();
$img_path = get_site_url() . "/wp-content/uploads";
$url_path = get_site_url();

//------------
//--------Inicio Funcion crear turno
//------------

function crear_turno($titulo, $fecha, $hora, $nombre, $apellido, $iphone, $servicio, $precio, $celular, $email, $fechanum)
{

    $my_post = array(
        'post_title' => $titulo,
        'post_type' => 'turnos',
        'post_status' => 'publish',
    );

    // Insert the post into the database
    $post_id = wp_insert_post($my_post);

    update_field('fecha', $fecha, $post_id);
    update_field('hora', $hora, $post_id);
    update_field('nombre', $nombre, $post_id);
    update_field('apellido', $apellido, $post_id);
    update_field('iphone', $iphone, $post_id);
    update_field('servicio', $servicio, $post_id);
    update_field('precio', $precio, $post_id);
    update_field('celular', $celular, $post_id);
    update_field('email', $email, $post_id);
    update_field('fechanum', $fechanum, $post_id);

}

//------------
//--------Inicio Funcion enviar email
//------------

function send_mail()
{
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from = "info@applestorecordoba.com";
    $to = $email;
    $subject = "Turno para servicio tecnico de Apple Store Cordoba";
    $message = $nombre . " tienes turno el día " . $fecha . " a las " . $hora . " para arreglar tu " . $iphone . ". Cualquier consulta comunicate al telefono 3512140570. Gracias!";
    $headers = "From:" . $from . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8";

    mail($to, $subject, $message, $headers);

}

//------------
//--------Inicio Obtenedor de datos de formulario
//------------
global $wpdb;

// Inicializamos un array para hacer append de errores
$error = array();

if ($_POST) {

    // Hacemos escape para prevenir cross site scripting
    $iphone = $wpdb->escape($_POST['iphone1']);
    $servicio = $wpdb->escape($_POST['servicio1']);
    $precio = $wpdb->escape($_POST['precio']);
    $fecha = $wpdb->escape($_POST['fecha']);
    $hora = $wpdb->escape($_POST['hora']);
    $nombre = $wpdb->escape($_POST['nombre']);
    $apellido = $wpdb->escape($_POST['apellido']);
    $email = $wpdb->escape($_POST['email']);
    $celular = $wpdb->escape($_POST['celular']);

    // Convertimos la fecha en numero para poder ordenarlos en la pagina turnos
    if (!empty($fecha) && !empty($hora)) {
        $fecha_hora = $fecha . ' ' . $hora . ':00';
        $format = "d/m/Y H:i:s";
        $dateobj = DateTime::createFromFormat($format, $fecha_hora);
       
        $iso_datetime = $dateobj->format(Datetime::ATOM);
        $fechanum = strtotime($iso_datetime);
    } else {
        array_push($error, "Complete fecha y hora!");
    }
  

    if (empty($iphone) || empty($servicio) || empty($precio) || empty($fecha) || empty($hora) || empty($nombre) || empty($apellido) || empty($email) || empty($celular)) {
        array_push($error, "Faltan completar campos del formulario , por favor complete todos");
    }

    if (!is_email($email)) {
        array_push($error, "El email no es válido");
    }

    if (!empty($celular) && !is_numeric($celular)) {
        array_push($error, "El numero de teléfono celular debe contener numeros solamente");
    }

    if (count($error) == 0) {
        $titulo = $fecha . " - " . $iphone . " - " . $servicio . " - " . $nombre . " " . $apellido;
        //send_mail();
        crear_turno($titulo, $fecha, $hora, $nombre, $apellido, $iphone, $servicio, $precio, $celular, $email,$fechanum);
    }

}
//------------
//--------FIN Obtenedor de datos de formulario
//------------

?>
<div class="container servicio-submit">
    <?php
if (count($error) !== 0):
?>
    <h1>No se envió tu turno</h1>
    <div id="errores">

        <?php foreach ($error as $errores) {
    echo '<p class="errores-form-submit">' . $errores . '</p>';
}
?>
    </div>
    <?php elseif ($_POST): ?>
    <h1>Tu turno se envió correctamente!</h1>
    <div id="no-errores">
    <p class="elemento-form-submit"> Traé tu <?php echo $iphone; ?> el dia <?php echo $fecha; ?> a las <?php echo $hora; ?> al <b> local adentro del supermercado Disco, Av. Recta Martinolli 7120</b> </p>
    <p class="elemento-form-submit">Te enviamos los datos del turno al email: <?php echo $email; ?></p>
    </div>
    <?php else: ?>
    <h1>Completa el Formulario</h1>
    <?php endif;?>
</div>
<script>
var showButtons = false;
</script>
<?php get_footer();?>