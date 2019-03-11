<?php 
    get_header(); 
    $img_path = get_site_url() . "/wp-content/uploads";


//echo $myJSON;
// Guardamos los valores existentes en un array para poder utilizar los condicionales viendo si hay valores repetidos
$iphones_existentes = array();
$capacidades_existentes = array();
$array_final = array();

// Comienza el loop
if ( have_posts() ) : while ( have_posts() ) : the_post();    

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

    $color_precio = array('color'=> $color, 'precio'=> $precio);

    // Si no esta el modelo de iphone , agregar al nombre del array data y despues agregar al array_final 
    if(!in_array($modelo ,$iphones_existentes)){

        $iphones_existentes[] = $modelo;
        $capacidades_existentes[] = $capacidad;
        $data['modelo'] = $modelo;
        
        // agrega array associative
        $data['capacidad'] = array( $capacidad => array($color_precio));
        

        $array_final[] = $data;

    } else { // Si está
        // Ver en que elemento colocar los siguientes valores (capacidad , precio y color)

                for ($i = 0; $i < sizeof($array_final); $i++) {
                    if ($array_final[$i]['modelo'] == $modelo){
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
endwhile; endif; 


// Pasamos los datos del objeto al script de javascript
// JSON_FORCE_OBJECT es para que los arrays se conviertan en {} en vez de []
$myJSON = json_encode($array_final,JSON_FORCE_OBJECT);

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

    var jsonPhp = <?php echo $myJSON; ?>;

    console.log(jsonPhp);

    function crearHTML(iphone) {

        htmlString =`
        <label for="cb1" class="box">    
                        ${iphone}
                        <input name="cb1" id="cb" type="radio" value="${iphone}"/>
        </label>`;
        return htmlString;

    }

    // iteramos en el objeto
    for (var property in jsonPhp) {
        if (jsonPhp.hasOwnProperty(property)) {
            // obtenemos variable para el html
            var iphone = jsonPhp[property].modelo;
            // aplicamos la funcion creada con el template para insertarlo en el html
            var htmlString = crearHTML(iphone);

            jQuery( ".datos-iphone-cat ul > li:first-child" ).append( htmlString );
        }
    }


//});



</script>
<?php get_footer(); ?>
