<?php

use WeDevs\ERP\ERP_Errors;
use WeDevs\ERP\HRM\Models\Financial_Year;

$cur_year   = date( 'Y' );
$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : '';
?>
<div class="wrap" id="wp-erp">

    <h2>
        <?php esc_html_e( 'Leave Entitlements', 'erp' ); ?>
        <?php if ( 'assignment' == $active_tab ): ?>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=erp-hr&section=leave&sub-section=leave-entitlements' ) ); ?>" id="erp-new-leave-request" class="add-new-h2"><?php esc_html_e( 'Back to Entitlement list', 'erp' ); ?></a>
        <?php else: ?>
            <a href="<?php echo esc_url( add_query_arg( array( 'sub-section' => 'leave-entitlements', 'tab' => 'assignment' ), admin_url( 'admin.php?page=erp-hr&section=leave' ) ) ); ?>" id="erp-new-leave-request" class="add-new-h2"><?php esc_html_e( 'Add New', 'erp' ); ?></a>
        <?php endif ?>
    </h2>

    <?php if ( 'assignment' == $active_tab ) { ?>
        <?php
        $financial_years = wp_list_pluck( Financial_Year::all(), 'fy_name', 'id' );

        if ( isset( $_GET['affected' ] ) ) {
            erp_html_show_notice( sprintf( __( '%d Employee(s) has been entitled to this leave policy.', 'erp' ), sanitize_text_field( wp_unslash( $_GET['affected'] ) ) ), 'updated', true );
        }

        if ( isset( $_GET['error'] ) ) {
            $error_key = sanitize_text_field( wp_unslash( $_GET['error'] ) );
            $errors = new ERP_Errors( $error_key );
            $form_data = $errors->get_form_data();

            echo $errors->display();

            if ( isset( $form_data['affected'] ) ) {
                erp_html_show_notice( sprintf( __( '%d Employee(s) has been entitled to this leave policy.', 'erp' ), sanitize_text_field( wp_unslash( $form_data['affected'] ) ) ), 'updated', true );
            }
        }

        $policy_help_text = __( 'Select A Policy', 'erp' ) . ' ' . esc_attr__( 'Or', 'erp' ) . ' ' . sprintf( '<a href="?page=erp-hr&section=leave&sub-section=policies">%s</a>', __( 'Add New', 'erp' ) );
        $f_year_help_text = __( 'Select Financial Year', 'erp' ) . ' ' . esc_attr__( 'Or', 'erp' ) . ' ' . sprintf( '<a href="?page=erp-settings&tab=erp-hr&section=financial">%s</a>', __( 'Add New', 'erp' ) );
        ?>

        <form class="leave-entitlement-form" action="" method="post">
            <h3>
                <?php esc_html_e( 'Assign a leave policy to employees.', 'erp' ); ?>
            </h3>
            <div class="form-group">
                <div class="row">
                    <?php erp_html_form_input( array(
                        'label'    => __( 'Department', 'erp' ),
                        'name'     => 'department_id',
                        'type'     => 'select',
                        'class'    => 'leave-policy-input erp-select2 department_id change_policy',
                        'options'  => erp_hr_get_departments_dropdown_raw( __( 'All Departments', 'erp' ) )
                    ) ); ?>
                </div>

                <div class="row">
                    <?php erp_html_form_input( array(
                        'label'       => esc_html__( 'Designation', 'erp' ),
                        'name'        => 'designation_id',
                        'value'       => '-1',
                        'class'       => 'leave-policy-input erp-select2 designation_id change_policy',
                        'custom_attr' => array( 'data-id' => 'erp-new-designation' ),
                        'type'        => 'select',
                        'options'     => erp_hr_get_designation_dropdown_raw( esc_html__( 'All Designations', 'erp' ) )
                    ) ); ?>
                </div>

                <div class="row">
                    <?php erp_html_form_input( array(
                        'label'    => __( 'Location', 'erp' ),
                        'name'     => 'location_id',
                        'type'     => 'select',
                        'class'    => 'leave-policy-input erp-select2 location_id change_policy',
                        'options'  => erp_company_get_location_dropdown_raw( esc_html__( 'All Locations', 'erp' ) )
                    ) ); ?>
                </div>

                <div class="row">
                    <?php erp_html_form_input( array(
                        'label'   => esc_html__( 'Gender', 'erp' ),
                        'name'    => 'gender',
                        'value'   => '-1',
                        'class'   => 'leave-policy-input erp-select2 gender change_policy',
                        'type'    => 'select',
                        'options' => erp_hr_get_genders( esc_html__( 'All', 'erp' ) )
                    ) ); ?>
                </div>

                <div class="row">
                    <?php erp_html_form_input( array(
                        'label'   => esc_html__( 'Marital Status', 'erp' ),
                        'name'    => 'marital',
                        'value'   => '-1',
                        'class'   => 'leave-policy-input erp-select2 marital change_policy',
                        'type'    => 'select',
                        'options' => erp_hr_get_marital_statuses( esc_html__( 'All', 'erp' ) )
                    ) ); ?>
                </div>

                <div class="row">
                    <?php erp_html_form_input( array(
                        'label'    => esc_html__( 'Financial Year', 'erp' ),
                        'name'     => 'f_year',
                        'value'    =>  '',
                        'required' => true,
                        'class'    => 'leave-policy-input erp-select2 f_year change_policy',
                        'type'     => 'select',
                        'help'     => $f_year_help_text,
                        'options'  => $financial_years
                    ) ); ?>
                </div>

                <div class="row">
                    <?php erp_html_form_input( array(
                        'label'    => __( 'Leave Policy', 'erp' ),
                        'name'     => 'leave_policy',
                        'type'     => 'select',
                        'class'    => 'leave-policy-input leave_policy_dropdown leave_policy',
                        'required' => true,
                        'options'  => array( 0 => __( '- Select -', 'erp' ) ),
                        'help'     => $policy_help_text
                    ) ); ?>
                </div>

                <div class="row">
                    <?php erp_html_form_input( array(
                        'label'    => __( 'Assignment', 'erp' ),
                        'name'     => 'assignment_to',
                        'type'     => 'checkbox',
                        'class'    => 'checkbox',
                        'help'     => __( 'Assign to multiple employees', 'erp' ),
                    ) ); ?>
                </div>

                <div class="row single_employee_field">
                    <?php erp_html_form_input( array(
                        'label'    => __( 'Employee', 'erp' ),
                        'name'     => 'single_employee',
                        'type'     => 'select',
                        'class'    => 'leave-policy-input erp-select2 single_employee',
                        'required' => true,
                        'options'  => array( 0 => __( '- Select -', 'erp' ) ),
                    ) ); ?>
                </div>

                <div class="row">
                    <?php erp_html_form_input( array(
                        'label'    => __( 'Comment', 'erp' ),
                        'name'     => 'comment',
                        'type'     => 'textarea',
                        'class'    => 'leave-policy-input',
                        'placeholder' => __( 'Optional Comment', 'erp' ),
                    ) ); ?>
                </div>
            </div>

            <input type="hidden" name="erp-action" value="hr-leave-assign-policy">

            <?php wp_nonce_field( 'erp-hr-leave-assign' ); ?>
            <?php submit_button( __( 'Assign Policies', 'erp' ), 'primary' ); ?>
        </form>

    <?php } else { ?>

        <div id="erp-entitlement-table-wrap">

            <div class="list-table-inner">

                <form method="get">
                    <input type="hidden" name="page" value="erp-hr">
                    <input type="hidden" name="section" value="leave">
                    <input type="hidden" name="sub-section" value="leave-entitlements">
                    <?php
                    $entitlement = new \WeDevs\ERP\HRM\Entitlement_List_Table();
                    $entitlement->prepare_items();
                    $entitlement->search_box('Search Employee', 'search');
                    $entitlement->views();

                    $entitlement->display();
                    ?>
                </form>

            </div><!-- .list-table-inner -->
        </div><!-- .list-table-wrap -->
        <script type="text/javascript">
            ;jQuery(function( $ ) {
                var select_string = '<?php echo esc_attr__( 'All Policy', 'erp') ?>';
                var policies = <?php
                    $policies = \WeDevs\ERP\HRM\Models\Leave_Policy::all();
                    $result = array();
                    foreach ( $policies as $policy ) {
                        $result[ $policy['f_year'] ][] = array(
                            'name'      => $policy->leave->name,
                            'leave_id'  => $policy->leave_id
                        );
                    }
                    echo json_encode( $result );
                    ?>;

                $('#erp-entitlement-table-wrap').on( 'change', '#financial_year', function (e) {

                    var f_year = $(this).val();

                    $('#leave_policy option').remove();
                    var option = new Option( select_string, '' );
                    $('#leave_policy').append(option);

                    if ( policies[ f_year ] ) {
                        $.each( policies[ f_year ], function ( id, policy ) {
                            var option = new Option(policy.name, policy.leave_id);
                            $('#leave_policy').append(option);
                        } );
                    }
                });

            })
        </script>
    <?php } ?>
</div>
