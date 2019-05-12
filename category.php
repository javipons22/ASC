<?php
get_header();
$img_path = get_site_url() . "/wp-content/uploads";

//echo $myJSON;
// Guardamos los valores existentes en un array para poder utilizar los condicionales viendo si hay valores repetidos
$iphones_existentes = array();
$capacidades_existentes = array();
$array_final = array();
$precio_max_min = array();

// Comienza el loop
if (have_posts()): while (have_posts()): the_post();

        $data = array();
        /*
        MODELO DE ARRAY PARA PASAR A JSON

        $data = array('modelo'=> 'iPhone 7 Plus',
        'capacidad'=> array('32GB' => array( 'color'=> 'Space Gray',
        'precio' => 12999),
        '128GB' => array('color'=> 'Green',
        'precio' => 59999)));
         */
        $modelo = get_field('iphone');
        $capacidad = get_field('capacidad');
        $color = get_field('color');
        $precio = get_field('precio');
        $solo_efectivo = get_field('solo_efectivo');

        $color_precio = array('color' => $color, 'precio' => $precio, 'soloEfectivo' => $solo_efectivo);

        // Precio max min para el subtitulo de la pagina
        $precio_max_min[] = (int) $precio;

        // Si no esta el modelo de iphone , agregar al nombre del array data y despues agregar al array_final
        if (!in_array($modelo, $iphones_existentes)) {

            $iphones_existentes[] = $modelo;
            $capacidades_existentes[] = $capacidad;
            $data['modelo'] = $modelo;

            // agrega array associative
            $data['capacidad'] = array($capacidad => array($color_precio));

            $array_final[] = $data;

        } else { // Si está
            // Ver en que elemento colocar los siguientes valores (capacidad , precio y color)

            for ($i = 0; $i < sizeof($array_final); $i++) {
                if ($array_final[$i]['modelo'] == $modelo) {
                    $index = $i; // Es el index del producto actual donde esta el modelo que nos paso wordpress (en el caso de iphone 7 hay 2 , iphone 7 y iphone 7 plus)
                }
            }

            if (!in_array($capacidad, $capacidades_existentes)) {
                //Pasamos el index donde esta el elemento actual
                $array_final[$index]['capacidad'][$capacidad] = array($color_precio);
                $capacidades_existentes[] = $capacidad;

            } else {
                // si ya estaba la capacidad subida , agregamos un array color precio a la capacidad repetida
                $array_final[$index]['capacidad'][$capacidad][] = $color_precio;
            }
        }
    endwhile;endif;

// Pasamos los datos del objeto al script de javascript
// JSON_FORCE_OBJECT es para que los arrays se conviertan en {} en vez de []
$myJSON = json_encode($array_final, JSON_FORCE_OBJECT);

// Obtenemos el slug de la categoria para seleccionar imagen
function quita_guiones($cadena)
{
    $cadena = str_replace('-', '', $cadena);
    return $cadena;
}

$term = get_queried_object();
$slug = quita_guiones($term->slug);
?>


<div class="titulo-pagina">
    <div class="container">
        <h1><?php single_cat_title()?></h1>
        <span>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                <g>
                    <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"/>
                </g>
            </svg>
            características
        </span>
    </div>
    <div class="container">
        <div class="caracteristicas">
            
        </div>

    </div>
</div>

<section class="iphone">
    <div class="flex iphone-cat">
        <div class="titulo-iphone-movil">
            <h1>Compra <?php single_cat_title()?></h1>
            <span>
                <h2><?php

if (sizeof($precio_max_min) > 1) {
    echo "De $" . min($precio_max_min) . " a $" . max($precio_max_min);
} else {
    echo "A solo $" . min($precio_max_min);
}

?> <br>También en 12, 6 o 3 cuotas**</h2>
            </span>
        </div>
        <div class="imagen-cat">
            <img id="imagen" src="<?php echo $img_path . "/iphone/" . strtolower($slug) . ".png"; ?>" alt="iphone">
        </div>
        <div class="datos-iphone-cat">
            <div class="titulo-iphone-cat">
                <h1>Compra <?php single_cat_title()?></h1>
                <span>
                    <h2><?php

if (sizeof($precio_max_min) > 1) {
    echo "De $" . min($precio_max_min) . " a $" . max($precio_max_min);
} else {
    echo "A solo $" . min($precio_max_min);
}

?> <br>También en 12, 6 o 3 cuotas**</h2>
                </span>
            </div>
            <ul>
                <li id="modelo">
                    <h3>Elige modelo</h3>
                    <ul>
                    </ul>
                </li>
                <li id="capacidad">
                    <h3>Elige la capacidad</h3>
                    <ul>
                    </ul>
                </li>
                <li id="color">
                    <h3>Elige color</h3>
                    <ul>
                    </ul>
                </li>
                <li id="cuotas">
                    <h3>Elige cuotas</h3>
                    <ul>
                    </ul>
                </li>
                <li id="precio">
                    <h3>TOTAL</h3>
                    <ul>

                    </ul>
                </li>
            </ul>
        </div>
    </div>

</section>


<script>
// VARIABLES PHP A JS
var jsonPhp = <?php echo $myJSON; ?>;
var imgPath = "<?php echo $img_path; ?>";

</script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/iphone6.js";></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/iphone.js";></script>

<?php get_footer();?>
