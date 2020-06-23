<?php
/* 
	Template Name: iPhones
*/
    get_header(); 
    $img_path = get_site_url() . "/wp-content/uploads";
?>


<?php 
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

    // Argumentos para el query del loop de wordpress
    $args = array(
        'post_type' => 'iphone',
        'posts_per_page'=> -1
    );

    // Query
    $query = new WP_Query($args);

    // Se inicializa array categorias
    $categorias = array();

    // cat_no_trim para ordenar categorias en la lista de SVG
    $cat_no_trim = array();

    // ------- FUNCIONES ADICIONALES
    // Funcion quitar espacios para que las categorias sean por ejemplo "iphone8" y se puedan asignar a una variable
    function limpia_espacios($cadena){
        $cadena = str_replace(' ', '', $cadena);
        return $cadena;
    }

    // Funcion cambiar espacios por guiones para ponerlos en clases css
    function guiones_por_espacios($cadena){
        $cadena = str_replace(' ', '-', $cadena);
        return $cadena;
    }

    // ----------
    // Loop de todos los posts de wordpress en determinada categoria para asimilar todos los productos disponibles
    if($query->have_posts() ) : while($query ->have_posts()) : $query->the_post(); 

        // Obtener categoria del post (asi se obtiene en wordpress)
        $cat = get_the_category()[0]->cat_name;

        // Obtener link de categoria para link de Ver productos
        // Primero obtener el ID para pasar a funcion get_category_link
        $id = get_cat_ID( $cat );

        $link = get_category_link( $id );

        // Trimmear la categoria (quitar espacios) para que se pueda asignar a variables
        $trimmed_cat = limpia_espacios($cat);
        $cat_no_trim[] = $cat;
        
        // Si la categoria no existe agregar al array categorias y si ya existe no hacer nada
        if (!in_array($trimmed_cat, $categorias)) {
            $categorias[] = $trimmed_cat;
            // tambien inicializa los arrays para llenarlos de datos 
            ${$trimmed_cat . "_iphone"} = array();
            ${$trimmed_cat . "_capacidad"} = array();
            ${$trimmed_cat . "_precio"} = array();
            ${$trimmed_cat . "_precio_promocion"} = array();
            ${$trimmed_cat . "_color"} = array();
            ${$trimmed_cat . "_imagen"} = array();
            ${$trimmed_cat . "_link"} = array();
        }
        
        ${$trimmed_cat . "_category"} = $cat;

        // Agregar valores disponibles a variables de titulo , capacidad, precio y color
        // Si el valor no existe agregar al array ej $iphone8_titulo (se expecifica con variable dinamica) y si ya existe no hacer nada
        if (!in_array( get_field("iphone"),${$trimmed_cat . "_iphone"})) {
            ${$trimmed_cat . "_iphone" }[] = get_field("iphone");
        }
        if (!in_array( get_field("capacidad"),${$trimmed_cat . "_capacidad"})) {
            ${$trimmed_cat . "_capacidad" }[] = intval(get_field("capacidad"));
        }
        if (!in_array( get_field("precio"),${$trimmed_cat . "_precio"})) {
            $precio = get_field("precio");
            $precio_final = ((float)$dolar * (float)$precio);
            ${$trimmed_cat . "_precio" }[] = (int)$precio_final;
        }
        if (!in_array( get_field("precio_promocion"),${$trimmed_cat . "_precio_promocion"})) {
            ${$trimmed_cat . "_precio_promocion" }[] = get_field("precio_promocion");
        }
        if (!in_array( get_field("color"),${$trimmed_cat . "_color"})) {
            ${$trimmed_cat . "_color" }[] = get_field("color");
        }
        if (!in_array( get_field("imagen"),${$trimmed_cat . "_imagen"})) {
            ${$trimmed_cat . "_imagen" }[] = get_field("imagen");
        }
        if (!in_array( $link,${$trimmed_cat . "_link"})) {
            ${$trimmed_cat . "_link" }[] = $link;
        }

        $solo_efectivo = get_field('solo_efectivo');
        if ($solo_efectivo) {
            ${$trimmed_cat . "_solo_efectivo" }[] = 1;
        } else {
            ${$trimmed_cat . "_solo_efectivo" }[] = 0;
        }

        $cuotas18 = get_field('18_cuotas');
        if ($cuotas18) {
            ${$trimmed_cat . "cuotas18" }[] = 1;
        } else {
            ${$trimmed_cat . "cuotas18" }[] = 0;
        }
    
        // Ordenamos los datos de capacidad para que aparezcan ordenados (ej. 16GB 64GB)
        sort(${$trimmed_cat . "_capacidad" });


    endwhile; endif; wp_reset_postdata();
?>

<?php 
    $orden_categorias = array("iPhone SE","iPhone 11 Pro","iPhone 11","iPhone XS","iPhone XR", "iPhone X", "iPhone 8", "iPhone 7", "iPhone 6");
    $categorias_ordenadas = array();
    $categorias_ordenadas_trim = array();
    foreach ($orden_categorias as $val){
        if (in_array($val, $cat_no_trim)){
            array_push($categorias_ordenadas ,$val); 
            array_push($categorias_ordenadas_trim , limpia_espacios($val));
        }
    }


?>

<div class="sub-menu">
    <div class="container sub-menu-container">
        <ul>
            <?php 
                foreach($categorias_ordenadas as $val):
                    //Trimmeamos la categoria en esta iteracion para agregar el link
                    $val_trim = limpia_espacios($val);
                    if ($val == "iPhone XR"):
            ?>
                <li>
                    <a href="<?php echo ${$val_trim . "_link"}[0];?>">
                        <img src="<?php echo $img_path . "/" . $val_trim ?>.svg" alt="icono <?php echo $val;?>">
                        <h5>iPhone X<span>R</span></h5>
                    </a>
                </li>

           
            <?php
                else :
            ?>
                <li>
                    <a href="<?php echo ${$val_trim . "_link"}[0];?>">
                        <img src="<?php echo $img_path . "/" . $val_trim ?>.svg" alt="icono <?php echo $val;?>">
                        <h5><?php echo $val; ?></h5>
                    </a>
                </li>
            <?php 
                    endif;
                endforeach;
            ?>
            
        </ul>

    </div>
    <div class="contenedor-flecha">
        <img src="<?php echo $img_path; ?>/flecha.svg" class="flecha" alt="flecha">
    </div>
</div>

<div class="titulo-pagina">
    <div class="container">
        <h1>Todos los iPhones</h1>
    </div>
</div>

<div class="productos">
    <div class="container productos-flex">
        <?php foreach ($categorias_ordenadas_trim as $cat): ?>
            <div class="producto">
                <div class="producto-titulo">
                    <h2><?php 
                            $i = 0;
                            foreach(${ $cat ."_iphone" } as $iphone_titulo){ 
                                if ($i == 0 && sizeof(${ $cat ."_iphone" }) > 1) {
                                    echo $iphone_titulo . " - ";
                                    $i = $i+1; 
                                } else {
                                    echo $iphone_titulo;
                                }                            
                        } 
                        ?>
                    </h2>
                </div>
                <div class="producto-info">
                    <div class="producto-info-imagen">
                        <img src="<?php echo $img_path . "/iphone/" . limpia_espacios(strtolower(${ $cat ."_category" })) . ".png"; ?>" height="225px" alt="<?php echo ${ $cat ."_category" }; ?>">
                    </div>
                    <div class="info">
                        <ul>
                            <li>
                                <h3>Capacidades Disponibles</h3>
                                
                                <ul class="info-items">
                                    <?php foreach (${ $cat ."_capacidad" } as $capacidad): ?>
                                        <li><?php echo $capacidad ;?> GB</li>
                                    <?php endforeach; ?>
                                </ul> 
                            </li>

                            <li>
                                <h3>Colores Disponibles</h3>
                                <ul class="info-items info-colores">
                                    <?php foreach (${ $cat ."_color" } as $color): ?>
                                        <li>
                                            <div class="color <?php echo guiones_por_espacios(strtolower($color)); ?>">
                                            </div>
                                            <span><?php echo $color ;?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul> 
                            </li>
                            <li>
                                <h3>Precio</h3>
                                    <div class="precio">
                                    <?php 
                                     $promocion = false;
                                        foreach (${ $cat ."_precio_promocion" } as $precio_promocion) {
                                            if ($precio_promocion > 0) {
                                                $promocion = true;
                                            }
                                        }
                                        if ($promocion == true) {
                                            echo "<span class='promocion-true'>PROMOCION!!</span>";
                                        } 
                                     ?>
                                        <span>
                                            <?php
                                                if (!$promocion) {
                                                    if(sizeof(${ $cat ."_precio" }) > 1){
                                                        
                                                        $currency = '$';
                                                        $currency_detail = '*';
                                                        $precio_minimo = min(${ $cat ."_precio" });
                                                        $precio_maximo = max(${ $cat ."_precio" });
                                                        echo $currency . $precio_minimo . $currency_detail . " - " . $currency . $precio_maximo . $currency_detail;
                                                    }  else {
                                                        echo $currency . ${ $cat ."_precio" }[0] . $currency_detail;
                                                    }
                                                }
                                            ?>
                                        </span>
                                        <?php
                                            if(in_array("1", ${$cat . "cuotas18" })) {
                                                echo "<p>en 18 cuotas****, 12 cuotas, 6 cuotas o 3 cuotas**</p>";
                                            } elseif (in_array("0", ${$cat . "_solo_efectivo" })) {
                                                echo "<p>en 12 cuotas , 6 cuotas o 3 cuotas**</p>";
                                            } else {
                                                echo "<p>Pago solo en contado</p>"; 
                                            }
                                        ?>
                                    </div>
                                </ul> 
                            </li>
                        </ul>         
                    </div>
                </div>
                <div class="producto-boton">
                    <a href="<?php echo ${ $cat ."_link" }[0]; ?>">
                        <h4>Ver Productos</h4>
                    </a>
                </div>
            </div>


        <?php endforeach; ?>


    </div>
</div>

<?php get_footer(); ?>