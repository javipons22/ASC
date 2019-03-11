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

// Obtenemos el slug de la categoria para seleccionar imagen
function quita_guiones($cadena){
    $cadena = str_replace('-', '', $cadena);
    return $cadena;
}

$term = get_queried_object();
$slug = quita_guiones($term->slug);
?>


<div class="titulo-pagina">
    <div class="container">
        <h1><?php single_cat_title() ?></h1>
    </div>
</div>

<section>

    <div class="flex iphone-cat">
        <div class="imagen-cat">
            <img src="<?php echo $img_path . "/" . $slug . ".png"; ?>" alt="iphone">
        </div>
        <div class="datos-iphone-cat">
            
            <h1>Compra <?php single_cat_title() ?></h1>
            <span>
                <h2>De $39000 a $59300 <br>o en 12, 6 o 3 cuotas**</h2>
            </span>
            <ul>
                <li id="modelo">
                    <h3>Elige tu modelo</h3>   
                </li>
                <li id="capacidad">
                    <h3>Elige la capacidad</h3>  
                </li>
                <li id="color">
                    <h3>Elige color</h3>
                    
                </li>
            </ul>
        </div>
    </div>

</section>


<script>
// VARIABLES
var jsonPhp = <?php echo $myJSON; ?>;
var capacidadesExistentes = [];
var coloresExistentes = [];
var indexModeloSeleccionado = 0;

// ESCONDER CIERTOS DIV
jQuery("#capacidad, #color").hide();

    
    function showNext(val,tipo){
        if (tipo == 'iphone'){
            // Si reseleccionamos iphone quitar el field de color
            jQuery("#color").hide();
            capacidadMatcher(val);
            jQuery("#capacidad").show(); 
        } else if (tipo == 'capacidad'){
            colorMatcher(val, indexModeloSeleccionado);
            jQuery("#color").show();

        }
        
    }

   

    console.log(jsonPhp);

    function crearHTMLModelo(iphone,id) {

        htmlString =`
        <label for="iphone${id}">
        <div class="box modelo-iphone">    
                        <span>${iphone}</span>
                        <input id="iphone${id}" name="iphone" type="radio" class="radio" value="${iphone}" onclick="showNext(this.value, this.name)"/>
        </div>
        </label>`;
        return htmlString;

    }

    function crearHTMLCapacidad(capacidad,id) {

        htmlString =`
        <label for="capacidad${id}" class="box capacidad-iphone">    
                        <span>${capacidad}</span>
                        <input id="capacidad${id}" name="capacidad" class="radio" type="radio" value="${capacidad}" onclick="showNext(this.value,this.name)"/>
        </label>`;
        return htmlString;

    }

    function crearHTMLColor(color,id) {

        htmlString =`
        <label for="color${id}" class="box color-iphone">    
                        <span>${color}</span>
                        <input id="color${id}" name="color" class="radio" type="radio" value="${color}"/>
        </label>`;
        return htmlString;

    }
    
    function displayModelos() {
        var i = 0;
        for (var property in jsonPhp) {
            if (jsonPhp.hasOwnProperty(property)) {

                // ELIGE TU MODELO
                // obtenemos variable para el html
                var iphone = jsonPhp[property].modelo;
                // aplicamos la funcion creada con el template para insertarlo en el html
                var htmlString = crearHTMLModelo(iphone, i);
                jQuery( "#modelo" ).append( htmlString );
                i++;
            }
        }
    }

    function displayCapacidades(htmlString) {
        jQuery( "#capacidad" ).append( htmlString );
    }
    
    // La funcion hace display de la seccion capacidades para el producto seleccionado
    function capacidadMatcher(value) {

        // iteramos en los distintos index del objeto
        for (var property in jsonPhp){


            // Chequeamos si el valor pasado a la funcion desde el radio button coincide con el modelo de celular en ese index - si coincide proseguimos
            if (jsonPhp[property].modelo == value){
                // Guardamos el modelo seleccionado para hacer query del color y precio 
                indexModeloSeleccionado = property;
                // Seteamos una variable para que en la iteracion , si es el primer elemento iterado ( i == 0) borre los datos anteriores
                var i = 0;

                // iteramos en las capacidades del modelo matcheado
                for (var val in jsonPhp[property].capacidad){
                    if (i == 0) {
                        //Borra los datos anteriores
                        jQuery(".capacidad-iphone").remove();
                        var htmlString = crearHTMLCapacidad(val,i);
                        displayCapacidades(htmlString);
                        i++;
                    } else { // Si no es el primero , agrega la capacidad
                        var htmlString = crearHTMLCapacidad(val,i);
                        displayCapacidades(htmlString);
                        i++;
                    }   
                }
            }    
        }
    }

    

    // jsonPhp[0].capacidad['32 GB'][0].color
    function colorMatcher(capacidad, index) {
        
        var i = 0;
        for (var val in jsonPhp[index].capacidad[capacidad]) {
            if (i == 0) {
                jQuery(".color-iphone").remove();
                var color = jsonPhp[index].capacidad[capacidad][val].color;

                var htmlString = crearHTMLColor(color,i);
                jQuery( "#color" ).append( htmlString );
                i++;

            } else {
                var color = jsonPhp[index].capacidad[capacidad][val].color;

                var htmlString = crearHTMLColor(color,i);
                jQuery( "#color" ).append( htmlString );
                i++;
            }
            
        }

    }

    displayModelos();

</script>
<?php get_footer(); ?>
