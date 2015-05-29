    </div> <!-- $main .site-main -->
    <footer id = "colophon" class = "site-footer" role = "content-info">
        <?php locate_template('footer-' . get_theme_mod('footer_version', 'default') . '.php', true, true ); ?>
    </footer>
</div> <!-- #page .hfeed .site -->
<?php wp_footer(); ?>
