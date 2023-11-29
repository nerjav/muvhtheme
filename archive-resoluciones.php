<?php get_header() ?>
<main id="main-content" class="mt-0">
    <div class="fondo">
        <div class="container">
            <div class="title">
                <h1 class="h-2">Resoluciones</h1>
            </div>

            <?php bootstrap_breadcrumb() ?>
         
        </div>
    </div>

    <div class="container">
        <div class="row ">
            <div class="col-12">
            <div class="row justify-content-center">
    <div class="col-md-6">
    <div class="form-group">
    <label for="search_resoluciones">Buscar Resolución:</label>
    <input type="text" class="form-control" id="search_resoluciones" placeholder="Buscar resolución ej:  N° 308">
</div>

<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'resoluciones',
    'posts_per_page' => -1, // Mostrar 10 resultados por página
    'orderby' => 'date',
    'order' => 'DESC',
    'paged' => $paged,
    's' => get_search_query() // agregar el término de búsqueda a la consulta
);

$query = new WP_Query($args);
if ($query->have_posts()) {
    echo '<div class="table-responsive">';
    echo '<table class="table table-sm">';
    echo '<thead><tr><th>Resolución N° </th><th>Fecha</th><th>Documento</th></tr></thead>';
    echo '<tbody class="searchable">';
    while ($query->have_posts()) {
        $query->the_post();
        $titulo = get_the_title();
        $url = get_post_meta(get_the_ID(), 'url_meta', true);
        $fecha_personalizada = get_post_meta($post->ID, 'fecha', true);
        $fecha_formateada = date('d/m/Y', strtotime($fecha_personalizada));
        echo '<tr><td>' . $titulo . '</td><td>' . $fecha_formateada . '</td><td><a href="' . esc_url(get_post_meta($post->ID, 'enlace_', true)) . '" target="_blank" class="btn btn-primary btn-sm">Ver</a></td></tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    wp_reset_postdata();

    // Actualizar el valor de $paged después de que se realiza una búsqueda
    if (get_search_query()) {
        $paged = max(1, get_query_var('paged'));
    }

  
}
?>
<?php
    $total_results = $wp_query->found_posts;
    $current_page = get_query_var('paged') ? get_query_var('paged') : 1;
    $results_per_page = get_query_var('posts_per_page');
    $start_result = (($current_page - 1) * $results_per_page) + 1;
    $end_result = min($start_result + $results_per_page - 1, $total_results);
?>
<p>Mostrando registros del <?php echo $start_result; ?> al <?php echo $end_result; ?> de un total de <?php echo $total_results; ?> registros.</p>
<script>
    jQuery(document).ready(function($) {
        $('#search_resoluciones').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('.searchable tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

            </div>
        </div>
    </div>