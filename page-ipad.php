<?php
/* 
	Template Name: iPad
*/
get_header(); 
$img_path = get_site_url() . "/wp-content/uploads";

//echo $myJSON;
// Guardamos los valores existentes en un array para poder utilizar los condicionales viendo si hay valores repetidos
$ipad_existentes = array();
$capacidades_existentes = array();
$array_final = array();
$precio_max_min = array();

// Hacemos query ya que no es pagina categoria
$args = array(
    'post_type' => 'ipads',
    'posts_per_page'=> -1
);

// Query
$query = new WP_Query($args);


// Comienza el loop
if($query->have_posts() ) : while($query ->have_posts()) : $query->the_post();   

$data = array();
/*
MODELO DE ARRAY PARA PASAR A JSON

$data = array('modelo'=> 'Macbook Air',
'pantalla'=> array('13.3 Retina' => 'capacidad' => array( '256 GB' => array ('ram' => '8 GB',
                                                                             'precio' => 28999)
                                                        )

*/

/*

$mac = ${'macbook' . $x};
$pantalla = ${'pantalla' . $x};
$capacidad = ${'capacidad' . $x};
$ram = ${'ram' . $x};
$precio = ${'precio' . $x};

*/

$ipad = get_field('modelo');
// $pantalla = get_field('pantalla');
$capacidad = get_field('capacidad');
$color = get_field('color');
$precio = get_field('precio');
$solo_efectivo = get_field('solo_efectivo');
$precio_promocion = get_field('precio_promocion');
$dolares = get_field('dolares');

$color_precio = array('color'=> $color, 'precio'=> $precio , 'soloEfectivo' => $solo_efectivo, 'precioPromocion' => $precio_promocion, 'dolares'=>$dolares);


// Precio max min para el subtitulo de la pagina
$precio_max_min[] = (int)$precio;

// Si no esta el modelo de mac , agregar al nombre del array data y despues agregar al array_final 
if(!in_array($ipad ,$ipad_existentes)){

    $ipad_existentes[] = $ipad;
    $capacidades_existentes[] = $capacidad;
    $data['modelo'] = $ipad;
    
    // agrega array associative
    $data['capacidad'] = array($capacidad => array($color_precio));
    

    $array_final[] = $data;

} else { // Si está
    // Ver en que elemento colocar los siguientes valores (capacidad , precio y color)

            for ($i = 0; $i < sizeof($array_final); $i++) {
                if ($array_final[$i]['modelo'] == $ipad){
                    $index = $i; // Es el index del producto actual donde esta el modelo que nos paso wordpress (en el caso de iphone 7 hay 2 , iphone 7 y iphone 7 plus)
                }
            }

            if(!in_array($capacidad ,$capacidades_existentes)){
                //Pasamos el index donde esta el elemento actual
                $array_final[$index]['capacidad'][$capacidad] = array($color_precio);
                $capacidades_existentes[] = $capacidad;

            } else {
                // si ya estaba la capacidad subida , agregamos un array color precio a la capacidad repetida
                $array_final[$index]['capacidad'][$capacidad][] = $color_precio;
            }    
}

if($dolares) {
    $hay_dolares[] = 1;
} else {
    $hay_dolares[] = 0;
}

endwhile; endif; 

// Pasamos los datos del objeto al script de javascript
// JSON_FORCE_OBJECT es para que los arrays se conviertan en {} en vez de []
$myJSON = json_encode($array_final,JSON_FORCE_OBJECT);

// Obtenemos el slug de la categoria para seleccionar imagen
function quita_guiones($cadena){
$cadena = str_replace('-', '', $cadena);
return $cadena;
}

if (in_array(1,$hay_dolares)){
    $currency = "U$";
} else {
    $currency = "$";
}

?>


<div class="titulo-pagina">
<div class="container">
    <h1>iPad</h1>
</div>
</div>

<section>
<div class="iphone-cat">
    <div class="titulo-iphone-movil">
        <h1>Compra un iPad</h1>
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
        <img id="imagen" src="<?php echo $img_path . "/ipad/ipad.png"; ?>" alt="iPad">
    </div>
    <div class="datos-iphone-cat">
        <div class="titulo-iphone-cat">
            <h1>Compra un iPad</h1>
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
            <li id="capacidad">
                <h3>Elige capacidad</h3>
                <ul>
                </ul>  
            </li>
            <li id="color">
                <h3>Elige color</h3>
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


<script type="text/javascript">
// VARIABLES PHP A JS
var jsonPhp = <?php echo $myJSON; ?>;
var imgPath = "<?php echo $img_path; ?>";
</script>
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/ipad.js"></script>
<?php get_footer(); ?>
