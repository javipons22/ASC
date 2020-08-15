<?php
get_header();
$img_path = get_site_url() . "/wp-content/uploads";

$args_cotizacion = array(
    'post_type' => 'cotiz',
    'posts_per_page' => -1,
);
$query_cotizacion = new WP_Query($args_cotizacion);
if ($query_cotizacion->have_posts()): while ($query_cotizacion->have_posts()): $query_cotizacion->the_post();
    $dolar = get_field("dolar");
endwhile;endif;

$args_cbu = array(
    'post_type' => 'cbu',
    'posts_per_page' => 1,
);
$query_cbu = new WP_Query($args_cbu);
if ($query_cbu->have_posts()): while ($query_cbu->have_posts()): $query_cbu->the_post();
    $titular = get_field('titular');
    $alias_cuenta = get_field('alias');
    $numero_cuenta = get_field('numero_cuenta');
    $cbu = get_field("cbu");
    $cuil = get_field("cuil");

endwhile;endif;

if ( have_posts() ) : while ( have_posts() ) : the_post();
$modelo = get_field('iphone');
$color = get_field('color');
$capacidad = get_field('capacidad');
if (get_field('precio_promocion')) {
    $precio = get_field('precio_promocion') * $dolar;
} else {
    $precio = get_field('precio') * $dolar;
}
$modelo_proc = strtolower(preg_replace('/\s+/','', $modelo));
$color_proc = strtolower(preg_replace('/\s+/','', $color));
$link_imagen = $img_path . '/iphone/' . $modelo_proc . $color_proc . '.png';
// $link_imagen = $img_path . "/iphone/" . $nombre_modelo . ".png";

?>
<?php if (isset($_GET["status"])):?>
    <div class="popup-pago">
        <div class="popup-newsletter">
            <h2>Gracias! depositá tu pago usando el siguiente CBU:</h2>
            <p>
                <span>TITULAR: <?php echo $titular;?></span>
                <span>ALIAS: <?php echo $alias_cuenta;?></span>
                <span>Nº DE CUENTA: <?php echo $numero_cuenta;?></span>
                <span>CBU: <?php echo $cbu;?></span>
                <span>CUIL: <?php echo $cuil;?></span>
            </p>
            <p>Monto: $<?php echo $precio;?></p>
            <span>Otros medios de pago:</span>
            <br>
            <span>- Efectivo en sucursal</span>
            <span class="span-last">- Tarjeta de crédito en 12 cuotas con el 24% y 18 cuotas con el 32%</span>
            <div class="boton-cerrar">x</div>
        </div>
    </div>
<?php endif;?>
<div class="container">
    <div class="checkout">
        <div class="col col-30">
            <img src="<?php echo $link_imagen;?>" alt="imagen <?php echo $modelo; ?>">
        </div>
        <div class="col">
            <div class="datos-iphone-cat">
                <div class="titulo-iphone-cat">
                    <h1>En tu carrito!</h1>
                    <span>
                        <h2><?php echo ($modelo . " " . $capacidad . " " . $color);?></h2>
                    </span>
                </div>
            </div>
                <form method="post" action="<?php echo get_site_url();?>/comprasubmit" id="form-servicios">
                    <p>
                        <label for="precio">Precio</label>
                        <input type="text" class="precio-servicio" name="modelo-precio" id="precio"
                            placeholder="<?php echo "$" . $precio; ?>" value="<?php echo $precio;?>" readonly="readonly">
                        <input type="hidden" id="iphone" name="modelo-iphone" value="<?php echo $modelo . ' '  . $capacidad . ' ' . $color ;?>">
                    </p>
                    <p class="register-nombre">
                        <label for="user_nombre">Nombre</label>
                        <input type="text" name="nombre" id="user_nombre" class="input" value="" size="50"
                            placeholder="Tu Nombre..." required/>
                    </p>
                    <p class="register-apellido">
                        <label for="user_apellido">Apellido</label>
                        <input type="text" name="apellido" id="user_apellido" class="input" value="" size="50"
                            placeholder="Tu Apellido..." required/>
                    </p>
                    <p>
                        <label for="email">E-mail</label>
                        <input type="email" name="contact-email" id="email" class="input" value="" size="30"
                            placeholder="Un email al que te podamos contactar..." required/>
                    </p>
                    <p class="register-cel">
                        <label for="user_cel">Teléfono celular</label>
                        <input type="text" name="celular" id="user_cel" class="input" value=""
                            placeholder="Un celular al que te podamos contactar..." required/>
                    </p>
                    <p>
                        <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary"
                            value="COMPRAR!" />
                    </p>
                    <p>Consultas por compras: 3512140570</p>
                </form>
        </div>
    </div>
</div>

<?php endwhile; else :?>
	<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif;
?>
<script>
var input = document.createElement("input");
input.setAttribute("type", "hidden");
input.setAttribute("name", "url");
input.setAttribute("value", window.location.href);

document.getElementById("form-servicios").appendChild(input);
</script>

<?php
get_footer();
?>