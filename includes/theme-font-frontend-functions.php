<?php 
/**
 * Theme Font Frontend Functions
 *
 * This file is responsible for retrieving all of
 * the options and outputting any appropriate styles
 * for the theme.
 * 
 * @package 	WordPress
 * @subpackage  WordPress_Google_Fonts
 * @author 		Sunny Johal - Titanium Themes
 * @copyright 	Copyright (c) 2013, Titanium Themes
 * @version 	1.0
 * 
 */

/**
 * Enqueue Font Stylesheets
 *
 * @link http://codex.wordpress.org/Function_Reference/add_action 	add_action()
 *
 * @uses tt_font_get_options()				defined in \includes\theme-font-options.php
 * @uses tt_font_get_option_parameters()	defined in \includes\theme-font-options.php
 * 
 * @since 1.0
 * @version 1.1.1
 * 
 */
function tt_font_enqueue_stylesheets() {

	global $wp_customize;

	$transient = isset( $wp_customize ) ? false : true;
	$options   = tt_font_get_options( $transient );

	foreach ( $options as $option ) {

		if ( ! empty( $option['stylesheet_url'] ) ) {

			$handle = "{$option['font_id']}-{$option['font_weight_style']}";

			// Load theme dependant third party plugins
			wp_deregister_style( $handle );
			wp_register_style( $handle, $option['stylesheet_url'] );
			wp_enqueue_style( $handle );

		}
	}
}
add_action( 'wp_enqueue_scripts', 'tt_font_enqueue_stylesheets' );

/**
 * Output Inline Styles in Head
 *
 * Hooks into the 'wp_head' action and outputs specific
 * inline styles relevant to each font option.
 *
 * @link http://codex.wordpress.org/Function_Reference/add_action 	add_action()
 *
 * @uses tt_font_get_options()				defined in \includes\theme-font-options.php
 * @uses tt_font_get_option_parameters()	defined in \includes\theme-font-options.php
 * @uses tt_font_generate_css()				defined in \includes\theme-font-frontend-functions.php
 *
 * @since 1.0
 * @version 1.1.1
 * 
 */
function tt_font_output_styles() {
	
	global $wp_customize;

	$transient       = isset( $wp_customize ) ? false : true;
	$options         = tt_font_get_options( $transient );
	$default_options = tt_font_get_option_parameters();
	?>
	<?php foreach ( $options as $key => $value ) : ?>
		<?php
			$force_styles = isset( $default_options[ $key ]['properties']['force_styles'] ) ? $default_options[ $key ]['properties']['force_styles'] : false;
		?>
		<?php if ( isset( $wp_customize ) ) : ?>
			<?php echo tt_font_generate_customizer_css( $options[ $key ], $default_options[ $key ]['properties']['selector'], $key, $force_styles ); ?>
		<?php else : ?>
			<style id="tt-<?php echo $key; ?>-font-styles" type="text/css">
				<?php if ( ! empty( $default_options[ $key ] ) ): ?>
					<?php echo $default_options[ $key ]['properties']['selector']; ?> {
						<?php echo tt_font_generate_css( $options[ $key ], $force_styles ); ?>
					}
				<?php endif; ?>
			</style>			
		<?php endif; ?>
	<?php endforeach; ?>	
	<?php
}
add_action( 'wp_head', 'tt_font_output_styles' );

/**
 * Generate Inline Font CSS
 *
 * Takes a font option array as a parameter and
 * return a string of inline styles.
 * 
 * @param  array $option 	Font option array
 * @return string $output 	Inline styles
 *
 * @since 1.0
 * @version 1.1.1
 * 
 */
function tt_font_generate_css( $option, $force_styles = false ) {
	$output     = '';
	$importance = $force_styles ? '!important' : ''; 

	// Font Family
	if ( ! empty( $option['font_name'] ) ) {
		$output .= "font-family: {$option['font_name']}{$importance}; ";
	}

	// Background Color
	if ( ! empty( $option['background_color'] ) ) {
		$output .= "background-color: {$option['background_color']}{$importance}; ";
	}

	// Color
	if ( ! empty( $option['font_color'] ) ) {
		$output .= "color: {$option['font_color']}{$importance}; ";
	}

	// Font Weight
	if ( ! empty( $option['font_weight'] ) ) {
		$output .= "font-weight: {$option['font_weight']}{$importance}; ";
	}

	// Font Style
	if ( ! empty( $option['font_style'] ) ) {
		$output .= "font-style: {$option['font_style']}{$importance}; ";
	}

	// Text Decoration
	if ( ! empty( $option['text_decoration'] ) ) {
		$output .= "text-decoration: {$option['text_decoration']}{$importance}; ";
	}

	// Line Height
	if ( ! empty( $option['line_height'] ) ) {
		$output .= "line-height: {$option['line_height']}{$importance}; ";
	}

	// Font Size
	if ( ! empty( $option['font_size']['amount'] ) ) {
		$output .= "font-size: {$option['font_size']['amount']}{$option['font_size']['unit']}{$importance}; ";
	}

	// Letter Spacing
	if ( ! empty( $option['letter_spacing']['amount'] ) ) {
		$output .= "letter-spacing: {$option['letter_spacing']['amount']}{$option['letter_spacing']['unit']}{$importance}; ";
	}

	// Margin Top
	if ( ! empty( $option['margin_top']['amount'] ) ) {
		$output .= "margin-top: {$option['margin_top']['amount']}{$option['margin_top']['unit']}{$importance}; ";
	}

	// Margin Right
	if ( ! empty( $option['margin_right']['amount'] ) ) {
		$output .= "margin-right: {$option['margin_right']['amount']}{$option['margin_right']['unit']}{$importance}; ";
	}

	// Margin Bottom
	if ( ! empty( $option['margin_bottom']['amount'] ) ) {
		$output .= "margin-bottom: {$option['margin_bottom']['amount']}{$option['margin_bottom']['unit']}{$importance}; ";
	}	

	// Margin Left
	if ( ! empty( $option['margin_left']['amount'] ) ) {
		$output .= "margin-left: {$option['margin_left']['amount']}{$option['margin_left']['unit']}{$importance}; ";
	}	

	// Padding Top
	if ( ! empty( $option['padding_top']['amount'] ) ) {
		$output .= "padding-top: {$option['padding_top']['amount']}{$option['padding_top']['unit']}{$importance}; ";
	}

	// Padding Right
	if ( ! empty( $option['padding_right']['amount'] ) ) {
		$output .= "padding-right: {$option['padding_right']['amount']}{$option['padding_right']['unit']}{$importance}; ";
	}

	// Padding Bottom
	if ( ! empty( $option['padding_bottom']['amount'] ) ) {
		$output .= "padding-bottom: {$option['padding_bottom']['amount']}{$option['padding_bottom']['unit']}{$importance}; ";
	}	

	// Padding Left
	if ( ! empty( $option['padding_left']['amount'] ) ) {
		$output .= "padding-left: {$option['padding_left']['amount']}{$option['padding_left']['unit']}{$importance}; ";
	}

	return $output;
}

/**
 * Generate Customizer Preview Inline Font CSS
 *
 * Outputs compatible <style> tags that are necessary in
 * order to facilitate the live preview. By outputting the
 * styles in their own <style> tag we are able to use the
 * font-customizer-preview.js to revert back to theme 
 * defaults without refreshing the page.
 * 
 * @param  array $option 	Font option array
 * @return string $output 	Inline styles
 *
 * @since 1.0
 * @version 1.1.1
 * 
 */
function tt_font_generate_customizer_css( $option, $selector, $id = '', $force_styles = false ) {
	$output     = '';
	$importance = $force_styles ? '!important' : '';

	// Font Family
	if ( ! empty( $option['font_name'] ) ) {
		$output .= "<style id='tt-font-{$id}-font-family' type='text/css'>{$selector}{";
		$output .= "font-family: {$option['font_name']}{$importance}; ";
		$output .= "}</style>";
	}

	// Background Color
	if ( ! empty( $option['background_color'] ) ) {
		$output .= "<style id='tt-font-{$id}-background-color' type='text/css'>{$selector}{";
		$output .= "background-color: {$option['background_color']}{$importance}; ";
		$output .= "}</style>";
	}

	// Color
	if ( ! empty( $option['font_color'] ) ) {
		$output .= "<style id='tt-font-{$id}-color' type='text/css'>{$selector}{";
		$output .= "color: {$option['font_color']}{$importance}; ";
		$output .= "}</style>";
	}

	// Font Weight
	if ( ! empty( $option['font_weight'] ) ) {
		$output .= "<style id='tt-font-{$id}-font-weight' type='text/css'>{$selector}{";
		$output .= "font-weight: {$option['font_weight']}{$importance}; ";
		$output .= "}</style>";
	}

	// Font Style
	if ( ! empty( $option['font_style'] ) ) {
		$output .= "<style id='tt-font-{$id}-font-style' type='text/css'>{$selector}{";
		$output .= "font-style: {$option['font_style']}{$importance}; ";
		$output .= "}</style>";
	}

	// Text Decoration
	if ( ! empty( $option['text_decoration'] ) ) {
		$output .= "<style id='tt-font-{$id}-text-decoration' type='text/css'>{$selector}{";
		$output .= "text-decoration: {$option['text_decoration']}{$importance}; ";
		$output .= "}</style>";
	}

	// Line Height
	if ( ! empty( $option['line_height'] ) ) {
		$output .= "<style id='tt-font-{$id}-line-height' type='text/css'>{$selector}{";
		$output .= "line-height: {$option['line_height']}{$importance}; ";
		$output .= "}</style>";
	}

	// Font Size
	if ( ! empty( $option['font_size']['amount'] ) ) {
		$output .= "<style id='tt-font-{$id}-font-size' type='text/css'>{$selector}{";
		$output .= "font-size: {$option['font_size']['amount']}{$option['font_size']['unit']}{$importance}; ";
		$output .= "}</style>";
	}

	// Letter Spacing
	if ( ! empty( $option['letter_spacing']['amount'] ) ) {
		$output .= "<style id='tt-font-{$id}-letter-spacing' type='text/css'>{$selector}{";
		$output .= "letter-spacing: {$option['letter_spacing']['amount']}{$option['letter_spacing']['unit']}{$importance}; ";
		$output .= "}</style>";
	}

	// Margin Top
	if ( ! empty( $option['margin_top']['amount'] ) ) {
		$output .= "<style id='tt-font-{$id}-margin-top' type='text/css'>{$selector}{";
		$output .= "margin-top: {$option['margin_top']['amount']}{$option['margin_top']['unit']}{$importance}; ";
		$output .= "}</style>";
	}

	// Margin Right
	if ( ! empty( $option['margin_right']['amount'] ) ) {
		$output .= "<style id='tt-font-{$id}-margin-right' type='text/css'>{$selector}{";
		$output .= "margin-right: {$option['margin_right']['amount']}{$option['margin_right']['unit']}{$importance}; ";
		$output .= "}</style>";
	}

	// Margin Bottom
	if ( ! empty( $option['margin_bottom']['amount'] ) ) {
		$output .= "<style id='tt-font-{$id}-margin-bottom' type='text/css'>{$selector}{";
		$output .= "margin-bottom: {$option['margin_bottom']['amount']}{$option['margin_bottom']['unit']}{$importance}; ";
		$output .= "}</style>";
	}

	// Margin Left
	if ( ! empty( $option['margin_left']['amount'] ) ) {
		$output .= "<style id='tt-font-{$id}-margin-left' type='text/css'>{$selector}{";
		$output .= "margin-left: {$option['margin_left']['amount']}{$option['margin_left']['unit']}{$importance}; ";
		$output .= "}</style>";
	}

	// Padding Top
	if ( ! empty( $option['padding_top']['amount'] ) ) {
		$output .= "<style id='tt-font-{$id}-padding-top' type='text/css'>{$selector}{";
		$output .= "padding-top: {$option['padding_top']['amount']}{$option['padding_top']['unit']}{$importance}; ";
		$output .= "}</style>";
	}

	// Padding Right
	if ( ! empty( $option['padding_right']['amount'] ) ) {
		$output .= "<style id='tt-font-{$id}-padding-right' type='text/css'>{$selector}{";
		$output .= "padding-right: {$option['padding_right']['amount']}{$option['padding_right']['unit']}{$importance}; ";
		$output .= "}</style>";
	}

	// Padding Bottom
	if ( ! empty( $option['padding_bottom']['amount'] ) ) {
		$output .= "<style id='tt-font-{$id}-padding-bottom' type='text/css'>{$selector}{";
		$output .= "padding-bottom: {$option['padding_bottom']['amount']}{$option['padding_bottom']['unit']}{$importance}; ";
		$output .= "}</style>";
	}

	// Padding Left
	if ( ! empty( $option['padding_left']['amount'] ) ) {
		$output .= "<style id='tt-font-{$id}-padding-left' type='text/css'>{$selector}{";
		$output .= "padding-left: {$option['padding_left']['amount']}{$option['padding_left']['unit']}{$importance}; ";
		$output .= "}</style>";
	}

	return $output;
}