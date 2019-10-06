<?php Header("Cache-Control: max-age=3000, must-revalidate"); ?>
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

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-138352969-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-138352969-1');
    </script>
    <!-- FIN - Google Analytics -->

    <?php wp_head();?>

</head>
<body <?php body_class();?>>
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

                        ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="contenido">
    <div class="separador-header">

    </div>