<?php
namespace WeDevs\ERP\HRM;

use WeDevs\ERP\HRM\Models\Financial_Year;

/**
 * List table class
 */
class Entitlement_List_Table extends \WP_List_Table {

    protected $entitlement_data = array();

    function __construct() {
        global $status, $page;

        parent::__construct( array(
            'singular' => 'entitlement',
            'plural'   => 'entitlements',
            'ajax'     => false
        ) );
    }

    function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', 'entitlement-list-table', $this->_args['plural'] );
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb'            => '<input type="checkbox" />',
            'name'          => __( 'Employee Name', 'erp' ),
            'leave_policy'  => __( 'Leave Policy', 'erp' ),
            'valid_from'    => __( 'Valid From', 'erp' ),
            'valid_to'      => __( 'Valid To', 'erp' ),
            'days'          => __( 'Days', 'erp' ),
            'available'     => __( 'Available', 'erp' ),
            'spent'         => __( 'Spent', 'erp' ),
            'extra'         => __( 'Extra Leaves', 'erp' ),
        );

        // hide cb if debug mode is off
        if ( ! erp_get_option( 'erp_debug_mode', 'erp_settings_general', 0 ) ) {
            unset( $columns['cb'] );
        }

        return apply_filters( 'erp_hr_entitlement_table_cols', $columns );
    }

    /**
     * Extra filters for the list table
     *
     * @since 0.1
     * @since 1.2.0 Using financial year or years instead of single year filtering
     *
     * @param string $which
     *
     * @return void
     */
    function extra_tablenav( $which ) {
        if ( $which != 'top' ) {
            return;
        }
        $entitlement_years = wp_list_pluck( Financial_Year::all(), 'fy_name', 'id' );

        if ( empty( $entitlement_years ) ) {
            return;
        }

        $selected_f_year = '';
        if ( ! empty( $_GET['financial_year'] ) ) {
            $selected_f_year = absint( wp_unslash( $_GET['financial_year'] ) );
        }

        $policies = \WeDevs\ERP\HRM\Models\Leave_Policy::all();
        $policy_data = array();
        foreach ( $policies as $policy ) {
            $policy_data[ $policy['f_year'] ][] = array(
                'name'      => $policy->leave->name,
                'policy_id'  => $policy['id']
            );
        }

        $selected_leave_id = '';
        if ( ! empty( $_GET['leave_policy'] ) ) {
            $selected_leave_id = absint( wp_unslash( $_GET['leave_policy'] ) );
        }
        ?>
            <div class="alignleft actions">
                <select name="financial_year" id="financial_year">
                    <?php echo wp_kses( erp_html_generate_dropdown( array( '' => esc_attr__( 'select year', 'erp' ) ) + $entitlement_years, $selected_f_year ), array(
                        'option' => array(
                            'value' => array(),
                            'selected' => array()
                        ),
                    ) ); ?>
                </select>

                <select name="leave_policy" id="leave_policy">
                    <option value=""><?php echo esc_attr__( 'All Policy', 'erp'); ?></option>
                    <?php if ( array_key_exists( $selected_f_year, $policy_data ) ) {
                        foreach ( $policy_data[ $selected_f_year ] as $policy ) {
                            $selected = $policy['policy_id'] == $selected_leave_id ? 'selected="selected"' : '';
                            echo "<option value='{$policy['policy_id']}' $selected>{$policy['name']}</option>";
                        }
                    } ?>
                </select>

                <?php submit_button( __( 'Filter' ), 'button', 'filter_entitlement', false ); ?>
            </div>
        <?php
    }


    /**
     * Message to show if no entitlement found
     *
     * @return void
     */
    function no_items() {
        esc_html_e( 'No entitlement found.', 'erp' );
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    function column_default( $entitlement, $column_name ) {
        $f_year = Financial_Year::find( $entitlement->f_year );

        switch ( $column_name ) {
            case 'leave_policy':
                return esc_html( $entitlement->policy_name );

            case 'valid_from':
                return erp_format_date( $f_year->start_date );

            case 'valid_to':
                return erp_format_date( $f_year->end_date );

            case 'days':
                return number_format_i18n( $entitlement->day_in );

            default:
                return isset( $entitlement->$column_name ) ? $entitlement->$column_name : '';
        }
    }

    function column_available( $entitlement ) {
        $str = '';

        if ( ! array_key_exists( $entitlement->id, $this->entitlement_data ) ) {
            $this->entitlement_data[ $entitlement->id ] = erp_hr_leave_get_balance_for_single_entitlement( $entitlement->id );
        }

        if ( array_key_exists( $entitlement->id, $this->entitlement_data ) && ! is_wp_error( $this->entitlement_data[ $entitlement->id ] ) ) {
            $available = floatval( $this->entitlement_data[ $entitlement->id ]['available'] );
            $str =  $available > 0 ? sprintf( '<span class="green">%s %s</span>', erp_number_format_i18n( $available ), __( 'days', 'erp' ) ) : '-';
        }

        return $str;
    }

    function column_spent( $entitlement ) {
        $str = '';

        if ( ! array_key_exists( $entitlement->id, $this->entitlement_data ) ) {
            $this->entitlement_data[ $entitlement->id ] = erp_hr_leave_get_balance_for_single_entitlement( $entitlement->id );
        }

        if ( array_key_exists( $entitlement->id, $this->entitlement_data ) && ! is_wp_error( $this->entitlement_data[ $entitlement->id ] ) ) {
            $spent = floatval( $this->entitlement_data[ $entitlement->id ]['spent'] );
            $str = $spent > 0 ? sprintf( '<span class="green">%s %s</span>', erp_number_format_i18n( $spent ), __( 'days', 'erp' ) ) : '-';
        }

        return $str;
    }

    function column_extra( $entitlement ) {
        $str = '';

        if ( ! array_key_exists( $entitlement->id, $this->entitlement_data ) ) {
            $this->entitlement_data[ $entitlement->id ] = erp_hr_leave_get_balance_for_single_entitlement( $entitlement->id );
        }

        if ( array_key_exists( $entitlement->id, $this->entitlement_data ) && ! is_wp_error( $this->entitlement_data[ $entitlement->id ] ) ) {
            $extra_leave = floatval( $this->entitlement_data[ $entitlement->id ]['extra_leave'] );
            $str = $extra_leave > 0 ? sprintf( '<span class="red">%s %s</span>', erp_number_format_i18n( $extra_leave ), __( 'days', 'erp' ) ) : '-';
        }

        return $str;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_name( $entitlement ) {

        $actions           = array();
        $delete_url        = '';

        if ( erp_get_option( 'erp_debug_mode', 'erp_settings_general', 0 ) ) {
            $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" data-user_id="%d" data-policy_id="%d" title="%s">%s</a>', $delete_url, $entitlement->id, $entitlement->user_id, $entitlement->id, __( 'Delete this item', 'erp' ), __( 'Delete', 'erp' ) );
        }

        return sprintf( '<a href="%3$s"><strong>%1$s</strong></a> %2$s', esc_html( $entitlement->employee_name ), $this->row_actions( $actions ), erp_hr_url_single_employee( $entitlement->user_id ) );
    }

    /**
     * Trigger current action
     *
     * @return string
     */
    public function current_action() {

        if ( isset( $_REQUEST['filter_entitlement'] ) ) {
            return 'filter_entitlement';
        }

        return parent::current_action();
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'name' => array( 'name', true ),
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        if ( erp_get_option( 'erp_debug_mode', 'erp_settings_general', 0 ) ) {
            $actions = array(
                'entitlement_delete'  => __( 'Delete', 'erp' ),
            );
        }
        else {
            $actions = array();
        }

        return $actions;
    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="entitlement_id[]" value="%s" />', $item->id
        );
    }

    /**
     * Prepare the class items
     *
     * @since 0.1
     * @since 1.2.0 Using `erp_get_financial_year_dates` for financial start and end dates
     *
     * @return void
     */
    function prepare_items() {
        $columns               = $this->get_columns();
        $hidden                = array( );
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $per_page              = 20;
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page -1 ) * $per_page;
        $this->page_status     = isset( $_GET['status'] ) ? sanitize_text_field( wp_unslash(  $_GET['status'] ) ) : '2';
        $search                = ( isset( $_REQUEST['s'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) : false;

        $args = [
            'offset'      => $offset,
            'number'      => $per_page,
            'search'      => $search,
            'emp_status'  => 'active'
        ];

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = 'u.display_name';
            $args['order']   = sanitize_text_field( wp_unslash( $_REQUEST['order'] ) ) ;
        }

        if ( ! empty( $_GET['financial_year'] ) ) {
            $args['year'] = absint( wp_unslash( $_GET['financial_year'] ) );
        }

        if ( ! empty( $_GET['leave_policy'] ) ) {
            $args['policy_id'] = absint( wp_unslash( $_GET['leave_policy'] ) );
        }

        // get the items
        $items = erp_hr_leave_get_entitlements( $args );
        $this->items  = $items['data'];

        $this->set_pagination_args( array(
            'total_items' => $items['total'],
            'per_page'    => $per_page
        ) );
    }

}
