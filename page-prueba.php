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

    // ------ SUBIDOR ARCHIVOS WORDPRESS ---------//    

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
                while ( file_exists($uploadfile) ) {
                $count++;
                $exten = 'csv';
                
                $uploadfile = $uploaddir.'/'.$slugname.'-'.$count.'.'.$exten;
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

            
        }

    
        else {
                // mensaje de error
                echo "ERROR";
        }

        // ------ FIN SUBIDOR ARCHIVOS WORDPRESS ---------//  

        // se hace parse del archivo cargado a array
        $csv_parsed = array_map('str_getcsv', file($uploadfile));

        
        
    }

    var_dump($csv_parsed);






    $titulo = 'iPhone 2';
    $iphone = 'iPhone X Max';
    $precio = 2500;
    $capacidad = '128 GB';
    $color = 'RED';
    $cat = array(7); // tiene que ser si o si array

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