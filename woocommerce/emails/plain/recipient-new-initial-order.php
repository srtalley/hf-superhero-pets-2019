<?php
/**
 * Recipient customer new account email
 *
 * @author James Allan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
echo '= ' . $email_heading . " =\n\n";
echo sprintf( __( 'Hello,', 'woocommerce-subscriptions-gifting' ) ) . "\n";

echo 'We are delighted to tell you that your pet is about to become a Superhero Pet. This is a special gift just for you from ' . wp_kses( $subscription_purchaser, wp_kses_allowed_html( 'user_description' ) ) . '.' . "\n\n";

echo '---------------------------------------------' . "\n\n";

<?php /* // Message field not available for gifted subscriptions
echo 'Message:' . "\n";
*/ ?>

echo '---------------------------------------------' . "\n\n";

echo '= About Our Superheroes =' . "\n";
echo 'Our league of Superhero Pets are ordinary pets who are doing the extraordinary. This assembly of cats, dogs, rabbits, horses, turtles and others are joining forces to help underdog animal rescue squads across the planet. Together, our superheroes are providing food, shelter, veterinary medicine and protection-from-cruelty to thousands of needy animals. We can’t wait to welcome your pet to the team.' . "\n\n";

echo '---------------------------------------------' . "\n\n";

echo '= It\'s Simple. Here\'s how to Get Started =' . "\n\n";
echo 'You may add your pet to our League of Superhero Pets by uploading favorite photos and a few words about your hero pet.' . "\n\n";

$new_recipient = get_user_meta( $recipient_user->ID, 'wcsg_update_account', true );

if ( 'true' == $new_recipient ) {
	echo esc_html__( 'We noticed you didn\'t have an account so we created one for you. Your account login details will have been sent to you in a separate email.', 'woocommerce-subscriptions-gifting' ) . "\n\n";
} else {
	echo sprintf( __( 'You may access your account area to view your new %1$s here: %2$s.', 'woocommerce-subscriptions-gifting' ), _n( 'subscription', 'subscriptions', count( $subscriptions ), 'woocommerce-subscriptions-gifting' ), untrailingslashit( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) . '/pet-profiles/?gift_create=1' ) . "\n\n";
}

echo '---------------------------------------------' . "\n\n";

echo __( ' Details of the membership are shown below.', 'woocommerce-subscriptions-gifting' ) . "\n\n";

foreach ( $subscriptions as $subscription_id ) {
	$subscription = wcs_get_subscription( $subscription_id );

	do_action( 'wcs_gifting_email_order_details', $subscription, $sent_to_admin, $plain_text, $email );

	if ( is_callable( array( 'WC_Subscriptions_Email', 'order_download_details' ) ) ) {
		WC_Subscriptions_Email::order_download_details( $subscription, $sent_to_admin, $plain_text, $email );
	}
}

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
