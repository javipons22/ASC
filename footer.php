<?php $img_path = get_site_url() . "/wp-content/uploads";
// Obtenemos el valor del dolar desde cotizacion
$args_cotizacion_footer = array(
    'post_type' => 'cotiz',
    'posts_per_page' => -1,
);
$query_cotizacion_footer = new WP_Query($args_cotizacion_footer);
if ($query_cotizacion_footer->have_posts()): while ($query_cotizacion_footer->have_posts()): $query_cotizacion_footer->the_post();
    $dolar = get_field("dolar");
    $cuotas_12 = get_field('12_cuotas');
    $cuotas_18 = get_field('18_cuotas');
endwhile;endif;
?>

        <div class="container-boton-footer">
                <a href="http://m.me/applestorecba" class="boton-msg" style="text-decoration:none">
                    <img src="<?php echo $img_path;?>/messenger.svg" alt="facebook messenger">
                    <span>Envianos tu Mensaje</span>
                </a>
                <a href="https://wa.me/5493512140570" class="boton-msg whatsapp" style="text-decoration:none">
                    <img src="<?php echo $img_path;?>/whatsapp2.svg" alt="facebook messenger">
                    <span>Envianos un WhatsApp</span>
                </a>
            
        </div>

    
    </div>
    
    <footer>
        <div class="container">
            <p class="info-footer">
                Todos nuestros equipos son libres de fábrica en caja sellada y tienen un año de Garantía Apple Oficial en Cordoba, Rosario y Buenos Aires a diferencia de nuestras competencias.
                <br>
                <br>
                * Precios en pesos ARS
                <br>
                ** Productos en 18 cuotas con <?php echo $cuotas_18;?>% de interés o en 12 cuotas con <?php echo $cuotas_12;?>% de interés.
                <br>
            </p>
            
            <div class="creditos">
                <ul>
                    <li class="info-contacto">
                        <p>Formas de comprar: Visita <a href="<?php echo get_site_url() . '/contacto/'?>">nuestro negocio</a>, llama al 3512140570 o contactanos por <a href="https://www.facebook.com/AppleStoreCBA/">Facebook</a>.</p>
                    </li>
                    <li class="copyright"><p>Copyright © 2020</p></li>
                    <li class="contacto-footer">
                        <ul>
                            <li><a href="#">Contacto</a></li>
                            <li><a href="#">Reclamos</a></li>
                            <li><a href="#">Preguntas Frecuentes</a></li>
                            <li><a href="<?php echo get_site_url() . '/login/'?>">LogIn</a></li>
                        </ul>
                    </li>
                </ul>
                
            </div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>