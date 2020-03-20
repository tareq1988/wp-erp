<?php

use WeDevs\ERP\HRM\Models\Financial_Year;
use \WeDevs\ERP\HRM\Models\Leave;
use \WeDevs\ERP\HRM\Models\Leave_Policy;

$id            = isset( $_GET['id'] ) ? absint( wp_unslash( $_GET['id'] ) ) : 0;
$action        = isset( $_GET['action'] ) ? sanitize_key( wp_unslash( $_GET['action'] ) ) : '';
$leaves        = Leave::all();
$disabled      = false;
$leave_names   = array(
    '' => esc_attr__('-- select name --', 'erp')
);
$leave_policy  = [];
$submit_button = esc_attr('Save', 'erp');

foreach ( $leaves as $leave ) {
    $leave_names[$leave->id] = $leave->name;
}

// edit / copy
if ( $id ) {
    $leave_policy = Leave_Policy::find( $id );

    if ( $action === 'edit' ) {
        $disabled = true;
        $submit_button = esc_attr('Update', 'erp');
    } elseif( $action === 'copy' ) {
        $disabled = false;
        $submit_button = esc_attr('Copy', 'erp');
    }
}

$financial_years = wp_list_pluck( Financial_Year::all(), 'fy_name', 'id' );

$leave_help_text = esc_html__( 'Select A Policy Name', 'erp' ) . ' ' . esc_attr__( 'Or', 'erp' ) . ' ' . sprintf( '<a href="?page=erp-hr&section=leave&sub-section=policies&type=policy-name">%s</a>', __( 'Add New', 'erp' ) );

$f_year_help_text = __( 'Select Financial Year', 'erp' ) . ' ' . esc_attr__( 'Or', 'erp' ) . ' ' . sprintf( '<a href="?page=erp-settings&tab=erp-hr&section=financial">%s</a>', __( 'Add New', 'erp' ) );

?>
<div class="wrap">
    <form class="leave-policy-form" action="<?php echo esc_url( erp_hr_new_policy_url( $id, $action ) ); ?>" method="POST">

        <!-- show error message -->
        <?php global $policy_create_error;
            if ( isset( $policy_create_error ) && count( $policy_create_error->errors ) ) {
                echo '<ul>';
                foreach ( $policy_create_error->get_error_messages() as $error ) {
                    echo '<li style="color: #ef5350">* ' . $error . '</li>';
                }
                echo '</ul>';
            }
        ?>

        <div class="form-group">
            <div class="row">
                <?php erp_html_form_input( array(
                    'label'    => esc_html__( 'Policy Name', 'erp' ),
                    'name'     => 'leave-id',
                    'value'    => ! empty( $leave_policy ) ? $leave_policy->leave_id : '',
                    'type'     => 'select',
                    'class'    => 'leave-policy-input',
                    'required' => true,
                    'options'  => $leave_names,
                    'help'     => $leave_help_text,
                    'disabled' => $disabled,
                ) ); ?>                
            </div>

            <div class="row">
                <?php erp_html_form_input( array(
                    'label'       => esc_html__( 'Description', 'erp' ),
                    'type'        => 'textarea',
                    'class'       => 'leave-policy-input',
                    'name'        => 'description',
                    'value'       => ! empty( $leave_policy ) ? $leave_policy->description : '',
                    'placeholder' => esc_html__( '(optional)', 'erp' ),
                    'custom_attr' => [
                        'rows' => 3
                    ]
                ) ); ?>
            </div>

            <div class="row">
                <?php erp_html_form_input( array(
                    'label'       => esc_html__( 'Days', 'erp' ),
                    'name'        => 'days',
                    'value'       => ! empty( $leave_policy ) ? $leave_policy->days : '',
                    'class'       => 'leave-policy-input',
                    'required'    => true,
                    'help'        => esc_html__( 'Days in a calendar year.', 'erp' ),
                    'placeholder' => 20,
                    'readonly'    => $disabled, // we need to pass the days to check errors
                ) ); ?>
            </div>

            <div class="row applicable-form-row">
                <?php erp_html_form_input(array(
                    'label' => __('Applicable From', 'erp-pro'),
                    'name'  => 'applicable-from',
                    'class' => 'leave-policy-input',
                    'value' => ! empty( $leave_policy ) ? $leave_policy->applicable_from_days : '0',
                    'type'  => 'number'
                )); ?>
                <span>Days</span>
            </div>

            <div class="row">
                <?php erp_html_form_input( array(
                    'label'    => esc_html__( 'Calendar Color', 'erp' ),
                    'name'     => 'color',
                    'value'    => ! empty( $leave_policy ) ? $leave_policy->color : '#009688',
                    'required' => true,
                    'class'    => 'erp-color-picker'
                ) ); ?>
            </div>
        </div> <!-- .form-group -->

        <div class="form-group">
            <div class="row">
                <?php erp_html_form_input( array(
                    'label'       => esc_html__( 'Department', 'erp' ),
                    'name'        => 'department',
                    'value'       => ! empty( $leave_policy ) ? $leave_policy->department_id : '-1',
                    'class'       => 'leave-policy-input erp-hrm-select2-add-more erp-hr-dept-drop-down',
                    'custom_attr' => array( 'data-id' => 'erp-new-dept' ),
                    'type'        => 'select',
                    'options'     => erp_hr_get_departments_dropdown_raw( esc_html__( 'All Department', 'erp' ) ),
                    'disabled'    => $disabled,
                ) ); ?>
            </div>

            <div class="row">
                <?php erp_html_form_input( array(
                    'label'       => esc_html__( 'Designation', 'erp' ),
                    'name'        => 'designation',
                    'value'       => ! empty( $leave_policy ) ? $leave_policy->designation_id : '-1',
                    'class'       => 'leave-policy-input erp-hrm-select2-add-more erp-hr-desi-drop-down',
                    'custom_attr' => array( 'data-id' => 'erp-new-designation' ),
                    'type'        => 'select',
                    'options'     => erp_hr_get_designation_dropdown_raw( esc_html__( 'All Designations', 'erp' ) ),
                    'disabled'    => $disabled,
                ) ); ?>
            </div>

            <div class="row">
                <?php erp_html_form_input( array(
                    'label'   => esc_html__( 'Location', 'erp' ),
                    'name'    => 'location',
                    'value'   => ! empty( $leave_policy ) ? $leave_policy->location_id : '-1',
                    'type'    => 'select',
                    'class'   => 'leave-policy-input',
                    'options' => array(
                            '-1' => esc_html__( 'All Location', 'erp' )
                        ) + erp_company_get_location_dropdown_raw(),
                    'disabled' => $disabled,
                ) ); ?>
            </div>
        </div> <!-- .form-group -->

        <div class="form-group">

            <div class="row">
                <?php erp_html_form_input( array(
                    'label'    => esc_html__( 'Gender', 'erp' ),
                    'name'     => 'gender',
                    'value'    => ! empty( $leave_policy ) ? $leave_policy->gender : '-1',
                    'class'    => 'leave-policy-input',
                    'type'     => 'select',
                    'options'  => erp_hr_get_genders( esc_html__( 'All', 'erp' ) ),
                    'disabled' => $disabled,
                ) ); ?>
            </div>

            <div class="row">
                <?php erp_html_form_input( array(
                    'label'    => esc_html__( 'Marital Status', 'erp' ),
                    'name'     => 'marital',
                    'value'    => ! empty( $leave_policy ) ? $leave_policy->marital : '-1',
                    'class'    => 'leave-policy-input erp-hrm-select2-add-more erp-hr-desi-drop-down',
                    'type'     => 'select',
                    'options'  => erp_hr_get_marital_statuses( esc_html__( 'All', 'erp' ) ),
                    'disabled' => $disabled,
                ) ); ?>
            </div>

            <div class="row">
                <?php
                erp_html_form_input( array(
                    'label'    => esc_html__( 'Year', 'erp' ),
                    'name'     => 'f-year',
                    'value'    => ! empty( $leave_policy ) ? $leave_policy->f_year : '',
                    'required' => true,
                    'class'    => 'leave-policy-input erp-hrm-select2-add-more erp-hr-desi-drop-down',
                    'type'     => 'select',
                    'help'     => $f_year_help_text,
                    'options'  => array(
                        '' => esc_html__( '-- select year --', 'erp' )
                    ) + $financial_years,
                    'disabled' => $disabled,
                ) ); ?>
            </div>

        </div> <!-- .form-group -->

        <?php do_action('erp-hr-leave-policy-form-bottom', $leave_policy); ?>

        <?php wp_nonce_field( 'erp-leave-policy' ); ?>
        <input type="hidden" name="erp-action" value="hr-leave-policy-create">
        <input type="hidden" name="policy-id" value="<?php echo $action === 'copy' ? 0 : esc_attr( $id ); ?>">

        <?php submit_button( $submit_button ); ?>
    </form>
</div>
