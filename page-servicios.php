<?php
/*
Template Name: Servicio Tecnico
 */
get_header();
$img_path = get_site_url() . "/wp-content/uploads";
$url_path = get_site_url(); 

//------------
//--------Inicio Creador de objeto Json servicios
//------------

//echo $myJSON;
// Guardamos los valores existentes en un array para poder utilizar los condicionales viendo si hay valores repetidos
$iphones_existentes = array();

// Seteamos un array final que sera transformado a json
$array_final = array();

$args = array(
    'post_type' => 'servicios',
    'posts_per_page' => -1,
);

$query = new WP_Query($args);

// Comienza el loop
if ($query->have_posts()): while ($query->have_posts()): $query->the_post();

        $data = array();

        $iphone = get_field('iphone');
        $servicio = get_field('servicio');
        $precio = get_field('precio');

        // Si no esta el modelo de iphone , agregar al nombre del array data y despues agregar al array_final
        if (!in_array($iphone, $iphones_existentes)) {

            $iphones_existentes[] = $iphone;
            $array_final[$iphone][$servicio] = $precio;

        } else { // Si está
            // Ver en que elemento colocar los siguientes valores (capacidad , precio y color)

            // si ya estaba la capacidad subida , agregamos un array color precio a la capacidad repetida
            $array_final[$iphone][$servicio] = $precio;

        }
    endwhile;endif;

// Pasamos los datos del objeto al script de javascript
// JSON_FORCE_OBJECT es para que los arrays se conviertan en {} en vez de []
$myJSON = json_encode($array_final, JSON_FORCE_OBJECT);

//------------
//--------FIN Creador de objeto Json servicios
//------------

?>

<div class="container">

    <form method="post" action="<?php echo $url_path;?>/serviciosubmit" id="form-servicios">
        <p>
            <label for="iphone">Selecciona tu iPhone</label>
            <select name="iphone1" id="iphone" onchange="getServicios(this)">
                <option value="" disabled selected>Selecciona tu iPhone</option>
            </select>
        </p>

        <p>
            <label for="servicio">Selecciona Servicio</label>
            <select name="servicio1" id="servicio" onchange="getPrecio(this)" disabled>
                <option value="" id="predeterminado" disabled selected>Selecciona primero iPhone</option>
            </select>
        </p>

        <p>
            <label for="precio">Precio</label>
            <input type="text" class="precio-servicio" name="precio" id="precio"
                placeholder="Selecciona servicio para ver precio" readonly="readonly">
        </p>
        <div class="container-fechahora">
            <p>
                <label for="fecha">Seleccione Fecha</label>
                <input id="datepicker" type="hidden" name="fecha" id="fecha" value="<?php echo date('d/m/Y'); ?>"
                    readonly="readonly">
            </p>
            <p>
                <label for="fecha">Seleccione Hora</label>
                <input id="timepicker" type="text" name="hora" id="hora" readonly="readonly">
            </p>
        </div>

        <p class="register-nombre">
            <label for="user_nombre">Nombre</label>
            <input type="text" name="nombre" id="user_nombre" class="input" value="" size="50"
                placeholder="Tu Nombre..." />
        </p>
        <p class="register-apellido">
            <label for="user_apellido">Apellido</label>
            <input type="text" name="apellido" id="user_apellido" class="input" value="" size="50"
                placeholder="Tu Apellido..." />
        </p>
        <p>
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" class="input" value="" size="30"
                placeholder="Un email al que te podamos contactar..." />
        </p>
        <p class="register-cel">
            <label for="user_cel">Teléfono celular</label>
            <input type="text" name="celular" id="user_cel" class="input" value=""
                placeholder="Un celular al que te podamos contactar..." />
        </p>
        <p>
            <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary"
                value="SOLICITAR TURNO" />
        </p>

    </form>
</div>
<script>
var showButtons = false;
var jsonPhp = <?php echo $myJSON; ?>;
</script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/servicios.js"></script>
<?php get_footer();?>