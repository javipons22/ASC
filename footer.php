<?php $img_path = get_site_url() . "/wp-content/uploads"; ?>
    <div class="container-boton-footer">
            <a href="http://m.me/applestorecba" class="boton-contacto" style="text-decoration:none">
                <img src="<?php echo $img_path;?>/whatsapp.svg" alt="facebook messenger">
                <span>Envianos tu Mensaje</span>
            </a>
        
    </div>
    
    </div>
    
    <footer>
        <div class="container">
            <p class="info-footer">
                Todos nuestros equipos son libres de fábrica en caja sellada y tienen un año de Garantía Apple Oficial en Cordoba, Rosario y Buenos Aires a diferencia de nuestras competencias.
                <br>
                <br>
                *Precios en pesos ARS
                <br>
                **Productos en 12 cuotas con 60% de interés, en 6 cuotas con 30% de interés o en 3 cuotas con 20% de interés.
            </p>
            <div class="footer-nav">
                <div class="columna-1-footer">
                    <ul>
                        <h3>Productos</h3>
                        <?php 

                        wp_nav_menu( [
                            'menu' => 'Menu2',
                            'container' => false,
                            'items_wrap' => '%3$s'
                        ] ); 

                        ?>
                    </ul>
                    
                </div>
            </div>
            
            <div class="creditos">
                <ul>
                    <li class="info-contacto">
                        <p>Formas de comprar: Visita <a href="<?php echo get_site_url() . '/contacto/'?>">nuestro negocio</a>, llama al 3512140570 o contactanos por <a href="https://www.facebook.com/AppleStoreCBA/">Facebook</a>.</p>
                    </li>
                    <li class="copyright"><p>Copyright © 2019</p></li>
                    <li class="contacto-footer">
                        <ul>
                            <li><a href="#">Contacto</a></li>
                            <li><a href="#">Reclamos</a></li>
                            <li><a href="#">Preguntas Frecuentes</a></li>
                        </ul>
                    </li>
                    <li class="pais">
                        <img src="<?php echo $img_path; ?>/argentina.png" alt="bandera">
                        <p>Argentina</p>
                    </li>
                </ul>
                
            </div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>