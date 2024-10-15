<?php
/**
 * Header Template
 *
 * @package Asgard
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php
if(function_exists('wp_body_open')) {
	wp_body_open();
} ?>
<div class="site" id="page">
    <header class="bg-white">
        <?php
        get_template_part('template-parts/header/top-bar'); 
        get_template_part('template-parts/header/middle-bar'); 
        get_template_part('template-parts/header/nav'); 
        ?>
    </header>
    <div id="content" class="site-content">