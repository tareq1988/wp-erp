<div class="wrap erp erp-hr-leave-request-new erp-hr-leave-reqs-wrap">
    <div class="postbox">
        <h3 class="hndle">
            <?php esc_html_e( 'New Leave Request', 'erp' ); ?>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=erp-hr&section=leave&sub-section=leave-requests' ) ); ?>" id="erp-new-leave-request" class="add-new-h2" style="top: 0px;"><?php esc_html_e( 'Back to Leave Requests', 'erp' ); ?></a>
        </h3>
        <div class="inside">
            <?php
            use WeDevs\ERP\HRM\Models\Financial_Year;

            if ( isset( $_GET['error'] ) && $_GET['error'] !== '' ) {
                $errors = new \WeDevs\ERP\ERP_Errors( sanitize_text_field( wp_unslash( $_GET['error'] ) ) );
                $errors->display();
            } elseif ( isset( $_GET['msg'] ) && $_GET['msg'] == 'submitted' ) {
                erp_html_show_notice( __( 'Leave request has been submitted successfully.', 'erp' ), 'updated', true );
            }
            $financial_years = array();
            $current_start_date = erp_current_datetime()->modify( erp_financial_start_date() )->getTimestamp();
            foreach ( Financial_Year::all() as $f_year ) {
                if ( $f_year['start_date'] < $current_start_date ) {
                    continue;
                }
                $financial_years[ $f_year['id'] ] = $f_year['fy_name'];
            }
            $f_year_help_text = '';
            if ( current_user_can( 'erp_leave_create_request' ) ) {
                $f_year_help_text .=  ' ' . sprintf( '<a href="?page=erp-settings&tab=erp-hr&section=financial">%s</a>', __( 'Add New', 'erp' ) );
            }
            ?>

            <form action="" method="post" class="new-leave-request-form">

                <?php if ( current_user_can( 'erp_leave_create_request' ) ) { ?>
                    <div class="row">
                        <?php erp_html_form_input( array(
                            'label'    => __( 'Employee', 'erp' ),
                            'name'     => 'employee_id',
                            'id'       => 'erp-hr-leave-req-employee-id',
                            'value'    => '',
                            'required' => true,
                            'type'     => 'select',
                            'options'  => erp_hr_get_employees_dropdown_raw()
                        ) ); ?>
                    </div>
                <?php } ?>

                <div class="row">
                    <?php erp_html_form_input( array(
                        'label'    => esc_html__( 'Financial Year', 'erp' ),
                        'name'     => 'f_year',
                        'value'    =>  '',
                        'required' => true,
                        'class'    => 'f_year',
                        'type'     => 'select',
                        'options'  => $financial_years,
                        'help'     => $f_year_help_text,
                    ) ); ?>
                </div>

                <div class="row erp-hide erp-hr-leave-type-wrapper"></div>

                <?php do_action( 'erp_hr_leave_request_form_middle' ); ?>

                <div class="row two-col">
                    <div class="cols">
                        <?php erp_html_form_input( array(
                            'label'    => __( 'From', 'erp' ),
                            'name'     => 'leave_from',
                            'id'       => 'erp-hr-leave-req-from-date',
                            'value'    => '',
                            'required' => true,
                            'class'    => 'erp-leave-date-field',
                            'custom_attr' => [ 'disabled' => 'disabled' ]
                        ) ); ?>
                    </div>

                    <div class="cols last erp-leave-to-date">
                        <?php erp_html_form_input( array(
                            'label'    => __( 'To', 'erp' ),
                            'name'     => 'leave_to',
                            'id'       => 'erp-hr-leave-req-to-date',
                            'value'    => '',
                            'required' => true,
                            'class'    => 'erp-leave-date-field',
                            'custom_attr' => [ 'disabled' => 'disabled' ]
                        ) ); ?>
                    </div>
                </div>

                <div class="row erp-hr-leave-req-show-days show-days"></div>

                <div class="row">
                    <?php erp_html_form_input( array(
                        'label'       => __( 'Reason', 'erp' ),
                        'name'        => 'leave_reason',
                        'type'        => 'textarea',
                        'required'    => true,
                        'custom_attr' => array( 'cols' => 30, 'rows' => 3, 'disabled' => 'disabled' )
                    ) ); ?>
                </div>
                <input type="hidden" name="erp-action" value="hr-leave-req-new">
                <?php wp_nonce_field( 'erp-leave-req-new' ); ?>
                <?php submit_button( __( 'Submit Request', 'erp' ), 'primary', 'submit', true, array( 'disabled' => 'disabled' )  ); ?>

            </form>
        </div><!-- .inside-->
    </div><!-- .postbox-->
</div><!-- .wrap -->

<?php erp_get_js_template( WPERP_HRM_JS_TMPL . '/leave-days.php', 'erp-leave-days' ); ?>
