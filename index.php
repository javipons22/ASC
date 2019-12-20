<?php 
    get_header();
    $url_path = get_site_url(); 
    $img_path = get_site_url() . "/wp-content/uploads";

    // Argumentos para el query del loop de wordpress
    $args = array(
        'post_type' => 'paginahome',
        'posts_per_page'=> -1
    );?>
    
<div class="banner-4">
    <div class="container">
        <div class="banner-4-texto">
            <h1>Felices Fiestas! te desea Apple Store CBA</h1>
            <h3>Elegí tu regalo!</h3>
            <a href="<?php echo $url_path; ?>/iphone">Ver todos ></a>
        </div>
        <img class="banner-4-imagen" src="<?php echo $img_path; ?>/iphone/navidad.png" alt="navidad">
    </div>
</div>
    
    
    <?php

    // Query
    $query1 = new WP_Query($args);
    if($query1->have_posts() ) : while($query1 ->have_posts()) : $query1->the_post(); ?>

    <?php $post_id = get_field('producto-destacado');

    $query2 = new WP_Query('post_type=iphone&p='. $post_id );
    while ( $query2->have_posts() ) : $query2->the_post(); ?>

    <?php 
        $cat = get_the_category()[0]->cat_name;
        $cat_id = get_cat_ID( $cat );
        $link = get_category_link( $cat_id );
        $cuotas18 = get_field('18_cuotas');
        $nombre = get_field('iphone');
        if(get_field('precio_promocion')){
            $precio = get_field('precio_promocion');
        } else {
            $precio = get_field('precio');
        }
        
        
    ?>
    
    <div class="banner-1">
        <div class="container">
            <div class="banner-1-texto">
                <?php if (strpos($nombre, '11') !== false):?>
                <h1><?php echo $nombre;?> a partir de U$<?php echo $precio; ?>***</h1>
                <h3>Comprá en nuestro local abierto al público o recibilo por correo.</h3>
                <a href="<?php echo $link;?>">Ver más ></a>
                <?php elseif ($cuotas18):?>
                <h1><?php echo $nombre;?> en 18 cuotas de $<?php echo intval($precio*1.6/18);?>.****</h1>
                <h3>Comprá en nuestro local abierto al público o recibilo por correo.</h3>
                <a href="<?php echo $link;?>">Ver más ></a>
                <?php else:?>
                <h1><?php echo $nombre;?> a $<?php echo $precio; ?>.* o 12 cuotas de $<?php echo intval($precio*1.4/12);?>.*</h1>
                <h3>Comprá en nuestro local abierto al público o recibilo por correo.</h3>
                <a href="<?php echo $link;?>">Ver más ></a>
                <?php endif;?>
            </div>
        </div>
    </div>

    <?php endwhile;?>
    

    <?php endwhile; endif;?> 
    
   
    
    


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
