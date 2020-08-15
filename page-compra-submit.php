<?php
/*
Template Name: Compra Submit
 */
get_header();
$img_path = get_site_url() . "/wp-content/uploads";
$url_path = get_site_url();


function send_mail($nombre, $apellido, $email, $celular, $iphone, $precio)
{
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from = "info@storecba.com";
    $to = "info@storecba.com";
    $subject = $nombre . " Ha comprado un " . $iphone;
    $message = '<html><head></head><body>';
    $message .= '<p>' . $nombre . " " . $apellido . " compró un " . $iphone . " por $" . $precio . "</p>";
    $message .= '<p> Datos de contacto: email ' . $email . " - celular " . $celular . "</p>";
    $message .= '</body></html>';
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
    $iphone = $wpdb->escape($_POST['modelo-iphone']);
    $precio = $wpdb->escape($_POST['modelo-precio']);
    $nombre = $wpdb->escape($_POST['nombre']);
    $apellido = $wpdb->escape($_POST['apellido']);
    $email = $wpdb->escape($_POST['contact-email']);
    $celular = $wpdb->escape($_POST['celular']);


    if (empty($nombre) || empty($apellido) || empty($email) || empty($celular)) {
        array_push($error, "Faltan completar campos del formulario , por favor complete todos");
    }

    if (count($error) == 0) {
        send_mail($nombre, $apellido, $email, $celular, $iphone, $precio);
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
    <h1>No se envió tu compra</h1>
    <div id="errores">

        <?php foreach ($error as $errores) {
    echo '<p class="errores-form-submit">' . $errores . '</p>';
}
?>
    </div>
    <?php elseif ($_POST): 
     $urlToGo = $_POST['url'];    
    ?>
        <script>
        var url = "<?php echo $urlToGo;?>?status=true";
        window.location.href = url;
        </script>
    <?php else: ?>
    <h1>Completa el Formulario</h1>
    <?php endif;?>
</div>
<script>
var showButtons = false;

</script>
<?php get_footer();?>