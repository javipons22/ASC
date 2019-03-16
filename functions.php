<?php 

function wpt_theme_styles() { //wpt es un nombre dado por nosotros para diferenciar con otros plugins
    wp_enqueue_style( 'reset', get_template_directory_uri() . '/css/reset.css' );
    
	wp_enqueue_style( 'fuentegoogle' , 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700' );
    wp_enqueue_style( 'hamb_icon', get_template_directory_uri() . '/css/hamb-icon.css' );
    wp_enqueue_style( 'main_css', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'laptop_media', get_template_directory_uri() . '/css/laptop.css' );
}
add_action( 'wp_enqueue_scripts', 'wpt_theme_styles' );


function wpt_theme_js() {
    wp_enqueue_script('main_js', get_template_directory_uri() . '/js/script.js', array('jquery') , '' , true);
    //wp_enqueue_script('iphone_js', get_template_directory_uri() . '/js/iphone.js', array('jquery') , '' , true);
}
add_action( 'wp_enqueue_scripts', 'wpt_theme_js' );


add_theme_support ( 'post-thumbnails' );


//FUNCION PARA AGREGAR TITULO AUTOMATICAMENTE CON LOS VALORES DEL PRODUCTO (ej . iPhone XS MAX - 32GB - Gold)

//Auto add and update Title field:
  function my_post_title_updater( $post_id ) {

    $my_post = array();
    $my_post['ID'] = $post_id;

    if ( get_post_type() == 'iphone' ) {
      $my_post['post_title'] = get_field('iphone') . " - " . get_field("capacidad") . " - " . get_field("color");
    } 

    // Update the post into the database
    wp_update_post( $my_post );

  }
   
  // run after ACF saves the $_POST['fields'] data
  add_action('acf/save_post', 'my_post_title_updater', 20);


  function wpse_category_set_post_types( $query ){
      if( $query->is_category ):
      $query->set( 'post_type', array( 'post', 'iphone' ) );
      endif;
      return $query;
    }

    add_action( 'pre_get_posts', 'wpse_category_set_post_types' );

  function register_my_menu() {
    register_nav_menu('header-menu',__( 'Menu Principal' ));
  }
  add_action( 'init', 'register_my_menu' );

  

  ?>