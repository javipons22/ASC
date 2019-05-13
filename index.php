<?php 
    get_header();
    $url_path = get_site_url(); 
    $img_path = get_site_url() . "/wp-content/uploads";

    // Argumentos para el query del loop de wordpress
    $args = array(
        'post_type' => 'paginahome',
        'posts_per_page'=> -1
    );

    // Query
    $query1 = new WP_Query($args);
    if($query1->have_posts() ) : while($query1 ->have_posts()) : $query1->the_post(); ?>

    <?php $post_id = get_field('producto-destacado');?>

    <?php endwhile; endif; 
    
   
    
    $query2 = new WP_Query('post_type=iphone&p='. $post_id );
    while ( $query2->have_posts() ) : $query2->the_post(); ?>

    <?php 
        $cat = get_the_category()[0]->cat_name;
        $cat_id = get_cat_ID( $cat );
        $link = get_category_link( $cat_id );
        $nombre = get_field('iphone');
        $precio = get_field('precio');
    ?>

    <?php endwhile;?>
<div class="banner-1">
    <div class="container">
        <div class="banner-1-texto">
            <img class="hotsale" src="<?php echo $img_path; ?>/hotsale.png">
            <h3>Aprovechá y navegá el sitio para descubrir los precios !!</h3>
        </div>
    </div>
</div>

<div class="banner-1">
    <div class="container">
        <div class="banner-1-texto">
            <h1><?php echo $nombre;?> a $<?php echo $precio; ?>.* o 12 cuotas de $<?php echo intval($precio*1.6/12);?>.*</h1>
            <h3>Comprá en nuestro local abierto al público o recibilo por correo.</h3>
            <a href="<?php echo $link;?>">Ver más ></a>
        </div>
    </div>
</div>

<div class="banner-2">
    <div class="container">
        <div class="banner-2-texto">
            <h1>iPhone 6, iPhone 7, iPhone 8, iPhone X, iPhone XS o iPhone XR</h1>
            <h3>Elegí el tuyo!</h3>
            <img src="<?php echo $img_path; ?>/iphone/iphones.png" alt="iphones">
            <a href="<?php echo $url_path; ?>/iphone">Ver todos ></a>
        </div>
    </div>
</div>

<div class="banner-3">
    <div class="container">
        <div class="banner-3-texto">
            <h1>MacBook</h1>
            <h3>MacBook Air y MacBook Pro , sólo lo mejor</h3>
            <picture>
                <source media="(min-width: 768px)" srcset="<?php echo $img_path; ?>/macbook.png">
                <img src="<?php echo $img_path; ?>/mac/macbookprotouchbar.png" alt="macbooks">
            </picture>
            
            <a href="<?php echo $url_path; ?>/mac">Ver más ></a>
        </div>
    </div>
</div>
   
<?php get_footer(); ?>
