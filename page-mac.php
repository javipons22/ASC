<?php
/* 
	Template Name: Mac
*/
get_header(); 
$img_path = get_site_url() . "/wp-content/uploads";

//echo $myJSON;
// Guardamos los valores existentes en un array para poder utilizar los condicionales viendo si hay valores repetidos
$mac_existentes = array();
$pantallas_existentes = array();
$array_final = array();
$precio_max_min = array();

// Hacemos query ya que no es pagina categoria
$args = array(
    'post_type' => 'macs',
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

$mac = get_field('macbook');
$pantalla = get_field('pantalla');
$capacidad = get_field('capacidad');
$ram = get_field('ram');
$precio = get_field('precio');

$ram_precio = array('ram'=> $ram, 'precio'=> $precio);


// Precio max min para el subtitulo de la pagina
$precio_max_min[] = (int)$precio;

// Si no esta el modelo de mac , agregar al nombre del array data y despues agregar al array_final 
if(!in_array($mac ,$mac_existentes)){

    $mac_existentes[] = $mac;
    $pantallas_existentes[] = $pantalla;
    $data['modelo'] = $mac;
    
    // agrega array associative
    $data['pantalla'] = array( $pantalla => array($capacidad => array($ram_precio)));
    

    $array_final[] = $data;

} else { // Si está
    // Ver en que elemento colocar los siguientes valores (capacidad , precio y color)

            for ($i = 0; $i < sizeof($array_final); $i++) {
                if ($array_final[$i]['modelo'] == $mac){
                    $index = $i; // Es el index del producto actual donde esta el modelo que nos paso wordpress (en el caso de iphone 7 hay 2 , iphone 7 y iphone 7 plus)
                }
            }

            if(!in_array($pantalla ,$pantallas_existentes)){
                //Pasamos el index donde esta el elemento actual
                $array_final[$index]['pantalla'][$pantalla] = array($capacidad => array($ram_precio));
                $capacidades_existentes[] = $capacidad;

            } else {
                // si ya estaba la capacidad subida , agregamos un array color precio a la capacidad repetida
                $array_final[$index]['pantalla'][$pantalla][$capacidad][] = $ram_precio;
            }    
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

?>


<div class="titulo-pagina">
<div class="container">
    <h1>MacBook</h1>
</div>
</div>

<section>
<div class="flex iphone-cat">
    <div class="imagen-cat">
        <img id="imagen" src="<?php echo $img_path . "/mac/macbookprotouchbar.png"; ?>" alt="MacBook">
    </div>
    <div class="datos-iphone-cat">
        
        <h1>Compra una MacBook</h1>
        <span>
            <h2><?php
            
            if (sizeof($precio_max_min) > 1) {
                echo "De $" . min($precio_max_min) . " a $" . max($precio_max_min);
            } else {
                echo "A solo $" . min($precio_max_min);
            }

             
             ?> <br>También en 12, 6 o 3 cuotas**</h2>
        </span>
        <ul>
            <li id="modelo">
                <h3>Elige tu modelo</h3>
                <ul>
                </ul>   
            </li>
            <li id="pantalla">
                <h3>Elige la pantalla</h3>
                <ul>
                </ul>  
            </li>
            <li id="capacidad">
                <h3>Elige capacidad</h3>
                <ul>
                </ul>  
            </li>
            <li id="ram">
                <h3>Elige RAM</h3>
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
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/js/mac.js";></script>
<?php get_footer(); ?>
