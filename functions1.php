<?php

function accesibility_theme_support()
{
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    //add_image_size('slider_thumb',740,440, true);
	//add_image_size('noticia_thumb',600,317, true);		
	add_image_size('bloquecitos_thumb',300,169, true);	
	//add_image_size('programas_thumb',169, 89, true);
	//add_image_size('directorio_thumb',169, 89, true);
    add_theme_support('post-thumbnails', array( 'post', 'page', 'programas', 'contrataciones', 'documentos', 'publicaciones', 'directorio') );

	
}
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
}

add_action('after_setup_theme', 'accesibility_theme_support');

function accesibility_menus()
{
    $locations = array(
        'main' => 'Menú Principal',
    );

    register_nav_menus($locations);
}

add_action('init', 'accesibility_menus');

function accesibility_register_styles()
{
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('accesibility-boostrap', get_template_directory_uri() . '/assets/css/bootstrap.css');
    wp_enqueue_style('accesibility-showcase', get_template_directory_uri() . '/assets/css/showcase.css');
    wp_enqueue_style('accesibility-sidebar-style', get_template_directory_uri() . '/assets/plugins/jquery.mCustomScrollbar.min.css', array('accesibility-boostrap'), '4.0.0', 'all');
    wp_enqueue_style('accesibility-style', get_template_directory_uri() . '/assets/css/style.css', array('accesibility-boostrap', 'accesibility-sidebar-style'), $version, 'all');
}

add_action('wp_enqueue_scripts', 'accesibility_register_styles');

function accesibility_register_scripts()
{
    $version = wp_get_theme()->get('Version');
    wp_enqueue_script('accesibility-carousel', get_template_directory_uri() .'/js/carousel.js', array(), '1.0', true);
    wp_enqueue_script('accesibility-aw-showcase', get_template_directory_uri() .'/js/jquery.aw-showcase.js', array(), '1.0', true);
    //wp_enqueue_script('accesibility-jquery1102', get_template_directory_uri() .'/assets/js/jquery-1.10.2.min.js', array(), '1.10.2', true);
    wp_enqueue_script('accesibility-jquery', get_template_directory_uri() .'/assets/js/jquery-migrate-1.4.1.min.js', array(), '1.4.1', true);
    wp_enqueue_script('accesibility-jquery', get_template_directory_uri() .'/assets/js/jquery-3.2.1.slim.min.js', array(), '3.2.1', true);
    wp_enqueue_script('accesibility-popper', get_template_directory_uri() .'/assets/js/popper.min.js', array(), '1.12.9', true);
    wp_enqueue_script('accesibility-boostrap-js', get_template_directory_uri() .'/assets/js/bootstrap.min.js', array('accesibility-jquery'), '4.0.0', true);
    wp_enqueue_script('accesibility-sidebar-js', get_template_directory_uri() .'/assets/js/jquery.mCustomScrollbar.concat.min.js', array('accesibility-jquery'), '3.1.5', true);
    wp_enqueue_script('accesibility-bundle', get_template_directory_uri() . '/assets/js/bundle.js', array('accesibility-jquery', 'accesibility-boostrap-js','accesibility-sidebar-js'), $version, true);

}

add_action('wp_enqueue_scripts', 'accesibility_register_scripts');

/**
 * Register Custom Navigation Walker
 */
function register_navwalker()
{
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker-sidebar.php';
}
add_action('after_setup_theme', 'register_navwalker');


function bootstrap_pagination(\WP_Query $wp_query = null, $echo = true, $params = [])
{
    if (null === $wp_query) {
        global $wp_query;
    }

    $add_args = [];

    //add query (GET) parameters to generated page URLs
    /*if (isset($_GET[ 'sort' ])) {
        $add_args[ 'sort' ] = (string)$_GET[ 'sort' ];
    }*/

    $pages = paginate_links(
        array_merge([
            'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format'       => '?paged=%#%',
            'current'      => max(1, get_query_var('paged')),
            'total'        => $wp_query->max_num_pages,
            'type'         => 'array',
            'show_all'     => false,
            'end_size'     => 3,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => __('« Anterior'),
            'next_text'    => __('Siguiente »'),
            'add_args'     => $add_args,
            'add_fragment' => ''
        ], $params)
    );

    if (is_array($pages)) {
        $pagination = '<nav class="nav-pagination" aria-label="Paginación de las Noticias"><ul class="pagination justify-content-center">';

        foreach ($pages as $page) {
            $pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '" ' . (strpos($page, 'current') !== false ? ' aria-current="page"' : '') . '> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
        }

        $pagination .= '</ul></nav>';

        if ($echo) {
            echo $pagination;
        } else {
            return $pagination;
        }
    }

    return null;
}

function add_query_vars_filter($vars)
{
    $vars[] = "s";

    return $vars;
}

add_filter('query_vars', 'add_query_vars_filter');


/**
 * Retrieve category parents.
 *
 * @param int $id Category ID.
 * @param array $visited Optional. Already linked to categories to prevent duplicates.
 * @return string|WP_Error A list of category parents on success, WP_Error on failure.
 */
function custom_get_category_parents($id, $visited = array())
{
    $chain = '';
    $parent = get_term($id, 'category');
  
    if (is_wp_error($parent)) {
        return $parent;
    }
  
    $name = $parent->name;
  
    if ($parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited)) {
        $visited[] = $parent->parent;
        $chain .= custom_get_category_parents($parent->parent, $visited);
    }
  
    $chain .= '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($parent->term_id)) . '">' . $name. '</a>' . '</li>';
  
    return $chain;
}


function bootstrap_breadcrumb()
{
    global $post;
  
    $html = '<div aria-label="Breadcrumb"><ol class="breadcrumb pl-0 pt-0">';
  
    if ((is_front_page()) || (is_home())) {
        $html .= '<li class="breadcrumb-item active">Portada</li>';
    } else {
        $html .= '<li class="breadcrumb-item"><a href="'.esc_url(home_url('/')).'">Portada</a></li>';
    
        if (is_attachment()) {
            
            $parent = get_post($post->post_parent);
            $categories = get_the_category($parent->ID);
      
            if ($categories[0]) {
                $html .= custom_get_category_parents($categories[0]);
            }
      
            $html .= '<li class="breadcrumb-item"><a href="' . esc_url(get_permalink($parent)) . '">' . $parent->post_title . '</a></li>';
            $html .= '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
        } elseif (is_category()) {
            $category = get_category(get_query_var('cat'));
      
            if ($category->parent != 0) {
                $html .= custom_get_category_parents($category->parent);
            }
      
            $html .= '<li class="breadcrumb-item active">' . single_cat_title('', false) . '</li>';
        } elseif (is_page() && !is_front_page()) {
            $parent_id = $post->post_parent;
            $parent_pages = array();
      
            while ($parent_id) {
                $page = get_page($parent_id);
                $parent_pages[] = $page;
                $parent_id = $page->post_parent;
            }
      
            $parent_pages = array_reverse($parent_pages);
      
            if (!empty($parent_pages)) {
                foreach ($parent_pages as $parent) {
                    $html .= '<li class="breadcrumb-item"><a href="' . esc_url(get_permalink($parent->ID)) . '">' . get_the_title($parent->ID) . '</a></li>';
                }
            }
      
            $html .= '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
        } elseif (is_singular('post')) {
            $categories = get_the_category();
      
            if ($categories[0]) {
                $html .= custom_get_category_parents($categories[0]);
            }
      
            $html .= '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
        } elseif (is_tag()) {
            $html .= '<li class="breadcrumb-item active">' . single_tag_title('', false) . '</li>';
        } elseif (is_day()) {
            $html .= '<li class="breadcrumb-item"><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li>';
            $html .= '<li class="breadcrumb-item"><a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . get_the_time('m') . '</a></li>';
            $html .= '<li class="breadcrumb-item active">' . get_the_time('d') . '</li>';
        } elseif (is_month()) {
            $html .= '<li class="breadcrumb-item"><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li>';
            $html .= '<li class="breadcrumb-item active">' . get_the_time('F') . '</li>';
        } elseif (is_year()) {
            $html .= '<li class="breadcrumb-item active">' . get_the_time('Y') . '</li>';
        } elseif (is_author()) {
            $html .= '<li class="breadcrumb-item active">' . get_the_author() . '</li>';
        } elseif (is_search()) {
        } elseif (is_404()) {
        }
    }
  
    $html .= '</ol></div>';
  
    echo $html;
}


function accesibility_sidebar()
{
    register_sidebar(array(
        'name' => 'Barra Lateral Derecha',
        'id' => 'accesibility-sidebar',
        'class' => 'external-link',
        'description' => 'Sidebar',
        'before_widget' => '<div class="external-link">',
        'after_widget' => '</div>'
    ));
}

add_action('widgets_init', 'accesibility_sidebar');

function accesibility_footer()
{
    register_sidebar(array(
        'name' => 'Pie de Página Izquierda',
        'id' => 'accesibility-footer-1',
        'class' => 'external-link',
        'description' => 'Footer',
        'before_widget' => '<div class="external-link">',
        'after_widget' => '</div>'
    ));


register_sidebar(array(
        'name' => 'Archivos de Noticias',
        'id' => 'accesibility-noticias-izq',
        'class' => 'external-link',
        'description' => 'Muestra los archivos de la noticias por a�o',
        'before_widget' => '<div class="external-link">',
        'after_widget' => '</div>'
    ));

    register_sidebar(array(
        'name' => 'Sidebar cintillos',
        'id' => 'accesibility-sidebar-izq',
        'class' => 'external-link',
        'description' => 'Sidebar IZ',
        'before_widget' => '<div class="external-link">',
        'after_widget' => '</div>'
    ));

    register_sidebar(array(
        'name' => 'Pie de Página Centro',
        'id' => 'accesibility-footer-2',
        'class' => 'external-link',
        'description' => 'Footer',
        'before_widget' => '<div class="external-link">',
        'after_widget' => '</div>'
    ));
    register_sidebar(array(
        'name' => 'Pie de Página Derecha',
        'id' => 'accesibility-footer-3',
        'class' => 'external-link',
        'description' => 'Footer',
        'before_widget' => '<div class="external-link">',
        'after_widget' => '</div>'
    ));
}

add_action('widgets_init', 'accesibility_footer');
/* ------------------------------------------------ filtro que muestra tamaÃ±o large en galeria-----------------------------------------------------------------*/
function oikos_get_attachment_link_filter( $content, $post_id, $size, $permalink ) {
 
    // Only do this if we're getting the file URL
    if (! $permalink) {
        // This returns an array of (url, width, height)
        $image = wp_get_attachment_image_src( $post_id, 'large' );
        $new_content = preg_replace('/href=\'(.*?)\'/', 'href=\'' . $image[0] . '\'', $content );
        return $new_content;
    } else {
        return $content;
    }
}
 
add_filter('wp_get_attachment_link', 'oikos_get_attachment_link_filter', 10, 4);




/*  --------------------------------------------------- Filtros by Nestor Morel  ------------------------------------------------------ */
add_filter('use_block_editor_for_post', '__return_false');
register_nav_menu( 'listados', 'Menu que va al sidebar principal izquierdo' );

/*  --------------------------------------------------- Cambia las etiquetas de posts y entradas a Noticias ------------------------------------------------------ */
	
function change_post_menu_label() {
    global $menu;
    //echo var_dump($menu);
    global $submenu;
    $menu[5][0] = 'Noticias';
    $submenu['edit.php'][5][0] = 'Todas las Noticias';
    $submenu['edit.php'][10][0] = 'Nueva Noticia';
    $submenu['edit.php'][15][0] = 'Categorias'; // Change name for categories
    $submenu['edit.php'][16][0] = 'Palabras clave'; // Change name for tags
    echo '';
}

function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Todos las Noticias';
        $labels->singular_name = 'Noticia';
        $labels->add_new = 'Agregar Noticia';
        $labels->add_new_item = 'Agregar Noticia';
        $labels->edit_item = 'Editar Noticia';
        $labels->new_item = 'Noticia';
        $labels->view_item = 'Ver Noticia';
        $labels->search_items = 'Buscar Noticias';
        $labels->not_found = 'Noticia no encontrada';
        $labels->not_found_in_trash = 'No hay Noticia en la papelera';
    }
    add_action( 'init', 'change_post_object_label' );
    add_action( 'admin_menu', 'change_post_menu_label' );

    register_sidebar( array(
        'id'          => 'lateral2',
        'name'        => __( 'Area de sidebar 2'),
        'description' => __( 'Para agregar banner x contenido' ),
        ) );
    
    
        function mis_posts(){

            /*  ###########################################################  Definicion de programas habitacionales ##################################################   */
            $labels = array(
                'name' => _x('Programas', ''),
                'singular_name' => _x('programas', ''),
                'add_new' => _x('Agregar', ''),
                'add_new_item' => __('Agregar programa'),
                'edit_item' => __('Editar programas'),
                'new_item' => __('Nuevo programas'),
                'view_item' => __('Ver programas'),
                'search_items' => __('Buscar programas'),
                'not_found' =>  __('Seccion en construcci&oacute;n'),
                'not_found_in_trash' => __('No hay programa en papelera'),
                'parent_item_colon' => '',
                'menu_name' => 'Programas'
            );
            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'programas'),
                'map_meta_cap' => true,
                'capability_type' => array('programa', 'programas'),
                'has_archive' => true,
                'menu_icon' => get_bloginfo('template_directory') . '/images/programas.png',
                'hierarchical' => false,
                'menu_position' => 4,
                'supports' => array('title','thumbnail','editor','excerpt','comments')
            );
            register_post_type('programas',$args);
                flush_rewrite_rules();
        

/*  ###########################################################  Definicion de Avance de OBRAS ##################################################   */

$labels = array(
	'name' => _x('Avances de Obras', ''),
	'singular_name' => _x('Avances de Obras', ''),
	'add_new' => _x('Agregar', ''),
	'add_new_item' => __('Agregar Avance '),
	'edit_item' => __('Editar '),
	'new_item' => __('Nuevo Avance de Obra'),
	'view_item' => __('Ver Avance de Obras'),
	'search_items' => __('Buscar Avance de Obra'),
	'not_found' =>  __('Seccion en construcci&oacute;n'),
	'not_found_in_trash' => __('No hay contratacion en papelera'),
	'parent_item_colon' => '',
	'menu_name' => 'Avance de Obras'
);
$args = array(
	'labels' => $labels,
	'public' => true,
	'publicly_queryable' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'order' => 'DESC',

	'query_var' => true,
	'rewrite' => array('slug' => 'Avance de Obras'),
	'map_meta_cap' => true,
	'capability_type' => array('Avance de Obra', 'Avance de Obras'),
	'has_archive' => true,
	'menu_icon' => get_bloginfo('template_directory') . '/images/contrataciones.png',
	'hierarchical' => false,
	'menu_position' => 5,
	'supports' => array('title','thumbnail','editor','excerpt','comments')
);
register_post_type('avances de obras',$args);
	flush_rewrite_rules();


        /*  ###########################################################  Definicion de contrataciones ##################################################   */
        
            $labels = array(
                'name' => _x('Contrataciones', ''),
                'singular_name' => _x('contrataciones', ''),
                'add_new' => _x('Agregar', ''),
                'add_new_item' => __('Agregar contratación'),
                'edit_item' => __('Editar contrataciones'),
                'new_item' => __('Nueva contratación'),
                'view_item' => __('Ver contrataciones'),
                'search_items' => __('Buscar contrataciones'),
                'not_found' =>  __('Seccion en construcci&oacute;n'),
                'not_found_in_trash' => __('No hay contratacion en papelera'),
                'parent_item_colon' => '',
                'menu_name' => 'Contrataciones'
            );
            $args = array(
                'labels' => $labels,
                'public' => true,
'order' => 'ASC',

                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'contrataciones'),
                'map_meta_cap' => true,
                'capability_type' => array('contratacion', 'contrataciones'),
                'has_archive' => true,
                'menu_icon' => get_bloginfo('template_directory') . '/images/contrataciones.png',
                'hierarchical' => false,
                'menu_position' => 5,
                'supports' => array('title','thumbnail','editor','excerpt','comments')
            );
            register_post_type('contrataciones',$args);
                flush_rewrite_rules();
        
              
        
        /*  ###########################################################  Definicion de documentos ##################################################   */
            $labels = array(
                'name' => _x('Documentos', ''),
                'singular_name' => _x('documentos', ''),
                'add_new' => _x('Agregar', ''),
                'add_new_item' => __('Agregar documento'),
                'edit_item' => __('Editar documentos'),
                'new_item' => __('Nuevo documentos'),
                'view_item' => __('Ver documentos'),
                'search_items' => __('Buscar documentos'),
                'not_found' =>  __('Seccion en construcci&oacute;n'),
                'not_found_in_trash' => __('No hay documento en papelera'),
                'parent_item_colon' => '',
                'menu_name' => 'Documentos'
            );
            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'documentos'),
                'map_meta_cap' => true,
                'capability_type' => array('documento', 'documentos'),
                'has_archive' => true,
                'menu_icon' => get_bloginfo('template_directory') . '/images/documentos.png',
                'hierarchical' => true,
                'menu_position' => 7,
                'supports' => array('title','thumbnail','editor','excerpt','comments','page-attributes')
            );
            register_post_type('documentos',$args);
                flush_rewrite_rules();
        
        
        /*  ###########################################################  Definicion de publicaciones ##################################################   */
            $labels = array(
                'name' => _x('Publicaciones', ''),
                'singular_name' => _x('publicaciones', ''),
                'add_new' => _x('Agregar', ''),
                'add_new_item' => __('Agregar publicacion'),
                'edit_item' => __('Editar publicaciones'),
                'new_item' => __('Nuevo publicaciones'),
                'view_item' => __('Ver publicaciones'),
                'search_items' => __('Buscar publicaciones'),
                'not_found' =>  __('Seccion en construcci&oacute;n'),
                'not_found_in_trash' => __('No hay documento en papelera'),
                'parent_item_colon' => '',
                'menu_name' => 'Publicaciones'
            );
            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'publicaciones'),
                'map_meta_cap' => true,
                'capability_type' => array('publicacion', 'publicaciones'),
                'has_archive' => true,
                
                'hierarchical' => true,
                'menu_position' => 8,
                'supports' => array('title','thumbnail','editor','excerpt','comments','page-attributes')
            );
            register_post_type('publicaciones',$args);
                flush_rewrite_rules();
        
        /*  ###########################################################  Definicion de directorio ##################################################   */
            $labels = array(
                'name' => _x('Directorio', ''),
                'singular_name' => _x('directorio', ''),
                'add_new' => _x('Agregar', ''),
                'add_new_item' => __('Agregar miembro'),
                'edit_item' => __('Editar miembro'),
                'new_item' => __('Nuevo miembro'),
                'view_item' => __('Ver directorio'),
                'search_items' => __('Buscar directorio'),
                'not_found' =>  __('Seccion en construcci&oacute;n'),
                'not_found_in_trash' => __('No hay documento en papelera'),
                'parent_item_colon' => '',
                'menu_name' => 'Directorio'
            );
            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'directorio'),
                'map_meta_cap' => true,
                'capability_type' => array('miembro', 'miembros'),
                'has_archive' => true,
                'menu_icon' => get_bloginfo('template_directory') . '/images/xfn-colleague-met.png',
                'hierarchical' => false,
                'menu_position' => 8,
                'supports' => array('title','thumbnail','editor','excerpt','comments')
            );
            register_post_type('directorio',$args);
                flush_rewrite_rules();
        
         /*  ###########################################################  Direcciones Generales ##################################################   */
            $labels = array(
                'name' => _x('Dirección General', ''),
                'singular_name' => _x('direccion', ''),
                'add_new' => _x('Agregar', ''),
                'add_new_item' => __('Agregar direccion'),
                'edit_item' => __('Editar direccion'),
                'new_item' => __('Nuevo direccion'),
                'view_item' => __('Ver direccion'),
                'search_items' => __('Buscar direccion'),
                'not_found' =>  __('Seccion en construcci&oacute;n'),
                'not_found_in_trash' => __('No hay documento en papelera'),
                'parent_item_colon' => '',
                'menu_name' => 'Direcciones Generales'
            );
            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'direccion'),
                'map_meta_cap' => true,
                'capability_type' => array('direccion', 'direcciones'),
                'has_archive' => true,
                //'menu_icon' => get_bloginfo('template_directory') . '/images/xfn-colleague-met.png',
                'hierarchical' => true,
                'menu_position' => 8,
                'supports' => array('title','thumbnail','editor','excerpt','comments')
            );
            register_post_type('direccion',$args);
                flush_rewrite_rules();
        
        
             /*  ###########################################################  Regionales ##################################################   */
            $labels = array(
                'name' => _x('Regional', ''),
                'singular_name' => _x('regional', ''),
                'add_new' => _x('Agregar', ''),
                'add_new_item' => __('Agregar regional'),
                'edit_item' => __('Editar regional'),
                'new_item' => __('Nuevo regional'),
                'view_item' => __('Ver regional'),
                'search_items' => __('Buscar regional'),
                'not_found' =>  __('Seccion en construcci&oacute;n'),
                'not_found_in_trash' => __('No hay documento en papelera'),
                'parent_item_colon' => '',
                'menu_name' => 'Regionales'
            );
            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'regional'),
                'map_meta_cap' => true,
                'capability_type' => array('regional', 'regionales'),
                'has_archive' => true,
                //'menu_icon' => get_bloginfo('template_directory') . '/images/xfn-colleague-met.png',
                'hierarchical' => false,
                'menu_position' => 8,
                'supports' => array('title','thumbnail','editor','excerpt','comments')
            );
            register_post_type('regional',$args);
                flush_rewrite_rules();
        
        
             /*  ###########################################################  Leyes ##################################################   */
            $labels = array(
                'name' => _x('Leyes', ''),
                'singular_name' => _x('leye', ''),
                'add_new' => _x('Agregar', ''),
                'add_new_item' => __('Agregar ley'),
                'edit_item' => __('Editar ley'),
                'new_item' => __('Nueva ley'),
                'view_item' => __('Ver ley'),
                'search_items' => __('Buscar leyes'),
                'not_found' =>  __('Seccion en construcci&oacute;n'),
                'not_found_in_trash' => __('No hay documento en papelera'),
                'parent_item_colon' => '',
                'menu_name' => 'Leyes'
            );
            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'leyes'),
                'map_meta_cap' => true,
                'capability_type' => array('ley', 'leyes'),
                'has_archive' => true,
                //'menu_icon' => get_bloginfo('template_directory') . '/images/xfn-colleague-met.png',
                'hierarchical' => false,
                'menu_position' => 8,
                'supports' => array('title','thumbnail','editor','excerpt','comments')
            );
            register_post_type('leyes',$args);
                flush_rewrite_rules();
        
        
            /*  ###########################################################  Decretos ##################################################   */
            $labels = array(
                'name' => _x('Decretos', ''),
                'singular_name' => _x('decreto', ''),
                'add_new' => _x('Agregar', ''),
                'add_new_item' => __('Agregar decreto'),
                'edit_item' => __('Editar decreto'),
                'new_item' => __('Nueva decreto'),
                'view_item' => __('Ver decreto'),
                'search_items' => __('Buscar decretos'),
                'not_found' =>  __('Seccion en construcci&oacute;n'),
                'not_found_in_trash' => __('No hay documento en papelera'),
                'parent_item_colon' => '',
                'menu_name' => 'Decretos'
            );
            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'decretos'),
                'map_meta_cap' => true,
                'capability_type' => array('decreto', 'decretos'),
                'has_archive' => true,
                //'menu_icon' => get_bloginfo('template_directory') . '/images/xfn-colleague-met.png',
                'hierarchical' => false,
                'menu_position' => 8,
                'supports' => array('title','thumbnail','editor','excerpt','comments')
            );
            register_post_type('decretos',$args);
                flush_rewrite_rules();
        
        
            /*  ###########################################################  Resolucions ##################################################   */
            $labels = array(
                'name' => _x('Resoluciones', ''),
                'singular_name' => _x('resolucion', ''),
                'add_new' => _x('Agregar', ''),
                'add_new_item' => __('Agregar resolucion'),
                'edit_item' => __('Editar resolucion'),
                'new_item' => __('Nueva resolucion'),
                'view_item' => __('Ver resolucion'),
                'search_items' => __('Buscar resoluciones'),
                'not_found' =>  __('Seccion en construcci&oacute;n'),
                'not_found_in_trash' => __('No hay documento en papelera'),
                'parent_item_colon' => '',
                'menu_name' => 'Resoluciones'
            );
            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'resoluciones'),
                'map_meta_cap' => true,
                'capability_type' => array('resolucion', 'resoluciones'),
                'has_archive' => true,
                //'menu_icon' => get_bloginfo('template_directory') . '/images/xfn-colleague-met.png',
                'hierarchical' => false,
                'menu_position' => 8,
                'supports' => array('title','thumbnail','editor','excerpt','comments')
            );
            register_post_type('resoluciones',$args);
                flush_rewrite_rules();
        
            
            
        }
        add_action('init','mis_posts',0); 
        
        
        function mis_taxonomias(){
            register_taxonomy(
                'tipomultimedia',
                'multimedia',
                array(
                    'label' => 'Tipo Multimedia',
                    'hierarchical' => true,
                    'query_var' => true,
                    'rewrite' => array( 'slug' => 'tipoinfo', 'with_front' => false )
                )
            );
            flush_rewrite_rules();
        
        
            
            register_taxonomy(
                'tiporesolucion',
                'resoluciones',
                array(
                    'label' => 'Categoria Resoluciones',
                    'hierarchical' => true,
                    'query_var' => true,
                    'rewrite' => array( 'slug' => 'tiporesolucion', 'with_front' => false )
                )
            );
            flush_rewrite_rules();
        
            register_taxonomy(
                'portada',
                'post',
                array(
                    'label' => 'Portada',
                    'hierarchical' => true,
                    'query_var' => true,
                    'rewrite' => array( 'slug' => 'portada', 'with_front' => false )
                )
            );
            flush_rewrite_rules();
            
        }
        add_action('init','mis_taxonomias',0);
        
        register_nav_menu( 'primary', 'Menu que va en el header' );
        register_nav_menu( 'atencion', 'Menu que va en el sidebar' );
    
        register_sidebar( array(
        'id'          => 'lateral1',
        'name'        => __( 'Area Lateral'),
        'description' => __( 'Area lateral superior' ),
        ) );
    
        register_sidebar( array(
        'id'          => 'lateral2',
        'name'        => __( 'Area Lateral'),
        'description' => __( 'Area lateral inferior' ),
        ) );
    
        register_sidebar( array(
        'id'          => 'mapasitio',
        'name'        => __( 'Area de mapa de sitio' ),
        'description' => __( 'Area de mapa de sitio' ),
        ) );



 


function hide_notices_dashboard() {
    global $wp_filter;
    if (is_network_admin() and isset($wp_filter["network_admin_notices"])) {
        unset($wp_filter['network_admin_notices']);
    } elseif(is_user_admin() and isset($wp_filter["user_admin_notices"])) {
        unset($wp_filter['user_admin_notices']);
    } else {
        if(isset($wp_filter["admin_notices"])) {
            unset($wp_filter['admin_notices']);
        }
    }
    if (isset($wp_filter["all_admin_notices"])) {
        unset($wp_filter['all_admin_notices']);
    }
}
add_action( 'admin_init', 'hide_notices_dashboard' );


function custom_excerpt_length( $length ) {
	return 17;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

function estilos_login() {
    wp_enqueue_style('login-personal-css',site_url().'/wp-content/themes/muvh/assets/css/login.css',array(),'1.0');
    
    }
    
    add_action('login_head','estilos_login');



    // Quita el icono WP en la barra de admin

function ls_admin_bar_remove() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'wp-logo' );
    }
    
    add_action( 'wp_before_admin_bar_render', 'ls_admin_bar_remove', 0 );

    // Cambiar el pie de pagina del panel de Administración
function change_footer_admin() {
    $any = date('Y');
    echo '©'.$any.' Copyright · Desarrollada por DGSWG-DGTICS ';
   }
   add_filter('admin_footer_text', 'change_footer_admin');

   // Create the function to use in the action hook


   add_action('wp_dashboard_setup', 'wpdocs_remove_dashboard_widgets');
 
   /**
    * Remover cajitas del panel administracion 
    */
   function wpdocs_remove_dashboard_widgets(){
       remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Right Now
       remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Recent Comments
       remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Incoming Links
       remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // Plugins
       remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // Quick Press
       remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');  // Recent Drafts
       remove_meta_box('dashboard_primary', 'dashboard', 'side');   // WordPress blog
       remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // Other WordPress News
       // use 'dashboard-network' as the second parameter to remove widgets from a network dashboard.
   }

   add_action( 'do_meta_boxes', 'wpdocs_remove_plugin_metaboxes' );
 
   /**
    * Remove Editorial Flow meta box for users that cannot delete pages 
    */
   function wpdocs_remove_plugin_metaboxes(){
       if ( ! current_user_can( 'delete_others_pages' ) ) { // Only run if the user is an Author or lower.
           remove_meta_box( 'ef_editorial_meta', 'post', 'side' ); // Remove Edit Flow Editorial Metadata
       }
   }

/**
 * Remove the WordPress News & Events widget from Network Dashboard
 */
function wpdocs_remove_network_dashboard_widgets() {
    remove_meta_box( 'dashboard_primary', 'dashboard-network', 'side' );
}
add_action( 'wp_network_dashboard_setup', 'wpdocs_remove_network_dashboard_widgets' );

/**
 * Remove native dashboard widgets
 */
add_action( 'wp_dashboard_setup', function(){

    global $wp_meta_boxes;

    remove_action( 'welcome_panel', 'wp_welcome_panel' );
    unset( $wp_meta_boxes['dashboard'] );

    /**
     * Remove others meta boxes added by plugins
     * Example: Yoast Seo
     */
    remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' );

} );


function example_dashboard_widget_function() {
    // Display whatever it is you want to show
    echo '<div align="center"><img src="'.get_bloginfo('template_directory').'/images/muvhama.jpg" /></div>';
    ?>
  	<p style="font-size:24px; line-height: 1.3em;">Bienvenido al panel de administración de www.muvh.gov.py, 
  		puede navegar el menu lateral para administrar el contenido de su sitio</p>
 <?php
}

// Create the function use in the action hook
function example_add_dashboard_widgets() {
    wp_add_dashboard_widget('example_dashboard_widget', 'Bienvenida', 'example_dashboard_widget_function');
}
// Hoook into the 'wp_dashboard_setup' action to register our other functions
add_action('wp_dashboard_setup', 'example_add_dashboard_widgets' );
//remove_action('welcome_panel','wp_welcome_panel');


// Eliminar version de WP
remove_action('wp_head', 'wp_generator');

// oculta mensaje error en el login 
function remove_login_errors( $error ) {
    return null;
}
add_filter( 'login_errors', 'remove_login_errors');

/*
 * Eliminamos el acceso a la p�gina de plugins 
 * del men� principal incluso para usuarios administradores.
 */
function mytheme_remove_from_menu() {
    remove_menu_page('plugins.php');
}
add_action('admin_menu', 'mytheme_remove_from_menu');

//Elimina referencias a la version de WordPress

function quitar_version_wp() {

return '';

}

function my_footer_shh() {
    remove_filter( 'update_footer', 'core_update_footer' ); 
}

add_action( 'admin_menu', 'my_footer_shh' );

function force_strong_passwords( $errors, $update, $user_data ) {
    $user_login = $user_data->user_login;
    $user_pass = $user_data->user_pass;

    if ( !is_null( $user_pass ) ) {
        if ( strtolower( $user_login ) === strtolower( $user_pass ) ) {
            $errors->add( 'my_distinct_user_pass', __( 'Username and password must be different', 'your_textdomain' ) );
        }
        if ( strlen( $user_pass ) < 8 ) {
            $errors->add( 'my_pass_length', __( 'Password must be at least 8 characters', 'your_textdomain' ) );
        }
        if ( ! preg_match( '/[0-9]/', $user_pass ) ) {
            $errors->add( 'my_pass_numeric', __( 'Password must have at least 1 numeric character', 'your_textdomain' ) );
        }
        if ( ! preg_match( '/[a-z]/', $user_pass ) ) {
            $errors->add( 'my_pass_lowercase', __( 'Password must have at least 1 lower case character', 'your_textdomain' ) );
        }
        if ( ! preg_match( '/[A-Z]/', $user_pass ) ) {
            $errors->add( 'my_pass_uppercase', __( 'Password must have at least 1 upper case character', 'your_textdomain' ) );
        }
    }
}
add_action( 'user_profile_update_errors', 'force_strong_passwords', 0, 3 );

add_filter ('cron_schedules', 'ejr_improved_cron_intervalo' );
function ejr_improved_cron_intervalo () {
    $segundos= 900; // Aqu� el n�mero de segundos que quieras. Lo he puesto a 15*60=900, 15 minutos 
    $intervalo ['ejr_mi_intervalo'] = array ('intervalo' => $segundos, 'display' => sprintf ('%d segundos', $segundos));
    return $interval;
}
 
add_filter ('imcron_interval_id', 'ejr_establece_improved_cron_intervalo' );
function ejr_establece_improved_cron_intervalo () {
    return 'ejr_mi_intervalo';
}



/* Evitar que se creen otros tamaños de imagen */
function ayudawp_desactiva_otros_medios_adicionales() {
    remove_image_size('post-thumbnail'); // desactiva imágenes añadidas mediante set_post_thumbnail_size() 
    remove_image_size('otro-tamaño-adicional'); // desactiva cualquier otro tamaño de imagen adicional
    }
    add_action('init', 'ayudawp_desactiva_otros_medios_adicionales');


    //Limitar el acceso a la librería solo a tus propios archivos
function mostrar_solamente_archivos_del_usuario($query){
    $user_id = get_current_user_id();

    if($user_id && !current_user_can('activate_plugins') && !current_user_can('edit_others_posts')){
        $query['author'] = $user_id;
    }
    return $query;
} 
add_filter('ajax_query_attachments_args', 'mostrar_solamente_archivos_del_usuario');

/*
 * Elimina mensaje de actualizacion a los usuarios  */
function wpdanger_remove_ver($src, $handle) {
    $handles = ['style','script'];
    if(strpos($src, 'ver=') && !in_array($handle, $handles, true))
      $src = remove_query_arg('ver', $src);
    return $src;
  }
  add_filter('style_loader_src', 'wpdanger_remove_ver', 9999, 2);
  add_filter('script_loader_src', 'wpdanger_remove_ver', 9999, 2);
  function custom_resoluciones_results_per_page($query) {
    if ($query->is_main_query() && is_post_type_archive('resoluciones')) {
        $query->set('posts_per_page', 10); // Reemplaza 10 con la cantidad de resultados que deseas mostrar por página.
    }
    return $query;
}
add_filter('pre_get_posts', 'custom_resoluciones_results_per_page');

function custom_resoluciones_search_limits( $limits ) {
    if ( is_post_type_archive('resoluciones') && is_search() ) {
        global $wpdb;
        $limits = 'LIMIT 1000';
    }
    return $limits;
}
add_filter( 'post_limits', 'custom_resoluciones_search_limits' );

//   function wpdocs_resoluciones_custom_search_query($query)
// {
//     if ($query->is_search() && $query->is_main_query() && !is_admin()) {
//         $query->set('post_type', 'resoluciones'); // Buscar solo en el tipo de publicación "resoluciones"
//     }
// }
// add_action('pre_get_posts', 'wpdocs_resoluciones_custom_search_query');
// function custom_search_filter($query) {
//     if ($query->is_search && !is_admin()) {
//         $query->set('post_type', 'resoluciones');
//     }
//     return $query;
// }
// add_filter('pre_get_posts', 'custom_search_filter');
