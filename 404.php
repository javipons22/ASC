<?php 
/* 
	Template Name: 404
*/
get_header(); 
$img_path = get_site_url() . "/wp-content/uploads";
?>


<div class="container error-404">
   <img src="<?php echo $img_path;?>/error-404.svg">
   <h1>OOPS! No se encontró esa página</h1>
</div>

<script>var showButtons = false;</script>
<?php get_footer(); ?>