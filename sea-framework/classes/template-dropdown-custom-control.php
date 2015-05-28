<?php
/*
 * Customize for template select, extend the WP customizer
 */

namespace SEA\Framework;

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

class Template_Dropdown_Custom_Control extends \WP_Customize_Control {

    private $users = false;

    public function __construct($manager, $id, $args = array(), $base = 'Header', $options = array() )
    {
        $parent = glob( get_template_directory() . '/*.*' );
        
        foreach ( $parent as $template ) {
            $parent_templates[basename( $template, '.php' )] = $template;
        }
        
        if ( is_child_theme() ) {
            
            $child = glob( get_stylesheet_directory() . '/*.*' );
        
            foreach ( $child as $template ) {
                $child_templates[basename( $template, '.php' )] = $template;
            }
            
            $this->files = array_merge( $parent_templates, $child_templates );
            
        }
        else {
            
            $this->files = $parent_templates;
            
        }
        
        
        $this->base = $base;

        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render the control's content.
     *
     * Allows the content to be overriden without having to rewrite the wrapper.
     *
     * @return  void
     */
    public function render_content()
    {
        if(empty($this->files))
        {
            return false;
        }
	?>
		<label>
			<span class="customize-control-title" ><?php echo esc_html( $this->label ); ?></span>
            
			<select <?php $this->link(); ?>>
			<?php foreach( $this->files as $file => $full_path ) {
                $option = str_replace( strtolower( $this->base ) . '-', '', basename($full_path, '.php') );
            
				if ( ! preg_match( '|' . $this->base . ' Name:(.*)$|mi', file_get_contents( $full_path ), $header ) )
					continue;
                    printf('<option value="%s" %s>%s</option>', $option, ( $this->id == get_theme_mod( $this->id ) ) ? 'selected' : '', _cleanup_header_comment( $header[1] ) );
        
            } ?>
                
			</select>
		</label>
	<?php
    }
} // end class
?>