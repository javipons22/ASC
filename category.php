<?php 
    get_header(); 
    $img_path = get_site_url() . "/wp-content/uploads";

?>

<?php






//echo $myJSON;
// Guardamos los valores existentes en un array para poder utilizar los condicionales viendo si hay valores repetidos
$valores_existentes = array();
$array_final = array();
if ( have_posts() ) : while ( have_posts() ) : the_post();    

   
    $data = array('modelo'=> 'iPhone 7 Plus',
    'capacidad'=> array('32GB' => array( 'color'=> 'Space Gray',
                                        'precio' => 12999),
                        '128GB' => array('color'=> 'Green',
                                        'precio' => 59999)));

    $modelo = get_field('iphone');
    $capacidad = get_field('capacidad');
    $color = get_field('color');
    $precio = get_field('precio');

    // Si no esta el modelo de iphone , agregar al nombre del array data y despues agregar al array_final 
    if(!in_array(get_field('iphone') ,$valores_existentes)){
        $valores_existentes[] = $modelo;
        $data['modelo'] = $modelo;
        // Si la capacidad del loop no esta subida agregar
            $data['capacidad'] = array();
            $data['capacidad'][] = $capacidad;
            $array_final[] = $data;
    } else { // Si esta
        // Ver en que elemento colocar los siguientes valores (capacidad , precio y color)
        $data['modelo'] = $modelo;
        
    }

/*
    $data['capacidad'] = array( get_field('capacidad'));
    $data['capacidad'][] = array( 'color'=> 'Space Gray',
    'precio' => 12999);
    */
    



endwhile; endif; 

//var_dump($modelos_existentes);
$myJSON = json_encode($array_final);

?>


<div class="titulo-pagina">
    <div class="container">
        <h1><?php single_cat_title() ?></h1>
    </div>
</div>

<section>

    <div class="container flex iphone-cat">
        <div class="imagen-cat">
            <img src="<?php echo $img_path; ?>/iphoneXR.png" alt="iphone">
        </div>
        <div class="datos-iphone-cat">
            
            <h1>Compra <?php single_cat_title() ?></h1>
            <span>
                <h2>De $39000 a $59300 <br>o en 12, 6 o 3 cuotas**</h2>
            </span>
            <ul>
                <li>
                    <h3>Elige tu modelo</h3>
                    <label for="cb1" class="box">    
                        iPhone 8
                        <input name="cb1" id="cb" type="radio" value="iphone10"/>
                    </label>
                    <label for="cb1" class="box">
                        iPhone 8
                        <input name="cb1" id="cb" type="radio" value="iphone10"/>
                    </label>
                </li>
                <li>
                    <h3>Elige la capacidad</h3>
                    <label for="cb2" class="box">
                        iPhone 8
                        <input name="cb2" id="cb" type="radio" value="iPhone9"/>   
                    </label>
                    <label for="cb2" class="box">
                        iPhone 8
                        <input name="cb2" id="cb" type="radio" value="iPhoneX"/>
                    </label>
                    
                </li>
                <li>
                    <h3>Elige color</h3>
                    
                </li>
            </ul>
        </div>
    </div>

</section>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();    

//echo the_field('iphone'); $prueba = "esto es una prueba";

endwhile; endif; 
?>

<script>

//document.addEventListener("DOMContentLoaded", function(event) { 
// Probablemente necesario cuando se pase a node js


    jQuery( "input" ).change(function() {

    var opcion = this;
    var value = opcion.value;

    console.log(value);
    jQuery(this).css('border','3px solid gray');

    }); 

    var jsonPrueba = <?php echo $myJSON; ?>;

    console.log(jsonPrueba);


//});



</script>
<?php get_footer(); ?>
