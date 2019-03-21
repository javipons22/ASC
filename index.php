<?php 
    get_header(); 
    $img_path = get_site_url() . "/wp-content/uploads";
?>
    
    

<div class="banner-1">
    <div class="banner-1-texto">
        <h1>iPhone X<span>R</span> desde $47999. o 12 cuotas de $6373.*</h1>
        <h3>Comprá en nuestro local abierto al público o recibilo por correo.</h3>
        <a href="#">Ver más ></a>
    </div>
</div>

<div class="banner-2">
    <div class="banner-2-texto">
        <h1>iPhone 6, iPhone 7, iPhone 8, iPhone X o iPhone XR</h1>
        <h3>Disfruta de tu iPhone al mejor precio!</h3>
        <img src="<?php echo $img_path; ?>/iphone/iphones.png" alt="iphones">
        <a href="#">Ver todos ></a>
    </div>
</div>

<div class="banner-3">
        <div class="banner-3-texto">
            <h1>MacBook</h1>
            <h3>MacBook Air y MacBook Pro , sólo lo mejor</h3>
            <img src="<?php echo $img_path; ?>/macbook.png" alt="macbooks">
            <a href="#">Ver más ></a>
        </div>
</div>
   

<?php get_footer(); ?>
