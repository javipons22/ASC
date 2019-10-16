<?php 
/* 
	Template Name: Watch
*/
    get_header(); 
    $img_path = get_site_url() . "/wp-content/uploads";


//echo $myJSON;
// Guardamos los valores existentes en un array para poder utilizar los condicionales viendo si hay valores repetidos
$watch_existentes = array();
$colores_existentes = array();
$array_final = array();
$precio_max_min = array();

$args = array(
    'post_type' => 'apple_watch',
    'posts_per_page'=> -1
);

$query = new WP_Query($args);

// Comienza el loop
if($query->have_posts() ) : while($query ->have_posts()) : $query->the_post();    

    $data = array();
    /*
    MODELO DE ARRAY PARA PASAR A JSON

    $data = array('modelo'=> 'iPhone 7 Plus',
    'capacidad'=> array('32GB' => array( 'color'=> 'Space Gray',
                                        'precio' => 12999),
                        '128GB' => array('color'=> 'Green',
                                        'precio' => 59999)));
    */
    $modelo = get_field('modelo');
    $tamaño = get_field('tamano');
    $color = get_field('color');
    $precio = get_field('precio');
    $precio_promocion = get_field('precio_promocion');
    $dolares = get_field('dolares');


    $tamaño_precio = array('tamaño'=> $tamaño, 'precio'=> $precio, 'precioPromocion' => $precio_promocion, 'dolares' => $dolares);

    // Precio max min para el subtitulo de la pagina
    $precio_max_min[] = (int)$precio;

    // Se pone currency dolares si alguno de los productos esta en dolares
    if ($dolares){
        $hay_dolares[] = 1;
    } else {
        $hay_dolares[] = 0;
    }

    // Si no esta el modelo de iphone , agregar al nombre del array data y despues agregar al array_final 
    if(!in_array($modelo ,$watch_existentes)){

        $watch_existentes[] = $modelo;
        $colores_existentes[] = $color;
        $data['modelo'] = $modelo;
        
        // agrega array associative
        $data['color'] = array( $color => array($tamaño_precio));
        

        $array_final[] = $data;

    } else { // Si está
        // Ver en que elemento colocar los siguientes valores (capacidad , precio y color)

                for ($i = 0; $i < sizeof($array_final); $i++) {
                    if ($array_final[$i]['modelo'] == $modelo){
                        $index = $i; // Es el index del producto actual donde esta el modelo que nos paso wordpress (en el caso de iphone 7 hay 2 , iphone 7 y iphone 7 plus)
                    }
                }

                if(!in_array($color ,$colores_existentes)){
                    //Pasamos el index donde esta el elemento actual
                    $array_final[$index]['color'][$color] = array($tamaño_precio);
                    $colores_existentes[] = $color;

                } else {
                    // si ya estaba la capacidad subida , agregamos un array color precio a la capacidad repetida
                    $array_final[$index]['color'][$color][] = $tamaño_precio;
                }    
    }
endwhile; endif; 

// Pasamos los datos del objeto al script de javascript
// JSON_FORCE_OBJECT es para que los arrays se conviertan en {} en vez de []
$myJSON = json_encode($array_final,JSON_FORCE_OBJECT);

if (in_array(1,$hay_dolares)){
    $currency = "U$";
} else {
    $currency = "$";
}


?>


<div class="titulo-pagina">
    <div class="container">
        <h1>Apple Watch</h1>
    </div>
</div>

<section>
    <div class="flex iphone-cat">
        <div class="titulo-iphone-movil">
            <h1>Compra un Apple Watch</h1>
            <span>
                <h2><?php
                
                if (sizeof($precio_max_min) > 1) {
                    echo "A partir de " . $currency . min($precio_max_min);
                } else {
                    echo "A solo " . $currency . min($precio_max_min);
                }

                
                ?>
            </span>
        </div>
        <div class="imagen-cat">
            <img id="imagen" src="<?php echo $img_path . "/watch/applewatch4gps.png"; ?>" alt="watch">
        </div>
        <div class="datos-iphone-cat">
            <div class="titulo-iphone-cat">
                <h1>Compra un Apple Watch</h1>
                <span>
                    <h2><?php
                    
                    if (sizeof($precio_max_min) > 1) {
                        echo "A partir de " . $currency . min($precio_max_min);
                    } else {
                        echo "A solo " . $currency . min($precio_max_min);
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
                <li id="color">
                    <h3>Elige color</h3>
                    <ul>
                    </ul>  
                </li>
                <li id="tamaño">
                    <h3>Elige el tamaño</h3>
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
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/watch.js?v=1.2";></script>
<?php get_footer(); ?>
