<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php $img_path_thumb = get_site_url() . "/wp-content/uploads/applelogothumb.png";?>
    <meta property="og:image" content="<?php echo $img_path_thumb; ?>" />

    <!-- INICIO FAVICON -->
    <?php $img_path = get_site_url() . "/wp-content/uploads/favicon";?>
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $img_path; ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $img_path; ?>/favicon-16x16.png">
    <!-- FIN FAVICON -->
    <title><?php wp_title('Store CBA |');?></title>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KZZXK7S');</script>
<!-- End Google Tag Manager -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-175801551-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-175801551-1');
</script>

    <?php wp_head();?>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '921007438393054');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=921007438393054&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
</head>
<body <?php body_class();?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KZZXK7S"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <header>
        <div class="container">
            <nav>
                <ul class="menu">
                    <li class="menu-icon">
                        <div class="menu-wrapper">
                            <div class="hamburger-menu"></div>
                        </div>
                    </li>
                    <li class="menu-items">
                        <?php

                        wp_nav_menu([
                            'menu' => 'Menu1',
                            'container' => 'ul',
                        ]);
                            // Los iconos de facebook e instagram son agregados con un plugin en el dashboard
                        
                        ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="contenido">
    <div class="separador-header">

    </div>