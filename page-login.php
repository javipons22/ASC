<?php
/*
Template Name: LOGIN
 */
get_header();

?>
<div class="container">
    <section class="upload">
<?php $args = array(
        'form_id' => 'form-servicios');
wp_login_form($args);
?>
</section>
</div>

<script> var showButtons = false;</script>

    <?php get_footer(); ?>