<?php
get_header();
$img_path = get_site_url() . "/wp-content/uploads";

//echo $myJSON;
// Guardamos los valores existentes en un array para poder utilizar los condicionales viendo si hay valores repetidos
$iphones_existentes = array();
$capacidades_existentes = array();
$array_final = array();
$precio_max_min = array();
$hay_solo_efectivo = array();

//Obtenemos la categoria para el query (porque si no ponemos 'posts_per_page' en -1 no hace display de todos los iphones)
$categories = get_the_category();
$category_id = $categories[0]->cat_ID;

// Obtenemos el valor del dolar desde cotizacion
$args_cotizacion = array(
    'post_type' => 'cotiz',
    'posts_per_page' => -1,
);
$query_cotizacion = new WP_Query($args_cotizacion);
if ($query_cotizacion->have_posts()): while ($query_cotizacion->have_posts()): $query_cotizacion->the_post();
    $dolar = get_field("dolar");
endwhile;endif;
// Fin obtener valor del dolar

// posts per page en -1 para que reciba todos los iphones
$args = array( 'posts_per_page' => -1,
'cat' => $category_id );
$the_query = new WP_Query($args);
// Comienza el loop
if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post();

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
        $promocion = get_field('precio_promocion');
        $precio_final = (int)((float)$dolar * (float)$precio);
        $solo_efectivo = get_field('solo_efectivo');
        $precio_promocion = (int)((float)$dolar * (float)$promocion);
        $cuotas_18 = get_field('18_cuotas');
        $dolares = get_field('dolares');
        $link = get_post_permalink();

        $color_precio = array('color' => $color, 'precio' => $precio_final, 'precioPromocion' => $precio_promocion, 'soloEfectivo' => $solo_efectivo, '18Cuotas' => $cuotas_18,'dolares'=>$dolares,'link'=>$link);

        // Precio max min para el subtitulo de la pagina
        $precio_max_min[] = (int) $precio_final;

        // Si hay uno por lo menos de solo-efectivo true agregarlo a array y despues confirmamos si hay y sacamos el mensaje de cuotas
        if ($solo_efectivo === true){
            array_push($hay_solo_efectivo, 1);
        } else {
            array_push($hay_solo_efectivo, 0); 
        }

        if ($dolares) {
            $hay_dolares[] = 1;
        } else {
            $hay_dolares[] = 0;
        }

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
        <span class="boton-caracteristicas">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                <g>
                    <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"/>
                </g>
            </svg>
            <span id="texto-boton-caracteristicas">Seleccione un modelo</br> para ver caracteristicas</span>
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

if (in_array(1,$hay_dolares)) {
    $currency = 'U$';
} else {
    $currency = '$';
}

    echo "A partir de " . $currency . min($precio_max_min);

if(in_array(0,$hay_solo_efectivo )){
    echo "<br>También en 12, 6 o 3 cuotas**</h2>";
} else {
    echo "</h2>";
}
?> 
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

    echo "A partir de " . $currency . min($precio_max_min);

if(in_array(0,$hay_solo_efectivo )){
    echo "<br>También en 12, 6 o 3 cuotas**</h2>";
} else {
    echo "</h2>";
}



?>
                </span>
            </div>
            <ul>
                <li id="modelo">
                    <h3>Primero elige modelo</h3>
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
var currency = "<?php echo $currency; ?>";
console.log(jsonPhp);

</script>
<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/iphone.2.js";></script>

<?php get_footer();?>
