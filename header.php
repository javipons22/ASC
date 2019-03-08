<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
    <?php wp_head(); ?>
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
                    <li class="menu-logo">
                        <a href="#">
                            <div class="logo">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 170 170" version="1.1" height="170px">
                                    <path d="m150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.197-2.12-9.973-3.17-14.34-3.17-4.58 0-9.492 1.05-14.746 3.17-5.262 2.13-9.501 3.24-12.742 3.35-4.929 0.21-9.842-1.96-14.746-6.52-3.13-2.73-7.045-7.41-11.735-14.04-5.032-7.08-9.169-15.29-12.41-24.65-3.471-10.11-5.211-19.9-5.211-29.378 0-10.857 2.346-20.221 7.045-28.068 3.693-6.303 8.606-11.275 14.755-14.925s12.793-5.51 19.948-5.629c3.915 0 9.049 1.211 15.429 3.591 6.362 2.388 10.447 3.599 12.238 3.599 1.339 0 5.877-1.416 13.57-4.239 7.275-2.618 13.415-3.702 18.445-3.275 13.63 1.1 23.87 6.473 30.68 16.153-12.19 7.386-18.22 17.731-18.1 31.002 0.11 10.337 3.86 18.939 11.23 25.769 3.34 3.17 7.07 5.62 11.22 7.36-0.9 2.61-1.85 5.11-2.86 7.51zm-31.26-123.01c0 8.1021-2.96 15.667-8.86 22.669-7.12 8.324-15.732 13.134-25.071 12.375-0.119-0.972-0.188-1.995-0.188-3.07 0-7.778 3.386-16.102 9.399-22.908 3.002-3.446 6.82-6.3113 11.45-8.597 4.62-2.2516 8.99-3.4968 13.1-3.71 0.12 1.0831 0.17 2.1663 0.17 3.2409z" fill="#FFF"/>
                                </svg>
                                <h1>Apple Store Córdoba</h1>
                            </div>
                        </a>
                    </li>
                    <li class="menu-items">
                        <ul>
                            <li><a href="#">iPhone</a></li>
                            <li><a href="#">Mac</a></li>
                            <li><a href="#">Watch</a></li>
                            <li><a href="#">Accesorios</a></li>
                            <li><a href="#">PlayStation</a></li>
                            <li><a href="#">Contacto</a></li>
                        </ul>
                    </li>
                    <li class="carrito">
                        <a href="#">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 10.746 24.994 18.516" enable-background="new 0 10.746 24.994 18.516" xml:space="preserve"> <path fill="#fff" d="M14.5,15H13v-0.499C13,12.339,10.924,11,9,11s-4,1.339-4,3.501V15H3.5C2.673,15,2,15.674,2,16.5v11 C2,28.328,2.673,29,3.5,29h11c0.827,0,1.5-0.672,1.5-1.5v-11C16,15.674,15.327,15,14.5,15z M6,14.501C6,13,7.5,12,9,12s3,1,3,2.501 V15H6V14.501z M15,27.5c0,0.277-0.225,0.5-0.5,0.5h-11C3.224,28,3,27.777,3,27.5v-11c0-0.276,0.224-0.499,0.5-0.499h11 c0.275,0,0.5,0.223,0.5,0.499V27.5z"></path> 
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="contenido">
    <div class="separador-header">

    </div>