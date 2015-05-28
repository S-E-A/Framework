<?php

if ( ! function_exists( 'seaframework_customizer_live_preview' ) ) {
    function seaframework_customizer_live_preview() {

        wp_enqueue_script( 
              'seaframework-themecustomizer',			//Give the script an ID
              get_template_directory_uri() . '/js/theme-customizer.js', //Point to file
              array( 'jquery', 'customize-preview' ),	//Define dependencies
              '',						//Define a version (optional) 
              true						//Put script in footer?
        );

    }
}

if ( ! function_exists( 'seaframework_customize_register' ) ) {
    function seaframework_customize_register( $wp_customize ) {
       //All our sections, settings, and controls will be added here

        $wp_customize->add_section( 'seaframework_template_section' , array(
                'title'      => __( 'Template Settings', 'seaframework' ),
                'priority'   => 30,
            ) 
        );

        $wp_customize->add_setting( 'header_version' , array(
                'default'     => 'default',
                'transport'   => 'refresh',
            ) 
        );

        $wp_customize->add_control( 
            new SEA\Framework\Template_Dropdown_Custom_Control( $wp_customize, 'header_template', array(
                    'label'        => __( 'Header Template', 'seaframework' ),
                    'section'    => 'seaframework_template_section',
                    'settings'   => 'header_version',
                ),
                'Header'
            ) 
        );

        $wp_customize->add_setting( 'footer_version' , array(
                'default'     => 'default',
                'transport'   => 'refresh',
            ) 
        );

        $wp_customize->add_control( 
            new SEA\Framework\Template_Dropdown_Custom_Control( $wp_customize, 'footer_template', array(
                    'label'        => __( 'Footer Template', 'seaframework' ),
                    'section'    => 'seaframework_template_section',
                    'settings'   => 'footer_version',
                ),
                'Footer'
            ) 
        ); 
        
        $post_types = get_post_types( array(), 'objects' );
        
        foreach ( $post_types as $post_type ) {
            
            echo $post_type->labels->singular_name . ' ' . $post_type->name . ' ';
            
        }

        $wp_customize->add_section( 'seaframework_color_section' , array(
                'title'      => __( 'Color Settings', 'seaframework' ),
                'priority'   => 30,
            ) 
        );

        $wp_customize->add_setting( 'main_textcolor' , array(
                'default'     => '#000',
                'transport'   => 'postMessage',
            ) 
        );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_textcolor', array(
        'label'        => __( 'Text Color', 'seaframework' ),
        'section'    => 'seaframework_color_section',
        'settings'   => 'main_textcolor',
    ) ) );

        $wp_customize->add_setting( 'link_textcolor' , array(
                'default'     => '#00E',
                'transport'   => 'postMessage',
            ) 
        );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_textcolor', array(
        'label'        => __( 'Link Color', 'seaframework' ),
        'section'    => 'seaframework_color_section',
        'settings'   => 'link_textcolor',
    ) ) );

        $wp_customize->add_setting( 'background_color' , array(
                'default'     => '#fff',
                'transport'   => 'postMessage',
            ) 
        );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
        'label'        => __( 'Background Color', 'seaframework' ),
        'section'    => 'seaframework_color_section',
        'settings'   => 'background_color',
    ) ) );
        
        $wp_customize->add_section( 'seaframework_logo_section' , array(
                'title'      => __( 'Logo Settings', 'seaframework' ),
                'priority'   => 30,
            ) 
        );
        
        $wp_customize->add_setting( 'logo_image' , array(
                'default'     => '',
                'transport'   => 'postMessage',
            ) 
        );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_image', array(
        'label'        => __( 'Header Logo', 'seaframework' ),
        'section'    => 'seaframework_logo_section',
        'settings'   => 'logo_image',
    ) ) );

    }
}

if ( ! function_exists( 'generate_css' ) ) {
    function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {
        $return = '';
        $mod = get_theme_mod( $mod_name );
        if ( ! empty( $mod ) ) {
            $return = sprintf('%s { %s: %s; }',
                              $selector,
                              $style,
                              $prefix . $mod . $postfix
                             );
            if ( $echo ) {
                echo $return;
            }
        }
        return $return;
    }
}

?>