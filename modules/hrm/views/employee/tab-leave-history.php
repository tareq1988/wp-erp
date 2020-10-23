<?php

if ( ! empty( $requests ) ) {
    foreach ( $requests as $num => $request ) {
        ?>
        <tr class="<?php echo $num % 2 == 0 ? 'alternate' : 'odd'; ?>">
            <td>
                <?php
                $request_days = $request->start_date === $request->end_date
                    ? erp_format_date( $request->start_date, 'M d' )
                    : erp_format_date( $request->start_date, 'M d' ) . ' &mdash; ' . erp_format_date( $request->end_date, 'M d' );
        printf( '%s', $request_days ); ?>
            </td>
            <td><?php echo esc_html( $request->policy_name ); ?></td>
            <td><?php echo !empty( $request->reason ) ? esc_html( stripslashes( $request->reason ) ) : '-'; ?></td>
            <td><?php
                if ( $request->day_status_id != '1' ) {
                    $days = erp_hr_leave_request_get_day_statuses( $request->day_status_id );
                } else {
                    $days = erp_number_format_i18n( $request->days ) . ' ' . esc_attr__( 'days', 'erp' );
                }

        echo sprintf( '<span>%s</span>', $days ); ?></td>
            <td><?php echo '<span class="status-' . $request->status . '">' . erp_hr_leave_request_get_statuses( $request->status ) . '</span>'; ?></td>
        </tr>

    <?php
    } ?>

<?php
} else { ?>
    <tr class="alternate">
        <td colspan="4">
            <?php esc_html_e( 'No history found!', 'erp' ); ?>
        </td>
    </tr>
<?php } ?>
