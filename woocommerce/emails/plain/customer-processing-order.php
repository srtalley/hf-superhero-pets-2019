<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/plain/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails/Plain
 * @version 3.7.0
 */

 defined( 'ABSPATH' ) || exit;

 /* GIFT ORDER - BEGIN */
 $order_contains_gifts = HFPSP_WC_Gifts::order_contains_gifts( $order );
 if( $order_contains_gifts ) {
     // Override heading
     $email_heading = 'Thank you for your gift order';
 }
 /* GIFT ORDER - END */

 echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
 echo esc_html( wp_strip_all_tags( $email_heading ) );
 echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

/* translators: %s: Customer first name */
echo sprintf( esc_html__( 'Dear %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ) . "\n\n";

if( $order_contains_gifts ) {
    echo 'Congratulations. We have received your gift order ' . esc_html( $order->get_order_number() ) . ', and it is now being processed.' . "\n\n";
} else {
    echo 'We are so grateful to have you join us here at Superhero Pets. We are currently processing your enrollment. Once processed, your contribution will immediately go to work saving the lives of animals internationally.' . "\n\n";
}

/* translators: %s: Order number */
echo esc_html__( 'Your order details are below.', 'woocommerce' ) . "\n\n";

echo "\n----------------------------------------\n\n";

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

echo "\n----------------------------------------\n\n";

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

echo "\n----------------------------------------\n\n";

/**
 * Show user-defined additonal content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo esc_html( wp_strip_all_tags( wptexturize( $additional_content ) ) );
	echo "\n\n----------------------------------------\n\n";
}

echo esc_html__( 'The Superhero Pets Team', 'woocommerce' ) . "\n\n";

echo "\n----------------------------------------\n\n";

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
