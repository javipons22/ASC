<?php 
    get_header();
    $url_path = get_site_url(); 
    $img_path = get_site_url() . "/wp-content/uploads";

    // Argumentos para el query del loop de wordpress
    $args = array(
        'post_type' => 'paginahome',
        'posts_per_page'=> -1
    );?>
    
    
    
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
    
   
<div class="banner-2 banner-black">
    <div class="container">
        <div class="banner-2-texto">
            <h1>Conseguí el nuevo <strong>iPhone SE</strong> acá!!</h1>
            <h3>Mirá los precios!</h3>
            <a href="<?php echo $url_path; ?>/iphone/iphone-se">Ver más ></a>
            <img src="<?php echo $img_path; ?>/iphone/iphoneseback.png" alt="iphones">
        </div>
    </div>
</div>
    


<div class="banner-2">
    <div class="container">
        <div class="banner-2-texto">
            <h1>iPhone SE 2020, iPhone XR, iPhone 11, iPhone 11 Pro, iPhone 11 Pro MAX</h1>
            <h3>Elegí el tuyo!</h3>
            <!-- SE 2020, XR, 11, 11 PRO Y 11 PRO MAX -->
            <img src="<?php echo $img_path; ?>/iphone/iphones.png" alt="iphones">
            <a href="<?php echo $url_path; ?>/iphone">Ver todos ></a>
        </div>
    </div>
</div>

<div class="banner-2 banner-black">
    <div class="container">
        <div class="banner-black-container">
            <div class="columna">
                <img src="<?php echo $img_path; ?>/applewhite.png" alt="logo">
                <h1>iWatch</h1>
                <h3>Mirá más que la hora!</h3>
                <a href="<?php echo $url_path; ?>/watch">Ver más ></a>
            </div>
            <div class="columna">
                <img src="<?php echo $img_path; ?>/applewhite.png" alt="logo">
                <h1>Nuevos iPad</h1>
                <h3>Lo más cómodo!</h3>
                <a href="<?php echo $url_path; ?>/ipad">Ver más ></a>
            </div>
            
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

<div class="popup-back">
    <div class="popup-newsletter">
        <h2>Recibe noticias sobre nuestros productos!</h2>
        <span>Llena el formulario para recibir emails</span>
        <a href="https://forms.gle/RfFYnwmc9Kw7CMaB6" target="_blank">IR AL FORMULARIO</a>
        <div class="boton-cerrar">x</div>
    </div>
</div>

   
<?php get_footer(); ?>
