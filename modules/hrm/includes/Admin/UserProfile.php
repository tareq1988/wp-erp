<?php

namespace WeDevs\ERP\HRM\Admin;

/**
 * Loads HR users admin area
 */
class UserProfile {

    /**
     * The HR users admin loader
     */
    public function __construct() {
        $this->setup_actions();
    }

    /**
     * Setup the admin hooks, actions and filters
     *
     * @return void
     */
    public function setup_actions() {
        // Bail if in network admin
        if ( is_network_admin() ) {
            return;
        }

        // User profile edit/display actions
        add_action( 'erp_user_profile_role', [ $this, 'role' ] );
        add_action( 'erp_update_user', [ $this, 'update_user' ], 10, 1 );

        //notification disable checkbox
        add_action( 'edit_user_profile', [ $this, 'profile_settings' ] );
        add_action( 'show_user_profile', [ $this, 'profile_settings' ] );

        add_action( 'erp_update_user', [ $this, 'update_profile_settings' ], 10, 1 );
    }

    public function update_user( $user_id ) {
        // verify nonce
        if ( ! isset( $_REQUEST['_erp_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_REQUEST['_erp_nonce'] ), 'user_profile_update_role' ) ) {
            return;
        }

        // HR role we want the user to have
        $new_hr_manager_role = isset( $_POST['hr_manager'] ) ? sanitize_text_field( wp_unslash( $_POST['hr_manager'] ) ) : false;

        if ( ! $new_hr_manager_role ) {
            return;
        }

        // Bail if current user cannot promote the passing user
        if ( ! current_user_can( 'promote_user', $user_id ) ) {
            return;
        }

        // Set the new HR role
        $user = get_user_by( 'id', $user_id );

        if ( $new_hr_manager_role ) {
            $user->add_role( $new_hr_manager_role );
        } else {
            $user->remove_role( erp_hr_get_manager_role() );
        }
    }

    public function role( $profileuser ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $checked = in_array( erp_hr_get_manager_role(), $profileuser->roles ) ? 'checked' : ''; ?>
        <label for="erp-hr-manager">
            <input type="checkbox" id="erp-hr-manager" <?php echo esc_attr( $checked ); ?> name="hr_manager"
                   value="<?php echo esc_attr( erp_hr_get_manager_role() ); ?>">
            <span class="description"><?php esc_html_e( 'HR Manager', 'erp' ); ?></span>
        </label>
        <?php
    }

    public function profile_settings( $profileuser ) {
        $notification = get_user_meta( $profileuser->ID, 'erp_hr_disable_notification', true );
        $checked      = ! empty( $notification ) ? 'checked' : ''; ?>
        <h3><?php esc_html_e( 'ERP Profile Settings', 'erp' ); ?></h3>
        <table class="form-table">
            <tbody>
            <tr>
                <th><label for="erp-hr-disable-notification"><?php esc_html_e( 'Notification', 'erp' ); ?></label></th>
                <td>
                    <input type="checkbox" id="erp-hr-disable-notification" <?php echo esc_attr( $checked ); ?>
                           name="erp_hr_disable_notification">
                    <span class="description"><?php esc_html_e( 'Disable WP ERP email notifications', 'erp' ); ?></span>
                </td>
            </tr>
            </tbody>
        </table>
        <?php
    }

    public function update_profile_settings( $user_id ) {
        // verify nonce
        if ( ! isset( $_REQUEST['_erp_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_REQUEST['_erp_nonce'] ), 'user_profile_update_role' ) ) {
            return;
        }

        if ( current_user_can( 'edit_user', $user_id ) ) {
            $erp_hr_disable_notification = isset( $_POST['erp_hr_disable_notification'] ) ? sanitize_text_field( wp_unslash( $_POST['erp_hr_disable_notification'] ) ) : '';
            update_user_meta( $user_id, 'erp_hr_disable_notification', $erp_hr_disable_notification );
        }
    }
}
