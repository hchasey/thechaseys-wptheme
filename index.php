<?php
/* Redirect To First Post */
if (have_posts()) {
    while (have_posts()) {
        the_post();
        wp_redirect(get_permalink());
    }
}
?>