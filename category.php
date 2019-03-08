<?php get_header(); ?>
    

<?php single_cat_title() ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>    
<div class="container">
<?php echo the_title(); ?>
</div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
