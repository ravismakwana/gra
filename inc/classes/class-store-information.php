<?php
/**
 * Woocommerce Hooks Customization
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;
use WP_Widget;
use ASGARD_THEME\Inc\Traits\Singleton;

class Store_Information extends WP_Widget {
	use Singleton;

	public function __construct() {

		parent::__construct(
			'storeinformation_widget', esc_html__( 'Store Information', 'rv' ), array( 'description' => esc_html__( 'This widget is used to display stores information like Phone, Address, Office hours etc.', 'rv' ), ) // Args
		);
		$this->setup_hooks();
	}

	public function setup_hooks() {
		// shortcodes
		add_action( 'widgets_init', [ $this, 'register_storeinformation_widget' ] );
	}

	public function register_storeinformation_widget() {
		register_widget( 'ASGARD_THEME\Inc\Store_Information' );
	}

	private $widget_fields = array(
		array(
			'label' => 'Email Address',
			'id'    => 'emailaddress_text',
			'type'  => 'text',
		),
		array(
			'label' => 'Phone Number',
			'id'    => 'phonenumber_text',
			'type'  => 'text',
		),
		array(
			'label' => 'Monday to Friday',
			'id'    => 'mondaytofriday_textarea',
			'type'  => 'text',
		),
		array(
			'label' => 'Saturday to Sunday',
			'id'    => 'saturday_sunday_timing',
			'type'  => 'text',
		),
		array(
			'label' => 'Time Zone',
			'id'    => 'timezone_text',
			'type'  => 'text',
		),
		array(
			'label' => 'Address',
			'id'    => 'shop_address',
			'type'  => 'textarea',
		),
	);

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
//		$store_email_image = $linea_Options['email_address_image'];
//		$store_email_image = get_template_directory_uri().'/assets/build/src/img/email.webp';
//        echo "<pre>";
//        print_r($store_email_image);
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		// Output generated fields
		echo '<div class="store-info-section text-white">';
		if ( ! empty( $instance['shop_address'] ) ) {
			echo '<p><a href="javascript:void(0);" aria-label="Address" class="text-white text-decoration-none d-flex align-items-center lh-1 text-break"><svg class="me-2" width="16" height="16" fill="#fff"><use href="#icon-marker"></use></svg><span class="fw-300"> ' . $instance['shop_address'] . '</span></a></p>';
		}
		if ( ! empty( $instance['emailaddress_text'] ) ) {
			echo '<p><a href="mailto:' . $instance['emailaddress_text'] . '" aria-label="Footer Mail" class="text-white text-decoration-none d-flex align-items-center lh-1 text-break"><svg class="me-2" width="16" height="16" fill="#fff"><use href="#icon-email"></use></svg><span class="fw-300"> ' . $instance['emailaddress_text'] . '</span></a></p>';
		}
        if ( ! empty( $instance['phonenumber_text'] ) ) {
	        $phoneNumberWhatsAppLink = extractAndCreateWhatsAppLink($instance['phonenumber_text']);
			echo '<p><a href="'.$phoneNumberWhatsAppLink.'" aria-label="Footer Phone" class="text-white text-decoration-none d-flex align-items-center lh-1" target="_blank"><svg class="me-2" width="16" height="16" fill="#fff"><use href="#icon-whatsapp"></use></svg><span class="fw-300"> ' . $instance['phonenumber_text'] . '</span></a></p>';
		}
		if ( (! empty( $instance['mondaytofriday_textarea'] )) || ! empty( $instance['saturday_sunday_timing'] ) ) {
			echo '<h6 class="office-hours">Hours  of Operation</h6>';
		}
		echo '<ul>';
		if ( ! empty( $instance['mondaytofriday_textarea'] ) ) {
			echo '<li class="d-flex flex-column mb-2"><span>Monday to Friday</span><span class="fw-300">' . $instance['mondaytofriday_textarea'] . '</span></li>';
		}
        if ( ! empty( $instance['saturday_sunday_timing'] ) ) {
			echo '<li class="d-flex flex-column mb-2"><span>Saturday to Sunday</span><span class="fw-300">' . $instance['saturday_sunday_timing'] . '</span></li>';
		}
        if ( ! empty( $instance['timezone_text'] ) ) {
			echo '<li class="d-flex flex-column mb-2"><span class="fw-300">' . $instance['timezone_text'] . '</span></li></ul>';
		}
        // if ( ! empty( $instance['shop_address'] ) ) {
		// 	echo '<span class="text-white d-flex"><svg class="me-2 mt-1" width="16" height="16" fill="#fff"><use href="#icon-marker"></use></svg><p>' . $instance['shop_address'] . '</p></span></div>';
		// }
		echo $args['after_widget'];
	}

	public function field_generator( $instance ) {
		$output = '';
		foreach ( $this->widget_fields as $widget_field ) {
			$widget_value = ! empty( $instance[ $widget_field['id'] ] ) ? $instance[ $widget_field['id'] ] : esc_html__( $widget_field['default'], 'rv' );
			switch ( $widget_field['type'] ) {
				case 'textarea':
					$output .= '<p>';
					$output .= '<label for="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '">' . esc_attr( $widget_field['label'], 'rv' ) . ':</label> ';
					$output .= '<textarea class="widefat" id="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '" name="' . esc_attr( $this->get_field_name( $widget_field['id'] ) ) . '" rows="6" cols="6" value="' . esc_attr( $widget_value ) . '">' . $widget_value . '</textarea>';
					$output .= '</p>';
					break;
				default:
					$output .= '<p>';
					$output .= '<label for="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '">' . esc_attr( $widget_field['label'], 'rv' ) . ':</label> ';
					$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '" name="' . esc_attr( $this->get_field_name( $widget_field['id'] ) ) . '" type="' . $widget_field['type'] . '" value="' . esc_attr( $widget_value ) . '">';
					$output .= '</p>';
			}
		}
		echo $output;
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'rv' );
		?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'rv' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>">
        </p>
		<?php
		$this->field_generator( $instance );
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				default:
					$instance[ $widget_field['id'] ] = ( ! empty( $new_instance[ $widget_field['id'] ] ) ) ? strip_tags( $new_instance[ $widget_field['id'] ] ) : '';
			}
		}

		return $instance;
	}

}