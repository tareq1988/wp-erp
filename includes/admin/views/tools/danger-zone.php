<div class="erp-grid-container tools-section erp-danger-zone">
    <h3 class="section-title"><?php esc_html_e('Reset WP ERP', 'erp'); ?></h3>

    <div class="tools-alert tools-alert-warning">
        <h4 class="tools-alert-title">
            <i class="fa fa-warning"></i>
            <?php esc_html_e('Warning', 'erp'); ?>
        </h4>
        <p><?php _e('The reset makes a fresh installation of your database. Therefore any data related to Wp ERP in your database will be lost. Please do not use this option if you do not want to delete all of your WP ERP data.', 'erp'); ?></p>
    </div>

    <div class="tools-alert tools-alert-info display-flex tools-alert-no-title">
        <p class="tools-alert-description-icon"><i class="fa fa-info-circle"></i></p>
        <p class="tools-alert-description-text">
            <?php _e('The reset does not delete of modified any of your other files/data of the site. It will only remove data related to WP ERP', 'erp'); ?>
        </p>
    </div>

    <div class="tools-card">
        <h4 class="tools-content-header"><?php _e('Reset if you are well aware about that!', 'erp'); ?></h4>
        <p class="tools-content-info-text"><?php _e('Type <b>“Reset”</b> in the confirmation field below to confirm the reset and then click the reset button.', 'erp'); ?></p>

        <form method="POST" action="" id="danger-zone-form">
            <?php erp_html_form_input( [
                'type'        => 'text',
                'name'        => 'erp_reset_confirmation',
                'value'       => '',
                'placeholder' => 'Type here',
                'class'       => 'tools-input',
                'required'    => true,
                'custom_attr'=> [
                    'autocomplete' => 'off',
                    'id'           => 'erp_reset_confirmation'
                ]
            ] ); ?>
            <div class="tools-error-message"></div>

            <?php wp_nonce_field( 'erp-reset-nonce' ); ?>
            <input type="hidden" name="action" value="erp_reset_data" />

            <button type="button" class="tools-btn tools-btn-loading tools-btn-submit tools-submit-hidden" disabled>
                 <?php _e('Resetting... <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>', 'erp'); ?>
            </button>

            <button type="submit" class="tools-btn tools-btn-danger tools-btn-submit"> <?php esc_html_e('Reset Now', 'erp'); ?> </button>
            <div class="clearfix"></div>
        </form>
    </div>

    <div class="tools-alert tools-alert-info display-flex tools-alert-no-title">
        <p class="tools-alert-description-icon"><i class="fa fa-info-circle"></i></p>
        <p class="tools-alert-description-text">
            <?php _e('<b>Caution:</b> You’ll need to insert data on WP ERP again after resetting it. Resetting makes WP ERP fresh as it was at the first-time installation.', 'erp'); ?>
        </p>
    </div>

</div><!-- .tools-section -->
