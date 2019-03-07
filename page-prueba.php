<?php
/* 
	Template Name: Test
*/
    get_header(); 
    
?>
<?php 

    function crear_post() {
        $my_post = array(
            'post_title'    => 'hola',
            'post_category' => array(4),
            'post_type' => 'iphone'
          );
           
          // Insert the post into the database
        wp_insert_post( $my_post );

          
    }

    crear_post();
?>

<?php get_footer(); ?>