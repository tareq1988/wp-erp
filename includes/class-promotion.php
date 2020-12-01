<?php

namespace WeDevs\ERP;

/**
 * Promotional offer class
 */
class Promotion {

    /**
     * Initialize the class
     */
    public function __construct() {
        add_action( 'admin_notices', [ $this, 'promotional_offer' ] );
        add_action( 'wp_ajax_erp-dismiss-promotional-offer-notice-temp', array( $this, 'dismiss_promotional_offer' ) );
    }

    /**
     * Promotional offer notice
     *
     * @since 1.1.15
     *
     * @return void
     */
    public function promotional_offer() {
        // Show only to Admins
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        $current_time       = erp_current_datetime()->setTimezone ( new \DateTimeZone( 'America/New_York' ) );
        $promotion1_start   = $current_time->setDate( 2020, 11, 23 )->setTime( 9, 0, 0 );
        $promotion1_end     = $promotion1_start->setTime( 14, 0, 0 );
        $promotion2_start   = $promotion1_end->setTime( 14, 0, 1 );
        $promotion2_end     = $promotion2_start->modify( '+4 days' )->setTime( 23, 59, 59 );
        $promotion3_start   = $promotion2_end->modify( 'next day' )->setTime( 0, 0, 0 );
        $promotion3_end     = $current_time->setDate( 2020, 12, 4 )->setTime( 23, 59, 59 );
        // 2020-12-04 23:59:00
        if ( $current_time > $promotion3_end || $current_time < $promotion1_start ) {
            return;
        }
        if ( $current_time >= $promotion1_start && $current_time <= $promotion1_end ) {
            $msg            = 'Enjoy Flat 50% OFF on WP ERP Pro. Get Your Early Bird Black Friday';
            $option_name    = 'erp_2020_early_black_friday';
            $this->generate_notice( $msg, $option_name );
            return;
        }
        if ( $current_time >= $promotion2_start && $current_time <= $promotion2_end ) {
            $msg            = 'Enjoy Up To 50% OFF on WP ERP Pro. Get Your Black Friday';
            $option_name    = 'erp_2020_black_friday';
            $this->generate_notice( $msg, $option_name );
            return;
        }
        if ( $current_time >= $promotion3_start && $current_time <= $promotion3_end ) {
            $msg            = 'Enjoy Up To 50% OFF on WP ERP Pro. Get Your Cyber Monday';
            $option_name    = 'erp_2020_cyber_monday';
            $this->generate_notice( $msg, $option_name );
            return;
        }
    }

    /**
     * Generate offer notice
     *
     * @since 1.6.9
     *
     * @return void
     */
    public function generate_notice( $msg, $option_name ) {
        // check if it has already been dismissed
        $hide_notice = get_option( $option_name, 'no' );

        if ( 'hide' === $hide_notice ) {
            return;
        }

        $offer_msg = '<p><strong class="highlight-text" style="font-size: 18px">' . $msg . '
                <a target="_blank" href="https://wperp.com/pricing/?nocache&utm_medium=text&utm_source=wordpress-erp">  Deals Now </a>.</strong>
            </p>';
        ?>
        <div class="notice is-dismissible" id="erp-promotional-offer-notice">
            <?php echo wp_kses_post( $offer_msg ); ?>
        </div><!-- #erp-promotional-offer-notice -->

        <script type='text/javascript'>
            jQuery('body').on('click', '#erp-promotional-offer-notice .notice-dismiss', function(e) {
                e.preventDefault();

                wp.ajax.post('erp-dismiss-promotional-offer-notice-temp', {
                    dismissed: true,
                    option_name : '<?php echo esc_html( $option_name ); ?>',
                    _wpnonce : '<?php echo wp_create_nonce( 'erp_admin' ); ?>',
                } );
            });
        </script>
        <?php
    }

    /**
     * Dismiss promotion notice
     *
     * @since  2.5
     *
     * @return void
     */
    public function dismiss_promotional_offer() {
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ), 'erp_admin' ) ) {
            wp_send_json_error( esc_html__( 'Invalid nonce', 'erp' ) );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( esc_html__( 'You have no permission to do that', 'erp' ) );
        }

        if ( ! empty( $_POST['dismissed'] ) ) {
            $offer_key = ! empty( $_POST['option_name'] ) ? sanitize_text_field( wp_unslash( $_POST['option_name'] ) ) : '';
            update_option( $offer_key, 'hide' );
        }
    }
}
