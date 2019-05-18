<?php
/* 
	Template Name: Contacto
*/
    get_header();
    $img_path = get_site_url() . "/wp-content/uploads";
?>

<div class="titulo-pagina">
    <div class="container">
        <h1>Contacto</h1>
    </div>
</div>
<div class="container">
    <div class="contacto">
        <div class="info-pagina-contacto">
            <h2>Información</h2>
            <ul class="datos">
                <li>
                    <div><img src="<?php echo $img_path;?>/location.svg" alt="icono ubicación"></div>
                    <p><b>Adentro Del Supermercado Disco</b>, Av. Recta Martinolli 7120, 5147 Córdoba</p>
                </li>
                <li>
                    <div><img src="<?php echo $img_path;?>/facebook.svg" alt="icono ubicación"></div>
                    <p>@AppleStoreCBA</p>
                </li>
                <li>
                    <div><img src="<?php echo $img_path;?>/instagram.svg" alt="icono ubicación"></div>
                    <p>@applestorecba</p>
                </li>
                <li>
                    <div><img src="<?php echo $img_path;?>/whatsapp.svg" alt="icono ubicación"></div>
                    <p>3512140570</p>
                </li>
            </ul>
        </div>
        <div class="maps">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3407.4193809368685!2d-64.26444268424999!3d-31.347404400056693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94329ea112e5a19d%3A0x7e234a8d8d3f98d8!2sApple+Store+Cordoba!5e0!3m2!1ses-419!2sar!4v1553205354612" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </div>
    <div class="faq">
        <div class="faq-titulo">
            <span>+</span><h1>Preguntas Frecuentes</h1>
        </div>
        <div class="faq-pregunta">
            <h1>¿Cuáles son las formas de pago?</h1>
            <p>- Efectivo / Transferencia Bancaria</p>
            <p>- Tarjeta de crédito en hasta 12 cuotas: VISA , Naranja-visa, Master, American Express, Dinners y Cabal</p>
        </div>
        <div class="faq-pregunta">
            <h1>¿Aceptan equipos usados?</h1>
            <p>Si! aceptamos desde el iPhone 6s como parte de pago para llevar uno nuevo.</p>
        </div>
        <div class="faq-pregunta">
            <h1>¿Los productos tienen garantía?</h1>
            <p>Los productos son libres de fábrica, vienen en caja sellada y tienen un año de Garantía Apple Oficial en Cordoba, Rosario y Buenos Aires a diferencia de nuestras competencias.</p>
        </div>
        <div class="faq-pregunta">
            <h1>¿Hacen envíos?</h1>
            <p>Si, hacemos envios a todo el país, con Correo Argentino ($500)</p>
        </div>
    </div>
</div>
<script> var showButtons = false;</script>
<?php get_footer(); ?>