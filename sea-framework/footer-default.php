<?php

/*
 * Footer Name: Default Footer
 */

?>

<div class = "site-info row">
    
    <div class = "col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div id = "footer-left" class = "secondary col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <?php
            if ( is_active_sidebar( 'footer-left' ) ) {
                dynamic_sidebar( 'footer-left' );
            }
            ?>
        </div>

        <div id = "footer-center" class = "secondary col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
            <?php
            if ( is_active_sidebar( 'footer-center' ) ) {
                dynamic_sidebar( 'footer-center' );
            }
            ?>
        </div>

        <div id = "footer-right" class = "secondary col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right">
            <?php
            if ( is_active_sidebar( 'footer-right' ) ) {
                dynamic_sidebar( 'footer-right' );
            }
            ?>
        </div>
        
    </div>
    
</div>