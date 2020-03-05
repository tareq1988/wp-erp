<div class="leave-reject-form-wrap">
    <div id="leave-reject-form-error"></div>
    <div class="row">
        <?php erp_html_form_input( array(
            'label'    => __( 'Reason', 'erp' ),
            'name'     => 'reason',
            'id'       => 'erp-hr-leave-reject-reason',
            'value'    => '',
            'type'     => 'textarea',
            'required' => true,
            'custom_attr'   => array(
                'rows' => 5,
                'cols' => 50,
            )
        ) ); ?>
        <?php erp_html_form_input( array(
            'type'     => 'hidden',
            'name'     => 'leave_request_id',
            'value'    => '{{ data.id }}',
        ) ); ?>
        <?php erp_html_form_input( array(
            'name'     => 'action',
            'type'     => 'hidden',
            'value'    => 'erp_hr_leave_reject',
        ) ); ?>
    </div>

    <?php wp_nonce_field( 'erp-leave-reject' ); ?>
    <input type="hidden" name="action" value="erp_hr_leave_reject">
</div>
