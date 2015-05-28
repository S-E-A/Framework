<?php

add_action( 'admin_notices', 'seaframework_bad_dog' );
function seaframework_bad_dog() {

    if ( ! is_child_theme() ) {
?>

        <div class = "error">
            <p><?php _e( 'Use a <a href = "https://codex.wordpress.org/Child_Themes" title = "Child Themes - WP Codex">Child Theme</a>! You\'re making me very sad.', 'seaframework' ); ?></p>    
        </div>

<?php
    }

}

add_action( 'login_head', 'seaframework_custom_login_logo' );

if ( ! function_exists( 'seaframework_custom_login_logo' ) ) {
    function seaframework_custom_login_logo() {
        
        _e( '<style type="text/css">
        h1 a { background-image: url(' . SEA_FLOOR_URI . '/images/login.png) !important; background-size: 311px 100px !important;height: 100px !important; width: 311px !important; margin-bottom: 0 !important; padding-bottom: 0 !important; }
        .login form { margin-top: 10px !important; }
        </style>', 'seaframework' );
        
    }
}

add_filter( 'login_headerurl', 'seaframework_url_login_logo' );

if ( ! function_exists( 'seaframework_url_login_logo' ) ) {
    function seaframework_url_login_logo() {
        
        return get_bloginfo( 'wpurl' );
        
    }
}

add_filter( 'login_headertitle', 'seaframework_login_logo_url_title' );

if ( ! function_exists( 'seaframework_login_logo_url_title' ) ) {
    function seaframework_login_logo_url_title() {
        
        return get_bloginfo( 'name' ) . ' - Home';
        
    }
}

add_filter('gettext', 'seaframework_change_howdy', 10, 3);

if ( ! function_exists( 'seaframework_change_howdy' ) ) {
    function seaframework_change_howdy($translated, $text, $domain) {

        if ( ! is_admin() || 'default' != $domain ) {
            return $translated;
        }

        if ( false !== strpos( $translated, 'Howdy' ) ) {
            return str_replace( 'Howdy', 'Welcome', $translated );
        }

        return $translated;
        
    }
}

add_filter('admin_footer_text', 'seaframework_change_footer_admin');

if ( ! function_exists( 'seaframework_change_footer_admin' ) ) {
    function seaframework_change_footer_admin() { 
        
        $theme = get_theme_data( SEA_FLOOR . '/style.css' );

        _e( $theme['Name'] . ' v.' . $theme['Version'] . ' &mdash; &copy; Copyright ' . date( 'Y' ), 'seaframework' ); 

    }
}

add_action( 'after_setup_theme', 'seaframework_classes_autoloader_controller' );

if ( ! function_exists( 'seaframework_classes_autoloader_controller' ) ) {
    function seaframework_classes_autoloader_controller() {

        define( 'SEA_FLOOR', get_template_directory() );
        define( 'SEA_FLOOR_URI', get_template_directory_uri() );
        spl_autoload_register( 'seaframework_classes_autoloader' );

    }
}

if ( ! function_exists( 'seaframework_classes_autoloader' ) ) {
    function seaframework_classes_autoloader( $resource = '' ) {

        $namespace_root = 'SEA\Framework';

        $resource = trim( $resource, '\\' );

        if ( empty( $resource ) || strpos( $resource, '\\' ) === false || strpos( $resource, $namespace_root ) !== 0 ) {
            //not our namespace, bail out
            return;
        }

        $path = str_replace(
            '_',
            '-',
            implode(
                '/',
                array_slice(	//remove the namespace root and grab the actual resource
                    explode( '\\', $resource ),
                    2
                )
            )
        );

        $path = sprintf( '%s/classes/%s.php', untrailingslashit( SEA_FLOOR ), strtolower( $path ) );
        
        if ( file_exists( $path ) ) {
            require_once $path;
        }

    }
}

add_action( 'init', 'seaframework_customizer_include' );

if ( ! function_exists( 'seaframework_customizer_include' ) ) {
    function seaframework_customizer_include() {

        require_once( 'framework/theme_customizer.php' );

    }
}

add_action( 'after_setup_theme', 'seaframework_setup' );

if ( ! function_exists( 'seaframework_setup' ) ) {
    function seaframework_setup() {

        define( 'BOOTSTRAP_VER', '3.3.4' );
        define( 'FONTAWESOME_VER', '4.3.0' );

        add_action( 'wp_enqueue_scripts', 'seaframework_bootstrap_enqueue' );

        add_action( 'wp_enqueue_scripts', 'seaframework_fontawesome_enqueue' );

        add_action( 'customize_register', 'seaframework_customize_register' );

        add_action( 'customize_preview_init', 'seaframework_customizer_live_preview' );

        require_once( 'framework/theme_shortcodes.php' );

    }

}

if ( ! function_exists( 'seaframework_bootstrap_enqueue' ) ) {
    function seaframework_bootstrap_enqueue() {

        wp_enqueue_style( 
            'bootstrap-css',			//Give the style an ID
            SEA_FLOOR_URI . '/bootstrap-' . BOOTSTRAP_VER . '-dist/css/bootstrap.min.css' //Point to file
        );

        wp_enqueue_script( 
            'bootstrap-js',			//Give the script an ID
            SEA_FLOOR_URI . '/bootstrap-' . BOOTSTRAP_VER . '-dist/js/bootstrap.min.js', //Point to file
            array( 'jquery' ),	//Define dependencies
            '',						//Define a version (optional) 
            true						//Put script in footer?
        );

    }
}

if ( ! function_exists( 'seaframework_fontawesome_enqueue' ) ) {
    function seaframework_fontawesome_enqueue() {

        wp_enqueue_style( 
            'fontawesome-css',			//Give the style an ID
            SEA_FLOOR_URI . '/font-awesome-' . FONTAWESOME_VER . '/css/font-awesome.min.css' //Point to file
        );

    }
}

add_action( 'init', 'seaframework_shortcode_button_init' );
function seaframework_shortcode_button_init() {

    //Abort early if the user will never see TinyMCE
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
        return;

    //Add a callback to regiser our tinymce plugin   
    add_filter("mce_external_plugins", "seaframework_register_tinymce_plugin"); 

    // Add a callback to add our button to the TinyMCE toolbar
    add_filter('mce_buttons', 'seaframework_add_tinymce_button');
}


//This callback registers our plug-in
function seaframework_register_tinymce_plugin($plugin_array) {
    $plugin_array['bootstrap_shortcode_button'] = get_template_directory_uri() . '/js/shortcode-buttons.js';
    return $plugin_array;
}

//This callback adds our button to the toolbar
function seaframework_add_tinymce_button($buttons) {
    //Add the button ID to the $button array
    array_push( $buttons, 'bootstrap_shortcode_button' );
    return $buttons;
}

register_sidebar( 
    array(
        'name'          =>  'Footer - Left',
        'id'            =>  'footer-left',
        'description'   =>  'Appears in the Footer area. Positioning/Styling determined by Template Parts.',
        'before_widget' =>  '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  =>  '</aside>',
        'before_title'  =>  '<h3 class="widget-title">',
        'after_title'   =>  '</h3>',
    ) 
);

register_sidebar( 
    array(
        'name'          =>  'Footer - Center',
        'id'            =>  'footer-center',
        'description'   =>  'Appears in the Footer area. Positioning/Styling determined by Template Parts.',
        'before_widget' =>  '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  =>  '</aside>',
        'before_title'  =>  '<h3 class="widget-title">',
        'after_title'   =>  '</h3>',
    ) 
);

register_sidebar( 
    array(
        'name'          =>  'Footer - Right',
        'id'            =>  'footer-right',
        'description'   =>  'Appears in the Footer area. Positioning/Styling determined by Template Parts.',
        'before_widget' =>  '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  =>  '</aside>',
        'before_title'  =>  '<h3 class="widget-title">',
        'after_title'   =>  '</h3>',
    ) 
);


add_action( 'widgets_init', 'seaframework_register_copyright_widget' );
function seaframework_register_copyright_widget() {
    
    register_widget( 'SEA\Framework\Copyright_Widget' );
    
}

require_once( 'framework/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'seaframework_require_plugins' );
function seaframework_require_plugins() {
    
    $plugins = array(
        
        array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => true,
        ),
        array(
            'name'      => 'Synchi',
            'slug'      => 'synchi',
            'required'  => true,
        ),
        array(
            'name'      => 'Google Analytics Dashboard for WP',
            'slug'      => 'google-analytics-dashboard-for-wp',
            'required'  => false,
        ),
        array(
            'name'      => 'Lollipop Picker',
            'slug'      => 'lollipop-picker',
            'source'    => SEA_FLOOR . '/plugin/lollipop-picker.zip',
            'required'  => false,
        ),
        
    );
    
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'seaframework-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'seaframework' ),
            'menu_title'                      => __( 'Install Plugins', 'seaframework' ),
            'installing'                      => __( 'Installing Plugin: %s', 'seaframework' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'seaframework' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'seaframework' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'seaframework' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'seaframework' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
    
    tgmpa( $plugins, $config );
    
}

?>