<?php
/**
 * Clock Widget Template
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;
use WP_Widget;

class Clock_Widget extends WP_Widget {
	use Singleton;
	function __construct() {

		parent::__construct(
			'clock_widget',  // Base ID
			'Clock Widget',  // Name
			[ 'description' => __( 'Clock Widget', 'asgard' ), ] // Args
		);
	}

	public function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;

		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}
		?>
        <section class="card">
            <div class="clock card-body">
                <span id="time"></span>
                <span id="ampm"></span>
                <span id="time-emoji"></span>
            </div>
        </section>
		<?php
		echo $after_widget;

	}

	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'asgard' );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'asgard' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php

	}

	public function update( $new_instance, $old_instance ) {

		$instance = [];

		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}