<h3><?php use WeDevs\ERP\HRM\Models\Financial_Year;

    esc_html_e( 'Balances', 'erp' ); ?></h3>

<?php
$balance = $employee->get_leave_summary();

if ( $balance ) {
    ?>
    <table class="widefat">
        <thead>
            <tr>
                <th><?php esc_html_e( 'Leave', 'erp' ); ?></th>
                <th><?php esc_html_e( 'Days', 'erp' ); ?></th>
                <th><?php esc_html_e( 'Spent', 'erp' ); ?></th>
                <th><?php esc_html_e( 'Available', 'erp' ); ?></th>
                <th><?php esc_html_e( 'Period', 'erp' ); ?></th>
            </tr>
        </thead>

        <tbody>

            <?php if ( $balance ) { ?>
            <?php foreach ( $balance as $num => $entitlement ) { ?>

            <tr class="<?php echo $num % 2 == 0 ? 'alternate' : 'odd'; ?>">
                <td><?php echo esc_html( $entitlement->policy ); ?></td>
                <td><?php echo $entitlement->days ? sprintf( esc_html__( '%s days', 'erp' ), esc_html( erp_number_format_i18n( $entitlement->days ) ) ) : '-'; ?></td>
                <td><?php echo ( $entitlement->spent != 0 ) ? sprintf( esc_html__( '%s days', 'erp' ), esc_html( erp_number_format_i18n( ( $entitlement->spent ) ) ) ) : '-'; ?></td>
                <td>
                    <?php
                    if ( floatval( $entitlement->available ) >= 0 && floatval( $entitlement->extra_leave ) == 0  ) {
                        $available = sprintf( '<span class="green tooltip" title="%s"> %s %s</span>', __( 'Available Leave', 'erp' ), erp_number_format_i18n( $entitlement->available ), _n( 'day', 'days', $entitlement->available + 1, 'erp' ) );
                    } elseif ( floatval( $entitlement->extra_leave ) > 0 ) {
                        $available = sprintf( '<span class="red tooltip" title="%s"> -%s %s</span>', __( 'Extra Leave', 'erp' ), erp_number_format_i18n( $entitlement->extra_leave ), _n( 'day', 'days', $entitlement->extra_leave, 'erp' ) );
                    }
                    echo $available;

                    if ( $entitlement->available > 0 ) {
                        //printf( '<span class="green">%s %s</span>', erp_number_format_i18n( $entitlement->available ), esc_html__( 'days', 'erp' ) );
                    } else {
                        //echo '-';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    printf( '%s &ndash; %s', esc_html( erp_format_date( $entitlement->from_date ) ), esc_html( erp_format_date( $entitlement->to_date ) ) );
                    ?>
                </td>
            </tr>

            <?php } ?>
            <?php } else { ?>
            <tr class="alternate">
                <td colspan="4"><?php esc_html_e( 'No leave policy found!', 'erp' ); ?></td>
            </tr>
            <?php } ?>
        </tbody>

    </table>

<?php
} ?>

<h3><?php esc_html_e( 'History', 'erp' ); ?></h3>

<?php
// get leave requests
$requests   = $employee->get_leave_requests( [ 'status' => 'all', 'orderby' => 'start_date' ] );

// get current financial year
$financial_year = erp_hr_get_financial_year_from_date();
$f_year         = ! empty( $financial_year ) ? $financial_year->id : 0;

// get leave policies
$policies      = $employee->get_leave_policies();
$policy_result = [];

foreach ( $policies as $policy ) {
    $policy_result[ $policy['f_year'] ][ $policy['leave_id'] ] = $policy['name'];
}
$current_assigned_policies = $f_year && array_key_exists( $f_year, $policy_result ) ? $policy_result[ $f_year ] : [];
?>

<form action="#" id="erp-hr-empl-leave-history">
    <select name="f_year" id="f_year">
        <?php echo wp_kses( erp_html_generate_dropdown( [ '' => esc_attr__( 'select year', 'erp' ) ] + wp_list_pluck( Financial_Year::all(), 'fy_name', 'id' ), $f_year ), [
            'option' => [
                'value'    => [],
                'selected' => [],
            ],
        ] ); ?>
    </select>
    <?php
    $statuses = erp_hr_leave_request_get_statuses();

    if ( isset( $statuses['all'] ) ) {
        $statuses['all'] = esc_attr__( 'All Status', 'erp' );
    }
    erp_html_form_input( [
        'name'     => 'status',
        'type'     => 'select',
        'options'  => $statuses,
    ] );
    ?>

    <?php
    erp_html_form_input( [
        'name'     => 'leave_policy',
        'type'     => 'select',
        'options'  => [ 'all' => esc_attr__( 'All Policy', 'erp' ) ] + $current_assigned_policies,
    ] ); ?>

    <input type="hidden" name="employee_id" value="<?php echo esc_attr( $employee->get_user_id() ); ?>">

    <?php wp_nonce_field( 'erp-hr-empl-leave-history' ); ?>
    <?php submit_button( esc_html__( 'Filter', 'erp' ), 'secondary', 'submit', false ); ?>
</form>

<table class="widefat" id="erp-hr-empl-leave-history-table">
    <thead>
        <tr>
            <th><?php esc_html_e( 'Date', 'erp' ); ?></th>
            <th><?php esc_html_e( 'Policy', 'erp' ); ?></th>
            <th><?php esc_html_e( 'Description', 'erp' ); ?></th>
            <th><?php esc_html_e( 'Request', 'erp' ); ?></th>
            <th><?php esc_html_e( 'Status', 'erp' ); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php include __DIR__ . '/tab-leave-history.php'; ?>
    </tbody>
</table>
<script type="text/javascript">
    ;jQuery(function( $ ) {
        var select_string = '<?php echo esc_attr__( 'All Policy', 'erp' ); ?>';
        var policies = <?php
            echo json_encode( $policy_result );
            ?>;

        $('#erp-hr-empl-leave-history').on( 'change', '#f_year', function ( e) {

            var f_year = $(this).val();

            $('#leave_policy option').remove();
            var option = new Option( select_string, '' );
            $('#leave_policy').append(option);

            if ( policies[ f_year ] ) {
                $.each( policies[ f_year ], function ( id, name ) {
                    console.log(id,name);
                    var option = new Option( name, id );
                    $('#leave_policy').append( option );
                } );
            }
        });

    })
</script>
