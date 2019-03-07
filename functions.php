<?php 
function wpt_theme_styles() { //wpt es un nombre dado por nosotros para diferenciar con otros plugins
    wp_enqueue_style( 'reset', get_template_directory_uri() . '/css/reset.css' );
    
	wp_enqueue_style( 'fuentegoogle' , 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700' );
    wp_enqueue_style( 'hamb_icon', get_template_directory_uri() . '/css/hamb-icon.css' );
    wp_enqueue_style( 'main_css', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'laptop_media', get_template_directory_uri() . '/css/laptop.css' );
}
add_action( 'wp_enqueue_scripts', 'wpt_theme_styles' );

?>

<?php
function wpt_theme_js() {
    wp_enqueue_script('main_js', get_template_directory_uri() . '/js/script.js', array('jquery') , '' , true);
}
add_action( 'wp_enqueue_scripts', 'wpt_theme_js' );

?>

<?php
add_theme_support ( 'post-thumbnails' );
?>
