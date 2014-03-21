<?php

/**
 * Theme Options Class
 *
 * Creates the options from supplied arrays
 *
 * Requires a sections array and an options array
 *
 *
 * @file           Responsive_Options.php
 * @package        Responsive
 * @author         CyberChimps
 * @copyright      CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @since          available since Release 1.9.5
 */
Class Responsive_Options {

	public $sections;

	public $options_sections;

	public $options;

	public static $options_defaults;

	public static $responsive_options;

	protected $default_options;

	/**
	 * Pulls in the arrays for the options and sets up the responsive options
	 *
	 * @param $sections array
	 * @param $options array
	 */
	public function __construct( $sections, $options ) {
		$this->sections           = $sections;
		$this->options_sections   = $options;
		$this->options            = $this->get_options_only( $this->options_sections );
		self::$options_defaults   = $this->get_options_defaults( $this->options );
		self::$responsive_options = get_option( 'responsive_theme_options' );

		// Set confirmaton text for restore default option as attributes of submit_button().
		$this->attributes['onclick'] = 'return confirm("' . __( 'Do you want to restore? \nAll theme settings will be lost! \nClick OK to Restore.', 'responsive' ) . '")';
		add_action( 'admin_print_styles-appearance_page_theme_options', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'admin_init', array( $this, 'theme_options_init' ) );
		add_action( 'admin_menu', array( $this, 'theme_page_init' ) );
	}

	/**
	 * Init theme options page
	 */
	public function theme_page_init() {
		// Register the page
		add_theme_page(
			__( 'Theme Options', 'responsive' ),
			__( 'Theme Options', 'responsive' ),
			'edit_theme_options',
			'theme_options',
			array( $this, 'theme_options_do_page' )
		);
	}

	/**
	 * Init theme options to white list our options
	 */
	public function theme_options_init() {

		register_setting(
			'responsive_options',
			'responsive_theme_options',
			array( &$this, 'theme_options_validate' )
		);
	}

	/**
	 * A safe way of adding JavaScripts to a WordPress generated page.
	 */
	public function admin_enqueue_scripts() {
		$template_directory_uri = get_template_directory_uri();

		wp_enqueue_style( 'responsive-theme-options', $template_directory_uri . '/core/includes/theme-options/theme-options.css', false, '1.0' );
		wp_enqueue_script( 'responsive-theme-options', $template_directory_uri . '/core/includes/theme-options/theme-options.js', array( 'jquery' ), '1.0' );
	}

	/**
	 * Create the theme options page container and initialise the render display method
	 */
	public function theme_options_do_page() {

		if ( !isset( $_REQUEST['settings-updated'] ) ) {
			$_REQUEST['settings-updated'] = false;
		}

		// Set confirmaton text for restore default option as attributes of submit_button().
		$attributes['onclick'] = 'return confirm("' . __( 'Do you want to restore? \nAll theme settings will be lost! \nClick OK to Restore.', 'responsive' ) . '")';
		?>

		<div class="wrap">
			<?php
			/**
			 * < 3.4 Backward Compatibility
			 */
			?>
			<?php $theme_name = function_exists( 'wp_get_theme' ) ? wp_get_theme() : get_current_theme(); ?>
			<?php screen_icon();
			echo "<h2>" . $theme_name . " " . __( 'Theme Options', 'responsive' ) . "</h2>"; ?>


			<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
				<div class="updated fade"><p><strong><?php _e( 'Options Saved', 'responsive' ); ?></strong></p></div>
			<?php endif; ?>

			<?php responsive_theme_options(); // Theme Options Hook ?>

			<form method="post" action="options.php">
				<?php settings_fields( 'responsive_options' ); ?>

				<div id="rwd" class="grid col-940">
					<?php
					$this->render_display();
					?>
				</div>
				<!-- .grid col-940 -->
			</form>
		</div><!-- wrap -->
	<?php
	}

	/**
	 * Displays the options
	 *
	 * Loops through sections array
	 *
	 * @return string
	 */
	public function render_display() {
		foreach ( $this->sections as $section ) {
			$sub = $this->options_sections[$section['id']];
			$this->container( $section['title'], $sub );
		}
	}

	/**
	 * Creates main sections title and container
	 *
	 * Loops through the sections array
	 *
	 * @param $title string
	 * @param $sub array
	 *
	 * @return string
	 */
	protected function container( $title, $sub ) {

		foreach ( $sub as $opt ) {
			$section[] = $this->section( $this->parse_args( $opt ) );
		}

		$html = '<h3 class="rwd-toggle">' . esc_html( $title ) . '<a href="#"></a></h3><div class="rwd-container"><div class="rwd-block">';

		foreach ( $section as $option ) {
			$html .= $option;
		}

		$html .= $this->save();
		$html .= '</div><!-- rwd-block --></div><!-- rwd-container -->';

		echo $html;

	}

	/**
	 * Creates the title section for each option input
	 *
	 * @param $title string
	 * @param $subtitle string
	 *
	 * @return string
	 */
	protected function sub_heading( $title, $sub_title ) {

		// If width is not set or it's not set to full then go ahead and create default layout
		if ( !isset( $args['width'] ) || $args['width'] != 'full' ) {
			$html = '<div class="grid col-300">';

			$html .= $title;

			$html .= $sub_title;

			$html .= '</div><!-- .grid col-300 -->';

			return $html;

		}
	}

	/**
	 * Creates option section with inputs
	 *
	 * Calls option type
	 *
	 * @param $options array
	 *
	 * @return string
	 */
	protected function section( $options ) {

		$html = $this->sub_heading( $options['title'], $options['subtitle'] );

		// If the width is not set to full then create normal grid size, otherwise create full width
		$html .= ( !isset( $options['width'] ) || $options['width'] != 'full' ) ? '<div class="grid col-620 fit">' : '<div class="grid col-940">';

		$html .= $this->$options['type']( $options );

		$html .= '</div>';

		return $html;

	}

	/**
	 * Creates text input
	 *
	 * @param $args array
	 *
	 * @return string
	 */
	protected function text( $args ) {

		extract( $args );

		$value = ( !empty( self::$responsive_options[$id] ) ) ? self::$responsive_options[$id] : '';

		$html = '<input id="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '" class="regular-text" type="text" name="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '" value="' . esc_html( $value ) . '" placeholder="' . esc_attr( $placeholder ) . '" /><label class="description" for="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '">' . esc_html( $description ) . '</label>';

		return $html;
	}

	/**
	 * Creates textarea input
	 *
	 * @param $args array
	 *
	 * @return string
	 */
	protected function textarea( $args ) {

		extract( $args );

		$class[] = 'large-text';
		$classes = implode( ' ', $class );

		$value = ( !empty( self::$responsive_options[$id] ) ) ? self::$responsive_options[$id] : '';

		$html = '<p>' . esc_html( $heading ) . '</p><textarea id="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '" class="' . esc_attr( $classes ) . '" cols="50" rows="30" name="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '" placeholder="' . $placeholder . '">' . esc_html( $value ) . '</textarea><label class="description" for="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '">' . esc_html( $description ) . '</label>';

		return $html;
	}

	/**
	 * Creates select dropdown input
	 *
	 * Loops through options
	 *
	 * @param $args array
	 *
	 * @return string
	 */
	protected function select( $args ) {

		extract( $args );

		$html = '<select id="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '" name="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '">';
		foreach ( $options as $key => $value ) {
			// looping through and creating all the options and making the one saved in the options as the chosen one otherwise falling back to the default
			$html .= '<option' . selected( ( isset( self::$responsive_options[$id] ) ) ? self::$responsive_options[$id] : $default, $key, false ) . ' value="' . esc_attr( $key ) . '">' . esc_html(
					$value
				) .
				'</option>';
		}
		$html .= '</select>';

		return $html;

	}

	/**
	 * Creates checkbox input
	 *
	 * @param $args array
	 *
	 * @return string
	 */
	protected function checkbox( $args ) {

		extract( $args );

		$checked = ( isset( self::$responsive_options[$id] ) ) ? checked( 1, esc_attr( self::$responsive_options[$id] ), false ) : checked( 0, 1 );

		$html = '<input id="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '" name="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '" type="checkbox" value="1" ' . $checked . '/><label class="description" for="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '">' . wp_kses_post( $description ) . '</label>';

		return $html;
	}

	/**
	 * Creates a description
	 *
	 * @param $args
	 *
	 * @return string
	 */
	protected function description( $args ) {

		extract( $args );

		$html = '<p>' . wp_kses_post( $description ) . '</p>';

		return $html;
	}

	/**
	 * Creates save, reset and upgrade buttons
	 *
	 * @return string
	 */
	protected function save() {
		$html = '<div class="grid col-940"><p class="submit">' . get_submit_button( __( 'Save Options', 'responsive' ), 'primary', 'responsive_theme_options[submit]', false ) . get_submit_button( __( 'Restore Defaults', 'responsive' ), 'secondary', 'responsive_theme_options[reset]', false, $this->attributes ) . ' <a href="http://cyberchimps.com/store/responsivepro/" class="button upgrade">' . __( 'Upgrade', 'responsive' ) . '</a></p></div>';

		return $html;

	}

	/**
	 * Get Default layouts from theme-options.php
	 *
	 * @return array
	 */
	public static function valid_layouts() {

		$default = do_action( 'responsive_get_default_layouts' );

		if ( !isset( $default ) ) {
			$default = array();
		}

		return $default;
	}

	/**
	 * Creates editor input
	 *
	 * @param $args array
	 *
	 * @return string
	 */
	protected function editor( $args ) {

		extract( $args );

		$class[] = 'large-text';
		$classes = implode( ' ', $class );

		$value = ( !empty( self::$responsive_options[$id] ) ) ? self::$responsive_options[$id] : '';

		$editor_settings = array(
			'textarea_name' => 'responsive_theme_options[' . $id . ']',
			'media_buttons' => true,
			'tinymce'       => array( 'plugins' => 'wordpress' ),
			'editor_class'  => esc_attr( $classes )
		);

		$html = '<div class="tinymce-editor">';
		ob_start();
		$html .= wp_editor( $value, 'responsive_theme_options[' . $id . ']', $editor_settings );
		$html .= ob_get_contents();
		$html .= '<label class="description" for="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '">' . esc_html( $description ) . '</label>';
		$html .= '</div>';
		ob_clean();

		return $html;
	}


	/**
	 * VALIDATION SECTION
	 */

	/**
	 * Initialises the validation of the settings when submitted
	 *
	 * Called by the register_settings()
	 *
	 * @param $input
	 *
	 * @return array|mixed|void
	 */
	public function theme_options_validate( $input ) {

		$defaults = $this->default_options;
		if ( isset( $input['reset'] ) ) {

			$input = $defaults;

		}
		else {

			// remove the submit button that gets included in the $input
			unset ( $input['submit'] );

			$options = $this->options;

			$input = $input ? $input : array();
			$input = apply_filters( 'responsive_settings_sanitize', $input );

			// Loop through each setting being saved and pass it through a sanitization filter
			foreach ( $input as $key => $value ) {

				$validate = isset( $options[$key]['validate'] ) ? $options[$key]['validate'] : false;

				if ( $validate ) {
					$input[$key] = $this->{'validate_' . $validate}( $value, $key );
				}
				else {
					// TODO could do with returning error message
//					return;
				}

			}

		}

		return $input;
	}

	/**
	 * Validates checkbox
	 *
	 * checks if the value submitted is a boolean value
	 *
	 * @param $input
	 * @param $key
	 *
	 * @return null
	 */
	// TODO this is working
	protected function validate_checkbox( $input, $key ) {

		if ( 1 != $input || 0 != $input ) {
			$input = null;
		}

		return $input;
	}

	/**
	 * Validates a dropdown select option
	 *
	 * checks that the value is available in the options, if it can't find it then to return the default
	 *
	 * @param $input
	 * @param $key
	 *
	 * @return mixed
	 */
	protected function validate_select( $input, $key ) {

		$options = $this->options[$key];
		$input = ( array_key_exists( $input, $options['options'] ) ? $input : self::$options_defaults[$key] );

		return $input;
	}

	/**
	 * Validates the editor textarea
	 *
	 * @param $input
	 * @param $key
	 *
	 * @return string
	 */
	protected function validate_editor( $input, $key ) {

		$input = wp_kses_stripslashes( $input );

		return $input;
	}

	/**
	 * Validates/sanitizes a url
	 *
	 * @param $input
	 * @param $key
	 *
	 * @return string
	 */
	protected function validate_url( $input, $key ) {

		$input = esc_url_raw( $input );

		return $input;
	}

	/**
	 * Validates/sanitizes a text input
	 *
	 * @param $input
	 * @param $key
	 *
	 * @return string
	 */
	protected function validate_text( $input, $key ) {

		$input = sanitize_text_field( $input );

		return $input;
	}

	/**
	 * Validates the css textarea
	 *
	 * @param $input
	 * @param $key
	 *
	 * @return string
	 */
	public function validate_css( $input, $key ) {

		$input = wp_kses_stripslashes( $input );

		return $input;
	}

	/**
	 * Validates the javascript textarea
	 * @param $input
	 * @param $key
	 *
	 * @return string
	 */
	protected function validate_js( $input, $key ) {

		$input = wp_kses_stripslashes( $input );

		return $input;
	}

	/**
	 * Removes the sections from the options array given in construct
	 * and sets the id as the key
	 *
	 * @param $options
	 */
	protected function get_options_only( $options ) {

		$new_array = array();
		foreach ( $options as $option ) {
			foreach ( $option as $opt ) {
				$new_array[$opt['id']] = $opt;
			}

		}

		return $new_array;

	}

	/**
	 * Gets the defaults as key => value
	 *
	 * @param $options
	 *
	 * @return array
	 */
	protected function get_options_defaults( $options ) {

		$defaults = array();
		foreach ( $options as $option ) {
			$defaults[$option['id']] = $option['default'];
		}

		return $defaults;
	}

	/**
	 * parses the options with the defaults to get a complete array
	 *
	 * @return array
	 */
	public static function get_parse_options() {
		$options = wp_parse_args( self::$responsive_options, self::$options_defaults );

		return $options;
	}

	/**
	 * Makes sure that every option has all the required args
	 *
	 * @param $args array
	 *
	 * @return array
	 */
	protected function parse_args( $args ) {
		$default_args = array(
			'title'       => '',
			'subtitle'    => '',
			'heading'     => '',
			'type'        => 'text',
			'id'          => '',
			'class'       => array(),
			'description' => '',
			'placeholder' => '',
			'options'     => array(),
			'default'     => '',
			'sanitize'    => ''
		);

		$result = array_merge( $default_args, $args );

		return $result;
	}
}