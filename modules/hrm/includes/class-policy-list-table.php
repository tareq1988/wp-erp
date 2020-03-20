<?php
namespace WeDevs\ERP\HRM;

use WeDevs\ERP\HRM\Models\Financial_Year;

/**
 * List table class
 */
class Leave_Policies_List_Table extends \WP_List_Table {

    function __construct() {
        global $status, $page;

        parent::__construct( array(
            'singular' => 'leave_policy',
            'plural'   => 'leave_policies',
            'ajax'     => false
        ) );

        $this->table_css();
    }

    /**
     * Get table classes
     *
     * @return array
     */
    function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', 'erp-leave-policy-list-table', $this->_args['plural'] );
    }
    /**
     * Table column width css
     *
     * @return void
     */
    function table_css() {
        echo '<style type="text/css">';
        echo '.wp-list-table .column-name img { float: left; margin-right: 10px; margin-top: 1px; }';
        echo '.wp-list-table .column-balance { width: 8%; }';
        echo '.wp-list-table .column-status { width: 8%; }';
        echo '.wp-list-table .column-comments { width: 25%; }';
        echo '</style>';
    }

    /**
     * Message to show if no policy found
     *
     * @return void
     */
    function no_items() {
        esc_html_e( 'No policies found.', 'erp' );
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
    function extra_tablenav( $which ) {
        if ( $which != 'top' ) {
            return;
        }

        $financial_years =  array( '' => esc_attr__( 'Select year', 'erp') ) +  wp_list_pluck( Financial_Year::all(), 'fy_name', 'id' );

        $selected_year = ( isset( $_GET['filter_year'] ) ) ? absint( wp_unslash( $_GET['filter_year'] ) ) : '';
        ?>
        <div class="alignleft actions">

            <label class="screen-reader-text" for="filter_year"><?php esc_html_e( 'Filter by year', 'erp' ) ?></label>
            <input type="hidden" name="status" value="<?php echo esc_html( $this->page_status ); ?>">
            <select name="filter_year" id="filter_year">
                <?php
                foreach ( $financial_years as $f_id => $f_name ) {
                    echo sprintf( "<option value='%s'%s>%s</option>\n", esc_html( $f_id ), selected( $selected_year, $f_id, false ), esc_html( $f_name ) );
                }
                ?>
            </select>

            <?php
            submit_button( __( 'Filter' ), 'button', 'filter_by_year', false );
        echo '</div>';
    }

    /**
     * Filter action
     * @return string
     */
    public function current_action() {

        if ( isset( $_REQUEST['filter_by_year'] ) ) {
            return 'filter_by_year';
        }

        if ( ! empty( $_REQUEST['s'] ) ) {
            return 'search_request';
        }

        return parent::current_action();
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    function column_default( $leave_policy, $column_name ) {

        switch ( $column_name ) {
            case 'leave_day':
                return number_format_i18n( $leave_policy->days, 0 );

            case 'calendar_color':
                return '<span class="leave-color" style="background-color: ' . $leave_policy->color . ' "></span>';

            default:
                return isset( $leave_policy->$column_name ) ? $leave_policy->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb'             => '<input type="checkbox" />',
            'name'           => __( 'Policy Name', 'erp' ),
            'description'    => __( 'Description', 'erp' ),
            'leave_day'      => __( 'Days', 'erp' ),
            'calendar_color' => __( 'Calendar Color', 'erp' ),
            'department'     => __( 'Department', 'erp' ),
            'designation'    => __( 'Designation', 'erp' ),
            'location'       => __( 'Location', 'erp' ),
            'f_year'         => __( 'Year', 'erp' ),
            'gender'         => __( 'Gender', 'erp' ),
            'marital'        => __( 'Marital', 'erp' ),
        );

        return apply_filters( 'erp_hr_leave_policy_table_cols', $columns );
    }

    /**
     * Render the leave policy name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_name( $leave_policy ) {
        $actions = array();

        $params = array(
            'page'        => 'erp-hr',
            'section'     => 'leave',
            'sub-section' => 'policies',
            'id'          => $leave_policy->id
        );

        $params['action'] = 'edit';
        $edit_url = add_query_arg( $params, admin_url( 'admin.php' ) );

        $params['action'] = 'copy';
        $copy_url = add_query_arg( $params, admin_url( 'admin.php' ) );

        $delete_url        = '';
        $actions['edit']   = sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', $edit_url, $leave_policy->id, esc_html__( 'Edit this item', 'erp' ), esc_html__( 'Edit', 'erp' ) );

        $actions['copy'] = sprintf( '<a href="%s" class="submitcopy" data-id="%d" title="%s">%s</a>', $copy_url, $leave_policy->id, esc_html__( 'Copy this item', 'erp' ), esc_html__( 'Copy', 'erp' ) );

        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', $delete_url, $leave_policy->id, esc_html__( 'Delete this item', 'erp' ), esc_html__( 'Delete', 'erp' ) );

        return sprintf( '<a href="#" class="link" data-id="%3$s"><strong>%1$s</strong></a> %2$s', esc_html( $leave_policy->name ), $this->row_actions( $actions ), $leave_policy->id );
    }

    /**
     * Modify single row element
     *
     * @since 0.1
     * @since 1.2.0 Remove time from effective date
     *
     * @param  array $item
     *
     * @return void
     */
    function single_row( $item ) {
        // $item->effective_date = preg_replace( '/\s.+$/', '', $item->effective_date );
        ?>
            <tr data-json='<?php echo json_encode( $item ); ?>'>
                <?php $this->single_row_columns( $item ); ?>
            </tr>
        <?php
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
        $actions = array(
            'trash'  => __( 'Delete', 'erp' ),
        );
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
            '<input type="checkbox" name="policy_id[]" value="%s" />', $item->id
        );
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views_() {
        $status_links   = array();
        $base_link      = admin_url( 'admin.php?page=erp-hr&section=leave' );

        foreach ($this->counts as $key => $value) {
            $class = ( $key == $this->page_status ) ? 'current' : 'status-' . $key;
            $status_links[ $key ] = sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg( array( 'status' => $key ), $base_link ), $class, $value['label'], $value['count'] );
        }

        return $status_links;
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

        $per_page              = 20;
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page -1 ) * $per_page;
        $this->page_status     = isset( $_GET['status'] ) ? sanitize_text_field( wp_unslash( $_GET['status'] ) ) : '2';

        // only ncessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
            'f_year'  => isset( $_GET['filter_year'] ) ? sanitize_text_field( wp_unslash( $_GET['filter_year'] ) ) : ''
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = sanitize_text_field( wp_unslash( $_REQUEST['orderby'] ) );
            $args['order'] = sanitize_text_field( wp_unslash( $_REQUEST['order'] ) ) ;
        }

        $this->items  = erp_hr_leave_get_policies( $args );

        $this->set_pagination_args( array(
            'total_items' => erp_hr_count_leave_policies(),
            'per_page'    => $per_page
        ) );
    }

}