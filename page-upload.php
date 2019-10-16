<?php
/*
Template Name: UPLOAD
 */
get_header();

?>
<div class="container">
    <section class="upload">
        <form class="form-csv" name="CSV" id="CSV" method="POST" enctype="multipart/form-data">
            <h2>UPLOAD CSV</h2>
            <p>Las imagenes de Accesorios y Playstation hay que subirlas desde wordpress (controlar que se vean)</p>
            <p>Todos los productos existentes seran borrados y reemplazados por los nuevos</p>
            <p><input name="CSV" type="file" name="file"></p>
            <p><input class="boton-csv" type="submit" name="upload" value="Cargar"></p>

            <div id="estado"></div>

        </form>

    </section>
<?php

function borrar_posts_previos($tipo)
{
    // Argumentos para el query del loop de wordpress
    $args = array(
        'post_type' => $tipo,
        'posts_per_page' => -1,
    );

    // Query
    $query = new WP_Query($args);

    // Contador de posts borrados
    $count = 0;

    if ($query->have_posts()): while ($query->have_posts()): $query->the_post();

            $id = get_the_ID();

            wp_delete_post($id);

            $count++;

        endwhile;endif;
    wp_reset_postdata();

    return $count;

}

// ------ UPLOADER ARCHIVOS WORDPRESS ---------//

if (isset($_POST['upload'])) {

    $upload_dir_var = wp_upload_dir(); // obtenemos la ubicación de los archivos subidos en nuestro WordPress
    $upload_dir = $upload_dir_var['path']; // obtenemos el path absoluto de la carpeta de archivos subidos
    $filename = basename($_FILES['imagen']['name']); // obtenemos el nombre del archivo subido con el form
    $filename = trim($filename); // eliminamos posibles espacios antes y después del nombre de archivo
    //$filename = preg_replace(" ", "-", $filename); // eliminamos posibles espacios intersticiales en el nombre de archivo

    $typefile = $_FILES['CSV']['type']; // obtenemos el tipo de archivo (JPG, PNG...)

    $uploaddir = realpath($upload_dir); // nos aseguramos de que el path de la carpeta de archivos subidos es absoluto
    // esto es importante, si no es absoluto no funcionará
    $uploadfile = $uploaddir . '/' . $filename; // formamos el nombre definitivo que tendrá el archivo

    $slugname = preg_replace('/\.[^.]+$/', '', basename($uploadfile)); // este es el nombre que tendrá la imagen en la base de datos de imágenes de WordPress

    if (file_exists($uploadfile)) { // si un archivo con el mismo nombre ya existe se añade un sufijo al nombre
        $count = "0";
        $today = getdate();
        // se agrego fecha nombre para organizar archivos por fecha
        $fecha_nombre = ($today['mday'] . "-" . $today['mon'] . "-" . $today['year']);

        while (file_exists($uploadfile)) {
            $count++;
            $exten = 'csv';

            $uploadfile = $uploaddir . '/' . $fecha_nombre . '-' . $count . '.' . $exten;
        }
    } // fin if file_exists

    if (move_uploaded_file($_FILES['CSV']['tmp_name'], $uploadfile)) {
        // aquí ejecutaremos el código para insertar la imagen en la base de datos
        $post_id = '69'; // el identificador del post o página al que queremos asociar la imagen
        $slugname = preg_replace('/\.[^.]+$/', '', basename($uploadfile)); // tras la reubicación del archivo definimos definitivamente su nombre
        $attachment = array(
            'post_mime_type' => $typefile, // tipo de archivo
            'post_title' => $slugname, // el nombre del archivo en la Libreria de medios
            'post_content' => '', // contenido extra asociado a la imagen
            'post_status' => 'inherit',
        );

        $attach_id = wp_insert_attachment($attachment, $uploadfile, $post_id);
        // se debe incluir el archivo image.php
        // para que la función wp_generate_attachment_metadata() funcione
        require_once ABSPATH . "wp-admin" . '/includes/image.php';

        $attach_data = wp_generate_attachment_metadata($attach_id, $uploadfile);
        wp_update_attachment_metadata($attach_id, $attach_data);

    } else {
        // mensaje de error
        echo "ERROR";
    }

    // se hace parse del archivo cargado a array
    $csv_parsed = array_map('str_getcsv', file($uploadfile));
    iterador_csv($csv_parsed);

}
// ------ FIN SUBIDOR ARCHIVOS WORDPRESS ---------//

//var_dump($csv_parsed);

$subidos_correctos = array();
$subidos_error = array();

function iterador_csv($csv)
{
    // Variables a usar
    $i = 0;
    $prueba = array();

    //iteramos sobre las columnas
    foreach ($csv as $a) {
        // Si es la primera fila
        if ($i == 0) {
            $campos = array();
            // iteramos en las columnas de fila 1
            for ($x = 0; $x < sizeof($a); $x++) {
                //$a(fila)[$x(columna)] asignamos variable a las keys para asignar nombres de variables dinamicos
                $str = strtolower($a[$x]);
                $nombre_campo = str_replace(' ', '', $str);
                array_push($campos, $nombre_campo);
            }
            // Hacemos que salga de este bloque if despues de ser llamado
            $i++;
            // sino iteramos en las siguientes filas
        } else {
            for ($x = 0; $x < sizeof($a); $x++) {
                // Nombre de variable dinamico
                // devuelve ej: precio1, precio2, precio3, etc...
                ${$campos[$x] . $i} = $a[$x];
            }
            //array_push($prueba, ${$campos . $i});
            $i++;
        }
    }

    if ($campos[0] == "iphone") {

        borrar_posts_previos("iphone");

        for ($x = 1; $x <= sizeof($csv); $x++) {

            if (!empty(${'iphone' . $x})) {

                $titulo = ${'iphone' . $x} . " - " . ${'color' . $x} . " - " . ${'capacidad' . $x};
                $iphone = ${'iphone' . $x};
                $capacidad = ${'capacidad' . $x};
                $precio = ${'precio' . $x};
                $precio_promocion = ${'promocion' . $x};
                $color = ${'color' . $x};
                $stock = ${'stock' . $x};
                $cuotas_18 = ${'18-cuotas' . $x};

                if (${'solo-efectivo' . $x} == "si") {
                    $solo_efectivo = true;
                } else {
                    $solo_efectivo = false;
                }
                if (${'18-cuotas' . $x} == "si") {
                    $cuotas_18 = true;
                } else {
                    $cuotas_18 = false;
                }
                if (${'dolares' . $x} == "si") {
                    $dolares = true;
                } else {
                    $dolares = false;
                }


                switch ($iphone) {
                    case "iPhone 6":
                        $cat_id = 2;
                        break;
                    case "iPhone 6s":
                        $cat_id = 2;
                        break;
                    case "iPhone 6s Plus":
                        $cat_id = 2;
                        break;
                    case "iPhone 7":
                        $cat_id = 4;
                        break;
                    case "iPhone 7 Plus":
                        $cat_id = 4;
                        break;
                    case "iPhone 8":
                        $cat_id = 5;
                        break;
                    case "iPhone 8 Plus":
                        $cat_id = 5;
                        break;
                    case "iPhone X":
                        $cat_id = 6;
                        break;
                    case "iPhone XS":
                        $cat_id = 7;
                        break;
                    case "iPhone XS Max":
                        $cat_id = 7;
                        break;
                    case "iPhone XR":
                        $cat_id = 9;
                        break;
                    case "iPhone 11":
                        $cat_id = 13;
                        break;
                    case "iPhone 11 Pro":
                        $cat_id = 14;
                        break;
                    case "iPhone 11 Pro Max":
                        $cat_id = 14;
                        break;
                }

                // La categoria tiene que ser un array para que wordpress la acepte
                $cat = array($cat_id);

                if ($stock > 0) {
                    crear_iphone($titulo, $cat, $iphone, $precio, $capacidad, $color, $solo_efectivo, $precio_promocion, $cuotas_18,$dolares);
                    $subidos_correctos[] = $titulo;
                } else {
                    $subidos_error[] = $titulo;
                }
            }
        }

    } else if ($campos[0] == "macbook") {
        borrar_posts_previos("macs");

        for ($x = 1; $x <= sizeof($csv); $x++) {

            if (!empty(${'macbook' . $x})) {

                $titulo = ${'macbook' . $x} . " - " . ${'pantalla' . $x} . " - " . ${'capacidad' . $x};
                $mac = ${'macbook' . $x};
                $pantalla = ${'pantalla' . $x};
                $capacidad = ${'capacidad' . $x};
                $ram = ${'ram' . $x};
                $precio = ${'precio' . $x};
                $precio_promocion = ${'promocion' . $x};

                if (${'solo-efectivo' . $x} == "si") {
                    $solo_efectivo = true;
                } else {
                    $solo_efectivo = false;
                }
                if (${'dolares' . $x} == "si") {
                    $dolares = true;
                } else {
                    $dolares = false;
                }
                

                // La categoria tiene que ser un array para que wordpress la acepte
                $cat = array(11);

                crear_mac($titulo, $cat, $mac, $pantalla, $capacidad, $ram, $precio, $solo_efectivo, $precio_promocion,$dolares);
                $subidos_correctos[] = $titulo;

            }
        }

    } else if ($campos[0] == "watch") {
        borrar_posts_previos("apple_watch");
        for ($x = 1; $x <= sizeof($csv); $x++) {

            if (!empty(${'watch' . $x})) {

                $titulo = ${'watch' . $x} . " - " . ${'color' . $x} . " - " . ${'tamaño' . $x};
                $watch = ${'watch' . $x};
                $color = ${'color' . $x};
                $precio = ${'precio' . $x};
                $tamaño = ${'tamaño' . $x};
                $stock = ${'stock' . $x};
                $precio_promocion = ${'promocion' . $x};

                if (${'solo-efectivo' . $x} == "si") {
                    $solo_efectivo = true;
                } else {
                    $solo_efectivo = false;
                }
                if (${'dolares' . $x} == "si") {
                    $dolares = true;
                } else {
                    $dolares = false;
                }
                

                // La categoria tiene que ser un array para que wordpress la acepte
                $cat = array(12);

                if ($stock > 0) {
                    crear_watch($titulo, $cat, $watch, $precio, $tamaño, $color, $solo_efectivo, $precio_promocion,$dolares);
                    $subidos_correctos[] = $titulo;
                } else {
                    $subidos_error[] = $titulo;
                }

            }
        }
    } else if ($campos[0] == "accesorio") {
        borrar_posts_previos("accesorio");
        for ($x = 1; $x <= sizeof($csv); $x++) {

            if (!empty(${'accesorio' . $x})) {

                $titulo = ${'accesorio' . $x};
                $accesorio = ${'accesorio' . $x};
                $precio = ${'precio' . $x};

                if (${'solo-efectivo' . $x} == "si") {
                    $solo_efectivo = true;
                } else {
                    $solo_efectivo = false;
                }
                ;

                // La categoria tiene que ser un array para que wordpress la acepte
                $cat = array(14);

                crear_accesorio($titulo, $accesorio, $precio, $solo_efectivo);
                $subidos_correctos[] = $titulo;

            }
        }
    } else if ($campos[0] == "playstation") {
        borrar_posts_previos("playstations");
        for ($x = 1; $x <= sizeof($csv); $x++) {

            if (!empty(${'playstation' . $x})) {

                $titulo = ${'playstation' . $x} . " - " . ${'capacidad' . $x};
                $playstation = ${'playstation' . $x};
                $capacidad = ${'capacidad' . $x};
                $precio = ${'precio' . $x};
                $precio_promocion = ${'promocion' . $x};

                if (${'solo-efectivo' . $x} == "si") {
                    $solo_efectivo = true;
                } else {
                    $solo_efectivo = false;
                }
                ;

                $cat_id = 15;
                // La categoria tiene que ser un array para que wordpress la acepte
                $cat = array($cat_id);

                crear_play($titulo, $cat, $playstation, $capacidad, $precio, $solo_efectivo, $precio_promocion);
                $subidos_correctos[] = $titulo;

            }
        }
    } else if ($campos[0] == "servicio") {
        borrar_posts_previos("servicios");
        for ($x = 1; $x <= sizeof($csv); $x++) {

            if (!empty(${'servicio' . $x})) {

                //Hacemos un array para iterar en las columnas
                $servicios = array('pantalla-original', 'pantalla-calidad-original', 'pin-de-carga-microfono', 'auricular-camara-delantera', 'camara-atras(camara)', 'camara-atras(vidrio)', 'parlante', 'soft', 'liberacion', 'power', 'home', 'bateria-original', 'bateria-calidad-original', 'bano-quimico', 'rep-placa');
                // Para cada una de las columnas del excel ( escritas en $servicios) obtenemos titulo iphone y precio«
                foreach ($servicios as $servicio) {

                    // El nombre de servicio subido debe ser en mayusculas y sin guiones
                    $str = str_replace('-', ' ', $servicio);
                    $servicio_parsed = strtoupper($str);
                    // Agregamos "ñ" en caso de que sea "BANO QUIMICO"
                    if ($servicio_parsed == "BANO QUIMICO") {
                        $servicio_parsed = "BAÑO QUIMICO";
                    }
                    $titulo = ${'servicio' . $x} . " - " . $servicio_parsed . " - " . "$" . ${$servicio . $x};
                    $iphone = ${'servicio' . $x};
                    $precio = ${$servicio . $x};

                    // La categoria debe ser un array para wordpress
                    $cat = array(20);
                    if ($precio == 0) {
                        $subidos_error[] = $titulo;
                    } else {
                        crear_servicio($titulo, $cat, $iphone, $servicio_parsed, $precio);
                        $subidos_correctos[] = $titulo;
                    }

                }

                /*
            $titulo = ${'servicio' . $x} . " - " . ${'capacidad' . $x};
            $playstation = ${'playstation' . $x};
            $capacidad = ${'capacidad' . $x};
            $precio = ${'precio' . $x};
            $precio_promocion = ${'promocion' . $x};

            if(${'solo-efectivo' . $x} == "si"){
            $solo_efectivo = true;
            } else {
            $solo_efectivo = false;
            };

            $cat_id = 15;
            // La categoria tiene que ser un array para que wordpress la acepte
            $cat = array($cat_id);

            crear_play($titulo, $cat, $playstation, $capacidad, $precio, $solo_efectivo, $precio_promocion);
            $subidos_correctos[] = $titulo;
             */
            }
        }
    }

    echo "<p>" . sizeof($subidos_correctos) . " Articulos subidos correctamente </p>";

    foreach ($subidos_correctos as $subido) {

        echo "<p class='success'>" . $subido . "</p>";
    }

    foreach ($subidos_error as $error) {
        echo "<p class='error'>" . $error . " (STOCK 0)</p>";
    }
}

function crear_iphone($titulo, $cat, $iphone, $precio, $capacidad, $color, $solo_efectivo, $precio_promocion,$cuotas_18,$dolares)
{

    $my_post = array(
        'post_title' => $titulo,
        'post_category' => $cat,
        'post_type' => 'iphone',
        'post_status' => 'publish',
    );

    // Insert the post into the database
    $post_id = wp_insert_post($my_post);

    update_field('iphone', $iphone, $post_id);
    update_field('precio', $precio, $post_id);
    update_field('capacidad', $capacidad, $post_id);
    update_field('color', $color, $post_id);
    update_field('solo_efectivo', $solo_efectivo, $post_id);
    update_field('precio_promocion', $precio_promocion, $post_id);
    update_field('18_cuotas', $cuotas_18, $post_id);
    update_field('dolares', $dolares, $post_id);

}

//crear_iphone($titulo, $cat, $iphone, $precio, $capacidad, $color);

function crear_mac($titulo, $cat, $mac, $pantalla, $capacidad, $ram, $precio, $solo_efectivo, $precio_promocion,$dolares)
{

    $my_post = array(
        'post_title' => $titulo,
        'post_category' => $cat,
        'post_type' => 'macs',
        'post_status' => 'publish',
    );

    // Insert the post into the database
    $post_id = wp_insert_post($my_post);

    update_field('macbook', $mac, $post_id);
    update_field('pantalla', $pantalla, $post_id);
    update_field('capacidad', $capacidad, $post_id);
    update_field('ram', $ram, $post_id);
    update_field('precio', $precio, $post_id);
    update_field('solo_efectivo', $solo_efectivo, $post_id);
    update_field('precio_promocion', $precio_promocion, $post_id);
    update_field('dolares', $dolares, $post_id);

}

function crear_watch($titulo, $cat, $watch, $precio, $tamaño, $color, $solo_efectivo, $precio_promocion,$dolares)
{

    $my_post = array(
        'post_title' => $titulo,
        'post_category' => $cat,
        'post_type' => 'apple_watch',
        'post_status' => 'publish',
    );

    // Insert the post into the database
    $post_id = wp_insert_post($my_post);

    update_field('modelo', $watch, $post_id);
    update_field('color', $color, $post_id);
    update_field('precio', $precio, $post_id);
    update_field('tamano', $tamaño, $post_id);
    update_field('solo_efectivo', $solo_efectivo, $post_id);
    update_field('precio_promocion', $precio_promocion, $post_id);
    update_field('dolares', $dolares, $post_id);

}

function crear_accesorio($titulo, $accesorio, $precio)
{

    $my_post = array(
        'post_title' => $titulo,
        'post_category' => $cat,
        'post_type' => 'accesorio',
        'post_status' => 'publish',
    );

    // Insert the post into the database
    $post_id = wp_insert_post($my_post);

    update_field('nombre', $accesorio, $post_id);
    update_field('precio', $precio, $post_id);
    update_field('solo_efectivo', $solo_efectivo, $post_id);

}

function crear_play($titulo, $cat, $playstation, $capacidad, $precio, $solo_efectivo, $precio_promocion)
{

    $my_post = array(
        'post_title' => $titulo,
        'post_category' => $cat,
        'post_type' => 'playstations',
        'post_status' => 'publish',
    );

    // Insert the post into the database
    $post_id = wp_insert_post($my_post);

    update_field('modelo', $playstation, $post_id);
    update_field('precio', $precio, $post_id);
    update_field('capacidad', $capacidad, $post_id);
    update_field('solo_efectivo', $solo_efectivo, $post_id);
    update_field('precio_promocion', $precio_promocion, $post_id);

}

function crear_servicio($titulo, $cat, $iphone, $servicio, $precio)
{

    $my_post = array(
        'post_title' => $titulo,
        'post_category' => $cat,
        'post_type' => 'servicios',
        'post_status' => 'publish',
    );

    // Insert the post into the database
    $post_id = wp_insert_post($my_post);

    update_field('iphone', $iphone, $post_id);
    update_field('servicio', $servicio, $post_id);
    update_field('precio', $precio, $post_id);

}

?>

</div>
<script> var showButtons = false;</script>
<?php get_footer();?>