<?php
/**
 * Adds Copyright_Widget widget.
 */

namespace SEA\Framework;

if ( ! class_exists( 'WP_Widget' ) )
    return NULL;

class Copyright_Widget extends \WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'copyright_widget', // Base ID
			__( 'S.E.A. Framework - Copyright Widget', 'seaframework' ), // Name
			array( 'description' => __( 'Easily Include an Auto-Updating Copyright', 'seaframework' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['copyright'] ) ) {
			echo __( '&copy; Copyright ' . date( 'Y' ) . ' &mdash; ' . $instance['copyright'], 'seaframework' );
		}
		
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$copyright = ! empty( $instance['copyright'] ) ? $instance['copyright'] : 'Fueled by <a href = "http://getaos.com" title = "American Office Solutions">AOS</a>';
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'copyright' ); ?>"><?php _e( 'Copyright Text (Prefixed by Year Automagically):' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'copyright' ); ?>" name="<?php echo $this->get_field_name( 'copyright' ); ?>" type="text" value="<?php echo esc_attr( $copyright ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['copyright'] = ( ! empty( $new_instance['copyright'] ) ) ? strip_tags( $new_instance['copyright'] ) : '';

		return $new_instance;
	}

} // class Copyright_Widget