<?php

namespace WeDevs\ERP\HRM;

use WeDevs\ERP\HRM\Models\Financial_Year;
use WeDevs\ERP\HRM\Models\Leave_Policy;

/**
 * List table class
 */
if ( ! class_exists( 'WP_List_Table' ) ) {

    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Leave_Report_Employee_Based extends \WP_List_Table {
    protected $reports;
    protected $policies;
    protected $current_f_year;

    function __construct() {
        global $wpdb;

        parent::__construct( array(
            'singular' => 'leave',
            'plural'   => 'leaves',
            'ajax'     => false
        ) );

        $this->table_css();

        $policy_tbl = "{$wpdb->prefix}erp_hr_leave_policies";
        $leave_name_tbl = "{$wpdb->prefix}erp_hr_leaves";

        $this->policies = Leave_Policy::select( "$leave_name_tbl.name", "$policy_tbl.id", "$policy_tbl.leave_id" )
            ->leftJoin( $leave_name_tbl, "$policy_tbl.leave_id", '=', "$leave_name_tbl.id" )
            ->get();

        $financial_year = erp_get_financial_year_dates();
        $fids = get_financial_year_from_date_range( $financial_year['start'], $financial_year['end'] );
        $this->current_f_year = is_array( $fids ) && ! empty( $fids ) ? $fids[0] : 0;
    }

    /**
     * Render extra filtering option in
     * top of the table
     *
     * @since 0.1
     *
     * @param  string $which
     *
     * @return void
     */
    function extra_tablenav( $which ) {
        if ( $which != 'top' ) {
            return;
        }
        $selected_desingnation = ( isset( $_POST['filter_designation'] ) ) ? sanitize_text_field( wp_unslash( $_POST['filter_designation'] ) ) : 0;
        $selected_department   = ( isset( $_POST['filter_department'] ) ) ? sanitize_text_field( wp_unslash( $_POST['filter_department'] ) ) : 0;
        $selected_type         = ( isset( $_POST['filter_employment_type'] ) ) ? sanitize_text_field( wp_unslash( $_POST['filter_employment_type'] ) ) : '';

        $financial_years =  array( '' => esc_attr__( 'select year', 'erp') ) +  wp_list_pluck( Financial_Year::all(), 'fy_name', 'id' );
        $selected_year         = ( isset( $_POST['filter_year'] ) ) ? sanitize_text_field( wp_unslash( $_POST['filter_year'] ) ) : $this->current_f_year;
        ?>
        <div class="actions alignleft">
            <label class="screen-reader-text" for="new_role"><?php esc_html_e( 'Filter by Designation', 'erp' ) ?></label>
            <select name="filter_year" id="filter_year">
                <?php
                foreach ( $financial_years as $f_id => $f_name ) {
                    echo sprintf( "<option value='%s'%s>%s</option>\n", esc_html( $f_id ), selected( $selected_year, $f_id, false ), esc_html( $f_name ) );
                }
                ?>
            </select>
            <select name="filter_designation" id="filter_designation">
                <?php echo wp_kses( erp_hr_get_designation_dropdown( $selected_desingnation ), array(
                    'option' => array(
                        'value' => array(),
                        'selected' => array()
                    )
                )  ); ?>
            </select>

            <label class="screen-reader-text" for="new_role"><?php esc_html_e( 'Filter by Designation', 'erp' ) ?></label>
            <select name="filter_department" id="filter_department">
                <?php echo erp_hr_get_departments_dropdown( $selected_department ); ?>
            </select>

            <label class="screen-reader-text" for="new_role"><?php esc_html_e( 'Filter by Employment Type', 'erp' ) ?></label>
            <select name="filter_employment_type" id="filter_employment_type">
                <option value="-1"><?php esc_html_e( '- Select Employment Type -', 'erp' ) ?></option>
                <?php
                $types = erp_hr_get_employee_types();

                foreach ( $types as $key => $title ) {
                    echo sprintf( "<option value='%s'%s>%s</option>\n", esc_html( $key ), selected( $selected_type, $key, false ), esc_html( $title ) );
                }
                ?>
            </select>
            <?php submit_button( __( 'Filter' ), 'apply', 'filter_leave_report', false ); ?>
        </div>
        <?php
    }


    function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', $this->_args['plural'] );
    }

    /**
     * Message to show if no report found
     *
     * @return void
     */
    function no_items() {

        esc_html_e( 'No Record Found', 'erp-attendance' );
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {

        $columns = array( 'name' => 'Name' );

        foreach ( $this->policies as $policy ) {
            $columns[ $policy->leave_id ] = __( $policy->name, 'erp' );
        }

        return $columns;
    }

    /**
     * Default column values if no callback found
     *
     * @param  object $item
     * @param  string $column_name
     *
     * @return string
     */
    function column_default( $item, $column_name ) {
        $report = isset( $this->reports[ $item ] ) ? $this->reports[ $item ] : [];
        if ( isset( $report[ $column_name ] ) ) {
            $summary = $report[ $column_name ];

            return erp_number_format_i18n( $summary['spent'] ) . '/' . erp_number_format_i18n( $summary['days'] );
        } elseif ( $column_name == 'name' ) {
            $user = get_user_by( 'ID', $item );
            $url  = admin_url( "admin.php?page=erp-hr&section=employee&amp;action=view&amp;id={$item}" );
            $name = $this->get_user_full_name( $user );

            return "<a href='{$url}'><strong>{$name}</strong></a>";
        } else {
            return ' - ';
        }

    }

    protected function get_user_full_name( $user ) {
        if ( ! $user instanceof \WP_User) {
            return '';
        }
        $name = array();
        if ( $user->first_name ) {
            $name[] = $user->first_name;
        }

        if ( $user->middle_name ) {
            $name[] = $user->middle_name;
        }

        if ( $user->last_name ) {
            $name[] = $user->last_name;
        }

        return implode( ' ', $name );
    }


    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items() {
        $columns               = $this->get_columns();
        $hidden                = array();
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $per_page     = 20;
        $current_page = $this->get_pagenum();
        $offset       = ( $current_page - 1 ) * $per_page;

        $selected_desingnation = ( isset( $_POST['filter_designation'] ) ) ? sanitize_text_field( wp_unslash( $_POST['filter_designation'] ) ) : 0;
        $selected_department   = ( isset( $_POST['filter_department'] ) ) ? sanitize_text_field( wp_unslash( $_POST['filter_department'] ) ) : 0;
        $selected_type         = ( isset( $_POST['filter_employment_type'] ) ) ? sanitize_text_field( wp_unslash( $_POST['filter_employment_type'] ) ) : '';
        $selected_f_year         = ( isset( $_POST['filter_year'] ) ) ? sanitize_text_field( wp_unslash( $_POST['filter_year'] ) ) : $this->current_f_year;

        $query = \WeDevs\ERP\HRM\Models\Employee::where( 'status', 'active' )->select( 'user_id' )->orderBy( 'hiring_date', 'desc' );

        if ( $selected_department && '-1' != $selected_department ) {
            $query->where( 'department', intval( $selected_department ) );
        }

        if ( $selected_desingnation && '-1' != $selected_desingnation ) {
            $query->where( 'designation', intval( $selected_desingnation ) );
        }

        if ( $selected_type && '-1' != $selected_type ) {
            $query->where( 'type', $selected_type );
        }

        $total_count = $query->count();

        $employees_obj = $query->skip( $offset )->take( $per_page )->get()->toArray();
        $employees = wp_list_pluck( $employees_obj, 'user_id' );
        $reports   = erp_get_leave_report( $employees, $selected_f_year );
        $this->reports = $reports;
        $this->items   = $employees;
        $this->set_pagination_args( array(
            'total_items' => $total_count,
            'per_page'    => $per_page
        ) );

    }

}

