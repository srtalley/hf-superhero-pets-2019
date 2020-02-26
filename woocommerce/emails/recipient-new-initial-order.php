<?php
/**
 * Recipient new subscription(s) notification email
 *
 * @author James Allan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<img src="<?php echo get_template_directory_uri() . '/assets/images/gift-boxes-row-email-700.png'; ?>" alt="Gift boxes" style="max-width:100%; margin-bottom: 40px;">

<p><?php printf( esc_html__( 'Hello,', 'woocommerce-subscriptions-gifting' ) ); ?></p>

<p>We are delighted to tell you that your pet is about to become a Superhero Pet. This is a special gift just for you from <?php echo wp_kses( $subscription_purchaser, wp_kses_allowed_html( 'user_description' ) ); ?>.</p>

<?php /*
<p><strong>Message:</strong> <?php // Message field not available for gifted subscriptions ?></p>
*/ ?>

<h2>About Our Superheroes...</h2>
<p>Our league of Superhero Pets are ordinary pets who are doing the extraordinary. This assembly of cats, dogs, rabbits, horses, turtles and others are joining forces to help underdog animal rescue squads  across the planet. Together, our superheroes are providing food, shelter, veterinary medicine and protection-from-cruelty to thousands of needy animals. We can’t wait to welcome your pet to the team.</p>

<img src="<?php echo get_template_directory_uri() . '/assets/images/superhero-dog-rescue-charity-email-1.jpg'; ?>" alt="Superhero Dog" style="max-width:100%; margin: 10px 0 40px 0;">

<h2>It’s Simple. Here’s how to Get Started:</h2>
<p>You may add your pet to our League of Superhero Pets by uploading favorite photos and a few words about your hero pet.</p>

<p><strong><?php
$new_recipient = get_user_meta( $recipient_user->ID, 'wcsg_update_account', true );

if ( 'true' == $new_recipient ) : ?>

<?php printf( esc_html_e( 'We noticed you didn\'t have an account with %1$s, so we created one for you. Your account login details will have been sent to you in a separate email.', 'woocommerce-subscriptions-gifting' ), esc_html( $blogname ) ); ?>

<?php else : ?>

<?php printf( esc_html__( 'You may access your account area to view your new %1$s here: %2$sMy Account%3$s.', 'woocommerce-subscriptions-gifting' ), 'membership',
    '<a href="' . untrailingslashit( esc_url( wc_get_page_permalink( 'myaccount' ) ) ) . '/pet-profiles/?gift_create=1">',
    '</a>'
); ?>

<?php endif;
?></strong></p>

<p>Details of the membership are shown below:</p>
<?php

foreach ( $subscriptions as $subscription_id ) {
	$subscription = wcs_get_subscription( $subscription_id );

	do_action( 'wcs_gifting_email_order_details', $subscription, $sent_to_admin, $plain_text, $email );

	if ( is_callable( array( 'WC_Subscriptions_Email', 'order_download_details' ) ) ) {
		WC_Subscriptions_Email::order_download_details( $subscription, $sent_to_admin, $plain_text, $email );
	}
}

do_action( 'woocommerce_email_footer', $email );
