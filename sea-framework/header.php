<!DOCTYPE html>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <title><?php
/*
* Print the <title> tag based on what is being viewed.
*/
global $page, $paged;

$title_separator = apply_filters( 'seaframework_site_title_separator', '|' );

wp_title( $title_separator, true, 'right' );

// Add the blog name.
bloginfo( 'name' );

// Add the blog description for the home/front page.
$site_description = get_bloginfo( 'description', 'display' );
if ( $site_description && ( is_home() || is_front_page() ) )
    echo " $title_separator $site_description";

// Add a page number if necessary:
if ( $paged >= 2 || $page >= 2 )
    echo ' ' . $title_separator . ' ' . sprintf( __( 'Page %s', 'shape' ), max( $paged, $page ) );

        ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

    <?php

if ( is_child_theme() && file_exists( get_stylesheet_directory() . '/js/html5.js' ) ) {

    $html_five_js = get_stylesheet_directory_uri() . '/js/hml5.js';

}
else {

    $html_five_js = SEA_FLOOR_URI . '/js/html5.js';

}

    ?>

    <!--[if lt IE 9]>
<script src="<?php echo $html_five_js; ?>" type="text/javascript"></script>
<![endif]-->

    <?php locate_template( 'partials/customizer', true, true ); ?>

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <nav class="navbar navbar-default" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php bloginfo( 'url' )?>"><?php bloginfo( 'name' )?></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <?php /* Primary navigation */
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'depth' => 2,
                    'container' => false,
                    'menu_class' => 'nav',
                    'container'         => 'div',
                    'container_class'   => 'collapse navbar-collapse',
                    //'container_id'      => 'bs-example-navbar-collapse-1',
                    'menu_class'        => 'nav navbar-nav',
                    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                    //Process nav menu using our custom nav walker
                    'walker' => new wp_bootstrap_navwalker()
                )
            );
            ?>
        </div>
    </nav>

    <?php locate_template( 'header-' . get_theme_mod('header_version', 'default') . '.php', true, true ); ?>
