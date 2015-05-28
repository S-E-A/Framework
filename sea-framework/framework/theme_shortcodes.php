<?php

add_shortcode( 'row', 'seaframework_row_shortcode' );
function seaframework_row_shortcode( $atts, $content = "" ) {
    
    $atts = shortcode_atts(
        array(
            'id'        =>  $id,
            'classes'   =>  $classes,
            'padding'   =>  $padding,
        ),
        $atts,
        'row'
    );

    $out = '';
    $out .= '<div ' . ( ( isset( $atts['id'] ) && $atts['id'] !== '' ) ? 'id = ' . $atts['id'] . '' : '' ) . ' class = "row' . ( ( isset( $atts['classes'] ) && $atts['classes'] !== '' ) ? ' ' . $atts['classes'] : '' ) . '">' . do_shortcode( $content ) . '</div>';

    return html_entity_decode( $out );

}

add_shortcode( 'col', 'seaframework_col_shortcode' );
function seaframework_col_shortcode( $atts, $content = "" ) {

    $atts = shortcode_atts(
        array(
            'lg'        =>  $lg,
            'lg_offset' =>  $lg_offset,
            'md'        =>  $md,
            'md_offset' =>  $md_offset,
            'sm'        =>  $sm,
            'sm_offset' =>  $sm_offset,
            'xs'        =>  $xs,
            'xs_offset' =>  $sm_offset,
            'id'        =>  $id,
            'classes'   =>  $classes,
            'padding'   =>  $padding,
        ),
        $atts,
        'col'
    );
    
    $large = '';
    $lg_offset = '';
    $medium = '';
    $md_offset = '';
    $small = '';
    $sm_offset = '';
    $extrasmall = '';
    $xs_offset = '';
    $classes = '';
    
    if ( isset( $atts['lg'] ) && $atts['lg'] !== '' ) {
        $large = 'col-lg-' . $atts['lg'] . ' ';
    }
    
    if ( isset( $atts['lg_offset'] ) && $atts['lg_offset'] !== '' ) {
        $lg_offset = 'col-lg-offset-' . $atts['lg_offset'] . ' ';
    }
    
    if ( isset( $atts['md'] ) && $atts['md'] !== '' ) {
        $medium = 'col-md-' . $atts['md'] . ' ';
    }
    
    if ( isset( $atts['md_offset'] ) && $atts['md_offset'] !== '' ) {
        $md_offset = 'col-md-offset-' . $atts['md_offset'] . ' ';
    }
    
    if ( isset( $atts['sm'] ) && $atts['sm'] !== '' ) {
        $small = 'col-sm-' . $atts['sm'] . ' ';
    }
    
    if ( isset( $atts['sm_offset'] ) && $atts['sm_offset'] !== '' ) {
        $sm_offset = 'col-sm-offset-' . $atts['sm_offset'] . ' ';
    }
    
    if ( isset( $atts['xs'] ) && $atts['xs'] !== '' ) {
        $extrasmall = 'col-xs-' . $atts['xs'] . ' ';
    }
    
    if ( isset( $atts['xs_offset'] ) && $atts['xs_offset'] !== '' ) {
        $xs_offset = 'col-xs-offset-' . $atts['xs_offset'] . ' ';
    }
    
    if ( isset( $atts['classes'] ) && $atts['classes'] !== '' ) {
        $classes = $atts['classes'];
    }

    $out = '';
    $out .= '<div ' . ( ( isset( $atts['id'] ) && $atts['id'] !== '' ) ? 'id = ' . $atts['id'] . '' : '' ) . ' class = "' . $large . $lg_offset . $medium . $md_offset . $small . $sm_offset . $xs_offset . $extrasmall . $classes . '">' . do_shortcode( $content ) . '</div>';

    return html_entity_decode( $out );

}

?>