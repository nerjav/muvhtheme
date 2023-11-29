<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="rgb(0, 28, 84)"/>
<meta property="fb:app_id" content="436143953403527" />
<link href="<?php echo get_template_directory_uri() . '/assets/css/font-awesome.css'; ?>" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" id="google-fonts-style-css" href="https://fonts.googleapis.com/css?family=Oswald%3A400%7COpen+Sans%3A300italic%2C400%2C400italic%2C600%2C600italic%2C700%7CRoboto%3A300%2C400%2C400italic%2C500%2C500italic%2C700%2C900&amp;ver=8.7.4" type="text/css" media="all">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

    <head>
    <!-- ... sortable ... -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
</head>

 <!-- Enlaces a otros archivos -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/simplePagination.css" />
    <?php wp_head() ?>
 <script async src="https://www.googletagmanager.com/gtag/js?id=UA-21237721-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-21237721-1');
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
 <style>
.movilcab{
     background-image: url(https://www.muvh.gov.py/sitio/wp-content/uploads/2023/08/MINISTERIO-DE-URBANISMO_VIVIENDA_HABITAT-Curvas-01-6.png);
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
    width: 100%;
    height: 130px;}

</style>

<script>

window.addEventListener('scroll', function() {
  var panel = document.getElementById('panel');
  var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

  if (scrollTop > 0) {
    panel.classList.add('scrolled');
  } else {
    panel.classList.remove('scrolled');
  }
});
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '376921623048810',
      xfbml      : true,
      version    : 'v10.0'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

    <div id="skip"><a href="#main-content">Ir al contenido principal</a></div> 

    <header class="container">
        <div class="row">

            <div class="col-lg-9 col-xs-12">
              <div class="d-none d-sm-block">
                <a href="<?php echo get_home_url() ?>" aria-label="Enlace a página principal">
                    <picture>
                        <?php
                            if (function_exists('the_custom_logo')):
                                $custom_logo_id = get_theme_mod('custom_logo');
                                $logoUrl = wp_get_attachment_image_url($custom_logo_id, 'full');
                        ?>

                            <img src="<?php echo $logoUrl?>" alt="Logo de la [Institución Pública]" media="(min-width: 768px)"/>
                        <?php endif ?>
                    </picture>

                    
                </a>

            </div>
               <div class="movilcab d-block d-sm-none"></div>

</div>

            
        </div>
    </header>
    
    <nav id="panel" aria-label="Menú Principal" class="navbar navbar-expand-lg navbar-dark bg-dark-blue fixed-top menu_principal">
        <div class="container">
            <button 
                id="navbar-trigger"
                class="navbar-toggler" 
                type="button" 
                aria-controls="mp-menu" 
                aria-expanded="false" 
                aria-label="Expandir el menú">
                <i class="fas fa-bars"></i>
                Menú de navegación
            </button>
            <?php
            wp_nav_menu(array(
                'theme_location'    => 'main',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse',
                'container_id'      => 'navbarSupportedContent',
                'menu_class'        => 'navbar-nav mr-auto',
                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                'walker'            => new WP_Bootstrap_Navwalker(),
            ));
            ?>
        </div>
    </nav>
    <nav id="sidebar" aria-label="Menu Principal Mobile" class="d-lg-none">
        <button tabindex="-1" id="dismiss" aria-label="Colapsar Menu">
            <i class="fas fa-arrow-left"></i>
        </button>

        <div class="sidebar-header">
            <h1 class="h-4">Menú Principal</h1>
        </div> 

        <?php
            wp_nav_menu(array(
                'theme_location'    => 'main',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'list-unstyled components',
                'container_id'      => 'navbarSidebarContent',
                'menu_class'        => 'list-unstyled components',
                'fallback_cb'       => 'WP_Bootstrap_Navwalker_Sidebar::fallback',
                'walker'            => new WP_Bootstrap_Navwalker_Sidebar(),
            ));
            ?>
    </nav>

    <aside tabindex="0" aria-label="Toolbar de accesibilidad" id="toolbar" class="p-2 hidden trap-area">
        <button aria-label="Ocultar toolbar de accesibilidad" id="hide-toolbar" class="btn btn-link btn-toolbar-toggle">Ocultar</button>
        <nav arial-label="Navegación de herramientas para la accesibilidad">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <button 
                        id="magnify-text" 
                        class="btn btn-link" 
                        aria-label="Agrandar Texto"
                        >
                        <i class="fas fa-search-plus"></i> Agrandar Texto
                    </button>
                </li>
                <li class="nav-item">
                    <button 
                        id="minify-text"
                        class="btn btn-link" 
                        aria-label="Achicar Texto">
                        <i class="fas fa-search-minus"></i> Achicar Texto
                    </button>
                </li>

                <li class="divider"></li>

                <li class="nav-item">
                    <button 
                        id="grayscale" 
                        class="btn btn-link" 
                        aria-label="Escala de grises">
                        <i class="fas fa-adjust" style="transform: rotate(180deg);"></i> Escala de grises
                    </button>
                </li>
                <li class="nav-item">
                    <button
                        id="high-contrast" 
                        class="btn btn-link" 
                        aria-label="Alto contraste">
                        <i class="fas fa-adjust" style="transform: rotate(240deg);"></i> Alto Contraste
                    </button>
                </li>
                <li class="nav-item">
                    <button 
                        id="black-on-yellow"
                        class="btn btn-link" 
                        aria-label="Amarillo sobre negro">
                        <i class="fas fa-adjust"></i> Amarillo sobre Negro
                    </button>
                </li>
                <li class="nav-item">
                    <button 
                        id="reset"
                        class="btn btn-link" 
                        aria-label="Restablecer">
                        <i class="fas fa-undo"></i> Restablecer
                    </button>
                </li>
            </ul>
        </nav>
    </aside>

    <aside aria-label="Switch para el toolbar" id="toolbar-oppener" class="shown">
        <button aria-label="Mostrar toolbar de accesibilidad" class="btn btn-link btn-toolbar-toggle" id="show-toolbar">
                <i class="fas fa-low-vision"></i> Mostrar
        </button>
    </aside>
