<?php
/**
 * Theme functions and definitions
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! isset( $content_width ) ) {
	$content_width = 800; // pixels
}

/*
 * Set up theme support
 */
if ( ! function_exists( 'hf_superhero_pets_2019_setup' ) ) {
	function hf_superhero_pets_2019_setup() {
		if ( apply_filters( 'hf_superhero_pets_2019_load_textdomain', true ) ) {
			load_theme_textdomain( 'hf-superhero-pets-2019', get_template_directory() . '/languages' );
		}

		if ( apply_filters( 'hf_superhero_pets_2019_register_menus', true ) ) {
			register_nav_menus( array( 'menu-1' => __( 'Primary', 'hf-superhero-pets-2019' ) ) );
		}

		if ( apply_filters( 'hf_superhero_pets_2019_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'custom-logo' );
			add_theme_support( 'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			) );
			add_theme_support( 'custom-logo', array(
				'height' => 100,
				'width' => 350,
				'flex-height' => true,
				'flex-width' => true,
			) );

			/*
			 * Editor Style
			 */
			add_editor_style( 'editor-style.css' );

			/*
			 * WooCommerce
			 */
			if ( apply_filters( 'hf_superhero_pets_2019_add_woocommerce_support', true ) ) {
				// WooCommerce in general:
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0):
				// zoom:
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox:
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe:
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hf_superhero_pets_2019_setup' );

/*
 * Theme Scripts & Styles
 */
if ( ! function_exists( 'hf_superhero_pets_2019_scripts_styles' ) ) {
	function hf_superhero_pets_2019_scripts_styles() {
		if ( apply_filters( 'hf_superhero_pets_2019_enqueue_style', true ) ) {
			wp_enqueue_style( 'hf-superhero-pets-2019-style', get_stylesheet_uri() );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hf_superhero_pets_2019_scripts_styles' );

/*
 * Admin Styles - To Apply Custom CSS in Elementor Editor
 */
/*
if ( ! function_exists( 'hf_superhero_pets_2019_admin_styles' ) ) {
	function hf_superhero_pets_2019_admin_styles() {
		if ( apply_filters( 'hf_superhero_pets_2019_enqueue_style', true ) ) {

			wp_register_style( 'hf_superhero_pets_2019_admin_css', get_template_directory_uri() . '/admin.css', false, '1.0.0' );
            wp_enqueue_style( 'hf_superhero_pets_2019_admin_css' );

			//wp_register_style( 'hf_superhero_pets_2019_elementor_display_admin_css', get_template_directory_uri() . '/style.css', false, '1.0.0' );
            //wp_enqueue_style( 'hf_superhero_pets_2019_elementor_display_admin_css' );
		}
	}
}
add_action( 'admin_enqueue_scripts', 'hf_superhero_pets_2019_admin_styles' );
*/

/*
 * Register Elementor Locations
 */
if ( ! function_exists( 'hf_superhero_pets_2019_register_elementor_locations' ) ) {
	function hf_superhero_pets_2019_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hf_superhero_pets_2019_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hf_superhero_pets_2019_register_elementor_locations' );


/**
 * Register Additional Menu Locations
 */
function register_relics_2019_menu_locations() {

    register_nav_menus(
        array(
            'website-footer' => __( 'Website Footer' )
        )
    );
}
add_action( 'init', 'register_relics_2019_menu_locations' );

/*
 * Breadcrumbs Custom Delimiter
 */
/*
add_filter( 'woocommerce_breadcrumb_defaults', 'pwd_tf_breadcrumb_delimiter' );
function pwd_tf_breadcrumb_delimiter( $defaults ) {
    $defaults['delimiter'] = '&nbsp; <span class="breadcrumb-delimiter fa fa-caret-right"></span> &nbsp;';
    return $defaults;
}
/*

/*
 * Sidebars
 */
function hf_superhero_pets_2019_widgets_init() {

    /*
    register_sidebar( array(
        'name'          => __( 'Secondary Sidebar', 'theme_name' ),
        'id'            => 'sidebar-2',
        'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li></ul>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    */
}
add_action( 'widgets_init', 'hf_superhero_pets_2019_widgets_init' );

/**
 * Custom Shortcodes
 */
function pwd_get_current_year_shortcode() {
    return date('Y');
}
add_shortcode('pwd_get_year', 'pwd_get_current_year_shortcode');


// Remove CSS and/or JS for Select2 used by WooCommerce, see https://gist.github.com/Willem-Siebe/c6d798ccba249d5bf080.
add_action( 'wp_enqueue_scripts', 'wsis_dequeue_stylesandscripts_select2', 100 );
function wsis_dequeue_stylesandscripts_select2() {
    if ( class_exists( 'woocommerce' ) ) {

        // Disabled these parts, due to somehow also removes Jquery UI Datepicker
        //wp_dequeue_style( 'select2' );
        //wp_deregister_style( 'select2' );

        //wp_dequeue_script( 'select2' );
        //wp_deregister_script( 'select2' );

        wp_dequeue_style( 'selectWoo' );
        wp_deregister_style( 'selectWoo' );

        wp_dequeue_script( 'selectWoo' );
        wp_deregister_script( 'selectWoo' );
    }
}


// Disable woocommerce order notes in checkout
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

/*
// Validate confirmation email on contact page contact form
add_action( 'elementor_pro/forms/validation', function ( $record, $ajax_handler ) {

	//make sure its our form
	$form_name = $record->get_form_settings( 'form_name' );

	// Replace MY_FORM_NAME with the name you gave your form
	if ( 'Contact Page Contact Form' !== $form_name ) {
		return;
	}

	$first_email_field = $record->get_field( [
		'id' => 'email',
	] );

	$second_email_field = $record->get_field( [
		'id' => 'email_confirmation',
	] );

	if ( $first_email_field['value'] !== $second_email_field['value'] ) {
		$ajax_handler->add_error( $second_email_field['id'], 'Confirmation Email must match the Email field' );
	}
}, 10, 2 );
*/

/*
 * Edit WooCommerce 'Processing order' Email Subject if a Gift order
 *   woocommerce_email_subject_customer_processing_order
 *   woocommerce_email_subject_customer_completed_order
 *   woocommerce_email_subject_customer_invoice
 */
 add_filter('woocommerce_email_subject_customer_on_hold_order', 'hfpsp_change_wc_processing_email_subject', 1, 2);
 add_filter('woocommerce_email_subject_customer_processing_order', 'hfpsp_change_wc_processing_email_subject', 1, 2);
 add_filter('woocommerce_email_subject_customer_completed_order', 'hfpsp_change_wc_processing_email_subject', 1, 2);
 add_filter('woocommerce_email_subject_customer_invoice_paid', 'hfpsp_change_wc_processing_email_subject', 1, 2);
 add_filter('woocommerce_email_subject_customer_invoice', 'hfpsp_change_wc_processing_email_subject', 1, 2);
function hfpsp_change_wc_processing_email_subject( $subject, $order ) {
	global $woocommerce;

    // check if order is a gift order
    $order_contains_gifts = HFPSP_WC_Gifts::order_contains_gifts($order);
    if( $order_contains_gifts ) {

        // Edit order subject
    	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    	$subject = sprintf( 'Your Gift Order %s From %s', $order->get_order_number(), $blogname );
    }

	return $subject;
}
