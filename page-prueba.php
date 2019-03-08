<?php
/* 
	Template Name: Test
*/
    get_header(); 
    
?>

<section>
    <form name="CSV" id="CSV" method="POST" enctype="multipart/form-data">
        <h2>Subir archivo CSV</h2>
        <p><input name="CSV" type="file" name="file"></p>
        <p><input type="submit" name="upload" value="Enviar archivo"></p>

        <div id="estado"></div>

    </form>

</section>
<?php 

    function borrar_iphones_previos() {
        // Argumentos para el query del loop de wordpress
        $args = array(
            'post_type' => 'iphone',
        );
        
        // Query
        $query = new WP_Query($args);

        // Contador de posts borrados
        $count = 0;

        if($query->have_posts() ) : while($query ->have_posts()) : $query->the_post();

        $id = get_the_ID();

        wp_delete_post($id);

        $count++;

        endwhile; endif; wp_reset_postdata(); 

        return $count;

    }

    if (isset($_POST['upload'])) {
        $cantidad_borrados = borrar_iphones_previos();
        $mensaje = 'Se borraron ' . $cantidad_borrados . 'iPhones del sistema';
    }


    // ------ UPLOADER ARCHIVOS WORDPRESS ---------//    

    if (isset($_POST['upload'])) {

        $upload_dir_var = wp_upload_dir(); // obtenemos la ubicación de los archivos subidos en nuestro WordPress
        $upload_dir = $upload_dir_var['path'];// obtenemos el path absoluto de la carpeta de archivos subidos
        $filename = basename($_FILES['imagen']['name']); // obtenemos el nombre del archivo subido con el form
        $filename = trim($filename); // eliminamos posibles espacios antes y después del nombre de archivo
        //$filename = preg_replace(" ", "-", $filename); // eliminamos posibles espacios intersticiales en el nombre de archivo
    
        $typefile = $_FILES['CSV']['type']; // obtenemos el tipo de archivo (JPG, PNG...)
    
        $uploaddir = realpath($upload_dir); // nos aseguramos de que el path de la carpeta de archivos subidos es absoluto
                                                        // esto es importante, si no es absoluto no funcionará
        $uploadfile = $uploaddir.'/'.$filename; // formamos el nombre definitivo que tendrá el archivo
    
        $slugname = preg_replace('/\.[^.]+$/', '', basename($uploadfile)); // este es el nombre que tendrá la imagen en la base de datos de imágenes de WordPress
    
        if ( file_exists($uploadfile) ) { // si un archivo con el mismo nombre ya existe se añade un sufijo al nombre
                $count = "0";
                $today = getdate();
                // se agrego fecha nombre para organizar archivos por fecha
                $fecha_nombre = ( $today['mday'] . "-" . $today['mon'] . "-" . $today['year']);

                while ( file_exists($uploadfile) ) {
                $count++;
                $exten = 'csv';
                
                $uploadfile = $uploaddir.'/'.$fecha_nombre.'-'.$count.'.'.$exten;
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
                'post_status' => 'inherit'
                );
    
            $attach_id = wp_insert_attachment( $attachment, $uploadfile, $post_id );
            // se debe incluir el archivo image.php
            // para que la función wp_generate_attachment_metadata() funcione
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    
            $attach_data = wp_generate_attachment_metadata( $attach_id, $uploadfile );
            wp_update_attachment_metadata( $attach_id,  $attach_data ); 
        
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

    

    function iterador_csv($csv){
        // Variables a usar
        $i = 0;
        $prueba = array();

        //iteramos sobre las columnas
        foreach ( $csv as $a ) {
            // Si es la primera fila
            if ($i == 0) {
                $campos = array();
                // iteramos en las columnas de fila 1
                for ($x = 0; $x < sizeof($a); $x++) {
                    //$a(fila)[$x(columna)] asignamos variable a las keys para asignar nombres de variables dinamicos
                    $nombre_campo = strtolower($a[$x]);
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
        for ( $x = 1 ;$x <= sizeof($csv); $x++){
            
            
            $titulo = ${'iphone' . $x} . " - " . ${'color' . $x} . " - " . ${'capacidad' . $x};
            $iphone = ${'iphone' . $x};
            $capacidad = ${'capacidad' . $x};
            $precio = ${'precio' . $x};
            $color = ${'color' . $x};
            
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
                    $cat_id = 8;
                    break;
                case "iPhone XR":
                    $cat_id = 9;
                    break;
            }
            
            $cat = array($cat_id);

            crear_iphone($titulo, $cat, $iphone, $precio, $capacidad, $color);
        
        }
    } 
    







/*
    $titulo = 'iPhone 2';
    $iphone = 'iPhone X Max';
    $precio = 2500;
    $capacidad = '128 GB';
    $color = 'RED';
    $cat = array(7); // tiene que ser si o si array
*/
        function crear_iphone($titulo, $cat , $iphone , $precio , $capacidad , $color){

            $my_post = array(
                'post_title'    => $titulo,
                'post_category' => $cat,
                'post_type' => 'iphone',
                'post_status' => 'publish'
            );
               
              // Insert the post into the database
            $post_id = wp_insert_post( $my_post );
            
            update_field('iphone', $iphone, $post_id);
            update_field('precio', $precio, $post_id);
            update_field('capacidad', $capacidad, $post_id);
            update_field('color', $color, $post_id);
        
        }
        
    //crear_iphone($titulo, $cat, $iphone, $precio, $capacidad, $color);

?>

<?php get_footer(); ?>