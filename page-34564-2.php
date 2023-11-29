<?php /* Template Name: Awesome Page */

get_header();

?>

<div class="latest-posts"></div>

<script>

    const url = 'https://www.muvh.gov.py/wp-json/wp/v2/posts?job-type=resoluciones'.'https://www.cadenadial.com/wp-json/wp/v2/posts';
   
    const postsContainer = document.querySelector('.latest-posts');

    fetch(url)
    .then(response => response.json())
    .then(data => {
        data.map( post => {
            const innerContent = 
            `
            <li>
             <h2>${post.title.rendered}</h2>
             ${post.excerpt.rendered}
             <a href="${post.link}">ver informacion</a>
            </li>
            `
            postsContainer.innerHTML += innerContent;
        })
    });

</script>

<?php

$response = wp_remote_get( 'https://www.muvh.gov.py/wp-json/wp/v2/posts?job-type=resoluciones'.'https://www.cadenadial.com/wp-json/wp/v2/posts' );


$posts = json_decode( wp_remote_retrieve_body( $response ) );

echo '<div class="latest-posts">';
    foreach( $posts as $post ) {
        echo '<li><h2>'.$post->title->rendered.'</h2>'.$post->excerpt->rendered.'<a href="' . $post->link . '">Ver información</a></li>';
    }
echo '</div>';


?>