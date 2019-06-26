<?php
/*
Template Name: Turnos
 */
get_header();
$args = array(
    'post_type' => 'turnos',
    'posts_per_page' => -1,
    'meta_key' => 'fechanum',
    'orderby' => 'meta_value',
    'order' => 'ASC',
);

$query = new WP_Query($args);
$hoy = date("d/m/Y");

?>
<div class="container">
    <h1 class="titulo-tabla-turnos">Los turnos de hoy estan resaltados en verde</h1>
<table width="100%" class="tabla">
<tr>
    <th>FECHA</th>
    <th>HORA</th>
    <th>NOMBRE</th>
    <th>IPHONE</th>
    <th>SERVICIO</th>
    <th>PRECIO</th>
    <th>CELULAR CONTACTO</th>
    <th>EMAIL CONTACTO</th>
</tr>
<?php if ($query->have_posts()): while ($query->have_posts()): $query->the_post();?>

        <?php
        /*
$iphone 
    $servicio
    $precio 
    $fecha
    $hora
    $nombre
    $apellido
    $email
    $celular
        */
        $fecha = get_field('fecha');
        if ( $fecha == $hoy) {
            echo '<tr class="green">';
        } else {
            echo "<tr>";
        }
        echo "<td>";
        the_field('fecha');
        echo "</td>";
        echo "<td>";
        the_field('hora');
        echo "</td>";
        echo "<td>";
        the_field('nombre');
        echo " ";
        the_field('apellido');
        echo "</td>";
        echo "<td>";
        the_field('iphone');
        echo "</td>";
        echo "<td>";
        the_field('servicio');
        echo "</td>";
        echo "<td>";
        the_field('precio');
        echo "</td>";
        echo "<td>";
        the_field('celular');
        echo "</td>";
        echo "<td>";
        the_field('email');
        echo "</td>";
        echo "</tr>";
        ?>

		<?php endwhile;else: ?>
	<?php echo '<tr><td colspan="4" class="noTurno">No tienes ningun turno aún.</td></tr>'; ?>
<?php endif;?>
</table>
</div>
<script>
var showButtons = false;
</script>
<?php
get_footer();
?>
