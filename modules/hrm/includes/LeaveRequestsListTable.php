<?php

namespace WeDevs\ERP\HRM;

use WeDevs\ERP\HRM\Models\FinancialYear;
use WeDevs\ERP\HRM\Models\LeavePolicy;

/**
 * List table class
 */
class LeaveRequestsListTable extends \WP_List_Table {

    private $counts = [];

    private $page_status;

    private $users = [];

    public $empty_list = false;

    public function __construct() {
        global $status, $page;

        parent::__construct( [
            'singular' => 'leave-request',
            'plural'   => 'leave-requests',
            'ajax'     => false,
        ] );

        $this->table_css();
    }

    public function get_table_classes() {
        return [ 'widefat', 'fixed', 'striped', 'request-list-table', 'leaves', $this->_args['plural'] ];
    }

    /**
     * Render extra filtering option in
     * top of the table
     *
     * @since 1.3.2
     *
     * @param string $which
     *
     * @return void
     */
    public function extra_tablenav( $which ) {
        if ( $which != 'top' ) {
            return;
        }

        $this->filter_option();
    }

    /**
     * Message to show if no requests found
     *
     * @return void
     */
    public function no_items() {
        esc_html_e( 'No requests found.', 'erp' );
    }

    /**
     * Get the column names
     *
     * @return array
     */
    public function get_columns() {
        $columns = [
            'cb'          => '<input type="checkbox" />',
            'name'        => __( 'Employee Name', 'erp' ),
            'policy'      => __( 'Policy', 'erp' ),
            'request'     => __( 'Request', 'erp' ),
            'available'   => __( 'Available', 'erp' ),
            'status'      => __( 'Status', 'erp' ),
            'reason'      => __( 'Reason', 'erp' ),
            'approved_by' => __( 'Approved By', 'erp' ),
        ];

        if ( isset( $_GET['status'] ) && $_GET['status'] == 3 ) {
            $columns['approved_by'] = __( 'Rejected By', 'erp' );
        }

        return $columns;
    }

    /**
     * Default column values if no callback found
     *
     * @param object $item
     * @param string $column_name
     *
     * @return string
     */
    public function column_default( $item, $column_name ) {
        global $wpdb;

        switch ( $column_name ) {
            case 'policy':
                return esc_html( $item->policy_name );

            case 'status':
                return sprintf( '<span class="status-%s">%s</span>', absint( $item->status ), erp_hr_leave_request_get_statuses( $item->status ) );

            case 'approved_by':
                $status = $wpdb->get_row(
                    $wpdb->prepare(
                        "SELECT message, approved_by, created_at FROM {$wpdb->prefix}erp_hr_leave_approval_status WHERE leave_request_id = %d ORDER BY id DESC LIMIT 1",
                        [ $item->id ]
                    )
                );

                $approved_by = '';
                $approved_on = '';

                if ( ! empty( $status ) && null !== $status->approved_by ) {
                    $user        = get_user_by( 'id', $status->approved_by );
                    $approved_by = $user instanceof \WP_User ? esc_html( $user->display_name ) : '';
                    $approved_on = erp_format_date( $status->created_at );
                }

                if ( $approved_by && $approved_on ) {
                    $message = $status->message ? esc_html( $status->message ) : '';
                    $reason  = $message ? "<p style='white-space: nowrap; overflow: hidden; text-overflow: ellipsis;' title='{$message}'>{$message}</p>" : '';

                    return sprintf( '<p><strong>%s</strong></p><p><em>%s</em></p>%s', $approved_by, $approved_on, $reason );
                }
                break;

            case 'request':
                $request_days = $item->start_date === $item->end_date
                    ? erp_format_date( $item->start_date, 'M d' )
                    : erp_format_date( $item->start_date, 'M d' ) . ' &mdash; ' . erp_format_date( $item->end_date, 'M d' );

                $str = '<p><strong>' . $request_days . '</strong></p>';

                if ( $item->day_status_id != '1' ) {
                    $days = erp_hr_leave_request_get_day_statuses( $item->day_status_id );
                } else {
                    $days = number_format_i18n( $item->days ) . ' ' . _n( 'day', 'days', $item->days, 'erp' );
                }
                $days = sprintf( '<span class="tooltip" title="%s">%s</span>', __( 'Request Days', 'erp' ), $days );

                $str .= "<p><em>$days</em></p>";

                return $str;

            case 'available':
                $available = '';

                if ( floatval( $item->available ) >= 0 && floatval( $item->extra_leaves ) == 0 ) {
                    if ( floatval( $item->available ) == 0 ) {
                        $available = '&mdash;';
                    } else {
                        $available = sprintf( '<span class="green tooltip" title="%s"> %s %s</span>', __( 'Available Leave', 'erp' ), erp_number_format_i18n( $item->available ), _n( 'day', 'days', $item->available + 1, 'erp' ) );
                    }
                } elseif ( floatval( $item->extra_leaves ) > 0 ) {
                    $available = sprintf( '<span class="red tooltip" title="%s"> -%s %s</span>', __( 'Extra Leave', 'erp' ), erp_number_format_i18n( $item->extra_leaves ), _n( 'day', 'days', $item->extra_leaves, 'erp' ) );
                }

                return $available;

            case 'reason':
                $attachment       = '';
                $leave_attachment = get_user_meta( $item->user_id, 'leave_document_' . $item->id );

                foreach ( $leave_attachment as $la ) {
                    $file_link  = esc_url( wp_get_attachment_url( $la ) );
                    $file_name  = esc_attr( basename( $file_link ) );
                    $attachment .= "<a target='_blank' href='{$file_link}'>{$file_name}</a><br>";
                }
                $str = '';

                if ( trim( $item->reason ) != '' ) {
                    $str .= '<p>' . esc_html( $item->reason ) . '</p>';
                }

                if ( $attachment != '' ) {
                    $str .= "<p  title='$file_name' style='white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>$attachment</p>";
                }

                return stripslashes( $str );

            case 'message':
                return esc_html( $item->message );

            default:
                return isset( $item->$column_name ) ? esc_html( $item->$column_name ) : '';
        }
    }

    /**
     * Search employee form for leave request table
     *
     * @since 1.6.5
     *
     * @param string $text
     * @param string $input_id
     *
     * @return void
     */
    public function search_box( $text, $input_id ) {
        if ( empty( $_REQUEST['s'] ) && ! $this->has_items() ) {
            return;
        }

        $input_id = $input_id . '-search-input';

        if ( ! empty( $_REQUEST['orderby'] ) ) {
            echo '<input type="hidden" name="orderby" value="' . esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['orderby'] ) ) ) . '" />';
        }

        if ( ! empty( $_REQUEST['order'] ) ) {
            echo '<input type="hidden" name="order" value="' . esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['order'] ) ) ) . '" />';
        }

        if ( ! empty( $_REQUEST['post_mime_type'] ) ) {
            echo '<input type="hidden" name="post_mime_type" value="' . esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['post_mime_type'] ) ) ) . '" />';
        }

        if ( ! empty( $_REQUEST['detached'] ) ) {
            echo '<input type="hidden" name="detached" value="' . esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['detached'] ) ) ) . '" />';
        } ?>
        <p class="search-box">
            <label for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $text ); ?>:</label>
            <input type="search" id="<?php echo esc_attr( $input_id ); ?>" name="s" value="<?php _admin_search_query(); ?>" />
            <?php submit_button( $text, 'button', 'employee_search', false, [ 'id' => 'search-submit' ] ); ?>
        </p>
        <?php
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = [
            'from_date' => [ 'start_date', false ],
            'to_date'   => [ 'end_date', false ],
            'name'      => [ 'display_name', false ],
        ];

        return $sortable_columns;
    }

    /**
     * Render the employee name column
     *
     * @param object $item
     *
     * @return string
     */
    public function column_name( $item ) {
        $tpl     = '?page=erp-hr&section=leave&leave_action=%s&id=%d&filter_year=%d';
        $nonce   = 'erp-hr-leave-req-nonce';
        $actions = [];

        $delete_url  = wp_nonce_url( sprintf( $tpl, 'delete', $item->id, $item->f_year ), $nonce );
        $reject_url  = wp_nonce_url( sprintf( $tpl, 'reject', $item->id, $item->f_year ), $nonce );
        $approve_url = wp_nonce_url( sprintf( $tpl, 'approve', $item->id, $item->f_year ), $nonce );
        $pending_url = wp_nonce_url( sprintf( $tpl, 'pending', $item->id, $item->f_year ), $nonce );

        if ( erp_get_option( 'erp_debug_mode', 'erp_settings_general', 0 ) ) {
            $actions['delete'] = sprintf( '<a href="%s" data-id="%d" class="submitdelete">%s</a>', $delete_url, $item->id, __( 'Delete', 'erp' ) );
        }

        if ( $item->status == '2' || $item->status == '4' ) {
            $actions['approved'] = sprintf( '<a class="erp-hr-leave-approve-btn" data-id="%s" href="%s">%s</a>', $item->id, $approve_url, __( 'Approve', 'erp' ) );
            $actions['reject']   = sprintf( '<a class="erp-hr-leave-reject-btn" data-id="%s" href="%s">%s</a>', $item->id, $reject_url, __( 'Reject', 'erp' ) );
        } elseif ( $item->status == '1' ) {
            $actions['reject'] = sprintf( '<a class="erp-hr-leave-reject-btn" data-id="%s" href="%s">%s</a>', $item->id, $reject_url, __( 'Reject', 'erp' ) );
        } elseif ( $item->status == '3' ) {
            $actions['approved'] = sprintf( '<a class="erp-hr-leave-approve-btn" data-id="%s" href="%s">%s</a>', $item->id, $approve_url, __( 'Approve', 'erp' ) );
        }

        return sprintf(
            apply_filters( 'erp_leave_request_employee_name_column', '', $item->id ) . '<a href="%3$s"><strong>%1$s</strong></a>' . '%2$s',
            $item->name,
            $this->row_actions( apply_filters( 'erp_leave_request_row_actions', $actions, $item ) ),
            erp_hr_url_single_employee( $item->user_id )
        );
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    public function get_bulk_actions() {
        if ( erp_get_option( 'erp_debug_mode', 'erp_settings_general', 0 ) ) {
            $actions['delete'] = __( 'Delete', 'erp' );
        }

        if ( $this->page_status == '2' || $this->page_status == '4' ) {
            $actions['approved'] = __( 'Approve', 'erp' );
            $actions['reject']   = __( 'Reject', 'erp' );
        } elseif ( $this->page_status == '1' ) {
            $actions['reject'] = __( 'Reject', 'erp' );
        } elseif ( $this->page_status == '3' ) {
            $actions['approved'] = __( 'Approve', 'erp' );
        } else {
            $actions['reject']   = __( 'Reject', 'erp' );
            $actions['approved'] = __( 'Approve', 'erp' );
            /*$actions['pending']  = __( 'Mark Pending', 'erp' );*/
        }

        return $actions;
    }

    /**
     * Render the checkbox column
     *
     * @param object $item
     *
     * @return string
     */
    public function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="request_id[]" value="%s" />', $item->id
        );
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_status() {
        //         get current year as default f_year
        $current_f_year = erp_hr_get_financial_year_from_date();
        $f_year         = isset( $_GET['filter_year'] ) ? absint( wp_unslash( $_GET['filter_year'] ) ) : ( ! empty( $current_f_year ) ? $current_f_year->id : '' );

        $status_links = [];
        $base_link    = admin_url( 'admin.php?page=erp-hr&section=leave&filter_year=' . $f_year );

        foreach ( $this->counts as $key => $value ) {
            $class                = ( $key == $this->page_status ) ? 'current' : 'status-' . $key;
            $status_links[ $key ] = sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg( [ 'status' => $key ], $base_link ), $class, $value['label'], $value['count'] );
        }

        return $status_links;
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    public function prepare_items() {
        $columns               = $this->get_columns();
        $hidden                = [];
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = [ $columns, $hidden, $sortable ];

        $per_page          = 20;
        $current_page      = $this->get_pagenum();
        $offset            = ( $current_page - 1 ) * $per_page;
        $this->page_status = isset( $_GET['status'] ) ? sanitize_text_field( wp_unslash( $_GET['status'] ) ) : '2';

        // get current year as default f_year
        $current_f_year = erp_hr_get_financial_year_from_date();
        $f_year         = isset( $_GET['filter_year'] ) ? absint( wp_unslash( $_GET['filter_year'] ) ) : ( ! empty( $current_f_year ) ? $current_f_year->id : '' );

        // only necessary because we have sample data
        $args = [
            'offset'  => $offset,
            'number'  => $per_page,
            'status'  => $this->page_status,
            'f_year'  => isset( $_GET['filter_year'] ) ? sanitize_text_field( wp_unslash( $_GET['filter_year'] ) ) : $f_year,
            'orderby' => isset( $_GET['orderby'] ) ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : 'created_at',
            'order'   => isset( $_GET['order'] ) ? sanitize_text_field( wp_unslash( $_GET['order'] ) ) : 'DESC',
            's'       => isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '',
        ];

        if ( erp_hr_is_current_user_dept_lead() && ! current_user_can( 'erp_leave_manage' ) ) {
            $args['lead'] = get_current_user_id();
        }

        $this->counts = erp_hr_leave_get_requests_count( $f_year );

        $query_results = erp_hr_get_leave_requests( $args );
        $this->items   = $query_results['data'];
        $total         = $query_results['total'];

        if ( 0 === $total ) {
            $this->empty_list = true;
        }

        $this->set_pagination_args( [
            'total_items' => $total,
            'per_page'    => $per_page,
        ] );
    }

    /**
     * Render extra filtering option in
     * top of the table
     *
     * @since 0.1
     *
     * @param string $which
     *
     * @return void
     */
    public function filter_option() {
        $filter_leave_year = ( isset( $_GET['filter_leave_year'] ) ) ? sanitize_text_field( wp_unslash( $_GET['filter_leave_year'] ) ) : '';
        $selected_leave_policy = ( isset( $_GET['leave_policy'] ) ) ? sanitize_text_field( wp_unslash( $_GET['leave_policy'] ) ) : 0;
        $filter_leave_status   = ( isset( $_GET['filter_leave_status'] ) ) ? sanitize_text_field( wp_unslash( $_GET['filter_leave_status'] ) ) : 'all';
        $filter_financial_year = ( isset( $_GET['financial_year'] ) ) ? sanitize_text_field( wp_unslash( $_GET['financial_year'] ) ) : '';
        if ( ! empty( $_GET['financial_year'] ) ) {
            $selected_f_year = absint( wp_unslash( $_GET['financial_year'] ) );
        } else {
            $selected_f_year = erp_hr_get_financial_year_from_date()->id;
        }
        $date_range_start      = isset( $_GET['start'] ) ? sanitize_text_field( wp_unslash( $_GET['start'] ) ) : '';
        $date_range_end        = isset( $_GET['end'] ) ? sanitize_text_field( wp_unslash( $_GET['end'] ) ) : '';
        $policies              = LeavePolicy::all();
        $policy_data           = [];
        foreach ( $policies as $policy ) {
            $policy_data[ $policy['f_year'] ][] = [
                'name'          => $policy->leave->name,
                'policy_id'     => $policy['id'],
                'employee_type' => $policy['employee_type'],
            ];
        }

        $financial_years = [];
        foreach ( FinancialYear::all() as $f_year ) {
            $financial_years[ $f_year['id'] ] = $f_year['fy_name'];
        }
        ?>

        <div class="wperp-filter-dropdown" style="margin: -46px 0 0 0;">
            <a class="wperp-btn btn--filter">
                <svg style="margin: 8px 10px 8px 10px;" width='17' height='12' viewBox='0 0 17 12' fill='none' xmlns='http://www.w3.org/2000/svg'>
                    <path d='M6.61111 11.6668H10.3889V9.77794H6.61111V11.6668ZM0 0.333496V2.22239H17V0.333496H0ZM2.83333 6.94461H14.1667V5.05572H2.83333V6.94461Z' fill='white' />
                </svg><?php esc_html_e( 'Filter Leave Requests', 'erp' ); ?>&nbsp;&nbsp;&nbsp;</a>

            <div class="erp-dropdown-filter-content" id="erp-dropdown-content">
                <div class="wperp-filter-panel wperp-filter-panel-default" style="width: 450px !important;">
                    <h2><?php esc_html_e( 'Filter Leave Request', 'erp' ); ?></h2>
                    <div class="wperp-filter-panel-body">
                        <div class="input-component">
                            <label for="employee_name"><?php esc_html_e( 'Employee name', 'erp' ); ?></label>
                            <input autocomplete="off" type="text" name="employee_name" id="employee_name" placeholder="<?php esc_attr_e( 'Search by employee name', 'erp' ); ?>" />
                            <span id='live-employee-search'></span>
                        </div>

                        <div class='input-component' style="display: flex; justify-content: space-between; ">
                            <div>
                                <label for='financial_year'><?php esc_html_e( 'Financial year', 'erp' ); ?></label>
                                <select name='financial_year' id='financial_year'>
                                    <option value=''><?php echo esc_attr__( 'Select year', 'erp' ); ?></option>
                                    <?php
                                    foreach ( $financial_years as $key => $year ) {
                                        echo sprintf( "<option value='%s'%s>%s</option>\n", esc_html( $key ), selected( $filter_financial_year, esc_html( $key ), false ), esc_html( $year ) );
                                    }
                                    ?>
                                </select>
                            </div>
                            <div>
                                <label for="leave_policy"><?php esc_html_e( 'Leave Policy', 'erp' ); ?></label>
                                <select name='leave_policy' id='leave_policy'>
                                    <option value=''><?php echo esc_attr__( 'All Policy', 'erp' ); ?></option>
                                    <?php
                                    if ( array_key_exists( $selected_f_year, $policy_data ) ) {
                                        foreach ( $policy_data as $policy ) {
                                            $selected = $policy['policy_id'] == $selected_leave_policy ? 'selected="selected"' : '';
                                            echo sprintf( "<option value='%s' %s>%s</option>", esc_attr( $policy['policy_id'] ), esc_attr( $selected ), esc_html( $policy['name'] ) );
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='input-component'>
                            <label for="filter_leave_status"><?php esc_html_e( 'Leave status', 'erp' ); ?></label>
                            <div style="margin: 15px 0 25px 0">
                                <?php
                                if(empty( $this->counts)){
                                    $this->counts = erp_hr_leave_get_requests_count( $f_year );
                                }
                                foreach ( $this->counts as $key => $title ) {
                                    if ( 'all' === $key ) {
                                        continue;
                                    }
                                    echo sprintf( "<input class='leave-status' id='%s' type='checkbox' value='%s' %s ><label class='checkbox' for='%s'><span>%s</span></label>\n", esc_html( $key ), esc_html( $key ), selected( $filter_leave_status, esc_html( $key ), false ), esc_html( $key ), esc_html( $title['label'] ) );
                                }
                                ?>
                            </div>
                        </div>
                        <div class='input-component'>
                            <label for='filter_leave_year'><?php esc_html_e( 'Date range', 'erp' ); ?></label>
                            <select name='filter_leave_year' id='filter_leave_year'>
                                <?php
                                $selected = ( $filter_leave_year === 'custom' ) ? 'selected' : '';
                                ?>
                                <option value=''><?php echo esc_attr__( 'Filter by date', 'erp' ); ?></option>
                                <option value='1'><?php echo esc_attr__( 'Last week', 'erp' ); ?></option>
                                <option value='2'><?php echo esc_attr__( 'Last month', 'erp' ); ?></option>
                                <option value='3'><?php echo esc_attr__( 'Last 3 months', 'erp' ); ?></option>
                                <option value="custom" <?php echo esc_attr( $selected ); ?>><?php esc_html_e( 'Custom', 'erp' ); ?></option>
                            </select>
                            <span id="custom-date-range-leave-filter"></span>
                            <?php if ( $selected ) { ?>
                                <div class='input-component' style='display: flex; justify-content: space-between; '>
                                    <div>
                                        <label for='start_date'><?php esc_html_e( 'From', 'erp' ); ?></label>
                                        <input autocomplete="off" name='start_date' type='text' value="<?php echo esc_attr( $date_range_start ); ?>">
                                    </div>
                                    <div>
                                        <label for='end_date'><?php esc_html_e( 'To', 'erp' ); ?></label>
                                        <input autocomplete="off" name='end_date' class='erp-leave-date-field' type='text' value="<?php echo esc_attr( $date_range_end ); ?>">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="wperp-filter-panel-footer">
                        <input type="submit" class="wperp-btn btn--cancel btn--filter-apply" value="<?php esc_attr_e( 'Cancel', 'erp' ); ?>" name="hide_filter">
                        <input type="submit" class="wperp-btn btn--reset btn--filter-apply" value="<?php esc_attr_e( 'Reset', 'erp' ); ?>" name="reset_filter">
                        <input type="submit" name="filter_employee" id="filter" class="wperp-btn btn--filter-apply" value="<?php esc_attr_e( 'Apply', 'erp' ); ?>">
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

}
