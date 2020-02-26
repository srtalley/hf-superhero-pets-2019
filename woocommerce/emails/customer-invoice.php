<?php
/**
 * Customer invoice email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-invoice.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* GIFT ORDER - BEGIN */
$order_contains_gifts = HFPSP_WC_Gifts::order_contains_gifts( $order );
if( $order_contains_gifts ) {
    // Override heading
    $email_heading = 'Thank you for your gift order';
}
/* GIFT ORDER - END */

/**
 * Executes the e-mail header.
 *
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( esc_html__( 'Dear %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>

<?php if( $order_contains_gifts ) : ?>
    <p><?php printf( 'We are so grateful for your gift order %s at Superhero Pets.', esc_html( $order->get_order_number() ) ); ?> Your contribution goes to work saving the lives of animals internationally.</p>
<?php else: ?>
    <p>We are so grateful to have you join us here at Superhero Pets. Your contribution will immediately go to work saving the lives of animals internationally.</p>

    <p>If you have not yet done so, simply <strong><a href="<?php echo site_url( '/my-account/' ); ?>">login to our website</a></strong> to create your pet’s superhero profile page where you can share photos and some special details about your amazing pet. Together, you will be making a tremendous difference in the lives of animals in need.</p>
<?php endif; ?>

<?php if ( $order->has_status( 'pending' ) ) { ?>
	<p>
	<?php
	printf(
		wp_kses(
			/* translators: %1$s Site title, %2$s Order pay link */
			__( 'Your invoice is below, with a link to make payment when you’re ready: %2$s', 'woocommerce' ),
			array(
				'a' => array(
					'href' => array(),
				),
			)
		),
		'<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay for this order', 'woocommerce' ) . '</a>.'
	);
	?>
    <span>And if you’d like to stay posted on our work, you may enjoy <a href="https://www.facebook.com/The-Pet-Memorial-276741059544132/">following us on Facebook</a>.</span>
	</p>

<?php } else { ?>
	<p><?php echo esc_html__( 'Your order details are below.', 'woocommerce' ); ?> <span>And if you’d like to <strong>stay posted on the incredible rescues sponsored by your little superhero</strong>, <a href="https://www.facebook.com/Superhero-Pets-557556648090344/">follow us on <strong>Facebook</strong></a>.</span></p>
<?php
}

/**
 * Hook for the woocommerce_email_order_details.
 *
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Hook for the woocommerce_email_order_meta.
 *
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
 * Hook for woocommerce_email_customer_details.
 *
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additonal content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

?>
<p>
<?php esc_html_e( 'The Superhero Pets Team', 'woocommerce' ); ?>
</p>
<?php

/**
 * Executes the email footer.
 *
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
