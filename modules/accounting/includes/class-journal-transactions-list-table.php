<?php

namespace WeDevs\ERP\Accounting;

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class Journal_Transactions_List_Table extends Transaction_List_Table {
    public $type_id = [];
    public $chart_group  = [];
    public $account_prev_balance = 0;

    function __construct() {

        $this->type = 'journal';
        $this->slug = 'erp-accounting-journal';

        parent::__construct();

        \WP_List_Table::__construct([
            'singular' => 'journal',
            'plural'   => 'journals',
            'ajax'     => false
        ]);

    }


    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {
        $ledger_id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : false;
        $columns = array(
            'cb'         => '<input type="checkbox" />',
            'issue_date' => __( 'Date', 'erp' ),
            'ref'        => __( 'Ref', 'erp' ),
            'summary'    => __( 'Summary', 'erp' ),
            'total'      => __( 'Total', 'erp' ),
        );

        if ( $ledger_id ) {
            unset( $columns['total'] );
            unset( $columns['summary'] );
            $columns['debit']   = __( 'Debit', 'erp' );
            $columns['credit']  = __( 'Credit', 'erp' );
            $columns['balance'] = __( 'Balance', 'erp' );
        }

        return $columns;
    }

    /**
     * Render the issue date column
     *
     * @since  1.1.6
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_issue_date( $item ) {

        $url   = admin_url( 'admin.php?page='.$this->slug.'&action=new&journal_id=' . $item->id );
        $actions['edit'] = sprintf( '<a href="%1s">%2s</a>', $url, __( 'Edit', 'erp' ) );
        return sprintf( '<a href="%1$s">%2$s</a> %3$s', admin_url( 'admin.php?page=' . $this->slug . '&action=view&id=' . $item->id ), erp_format_date( $item->issue_date ), $this->row_actions( $actions ) );
    }

    /**
     * Render the debit column
     *
     * @since  1.1.6
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_debit( $item ) {
        return empty( $item->debit ) ? '&#8212' : erp_ac_get_price( $item->debit, ['symbol' => false] );
    }

    /**
     * Render the credit column
     *
     * @since  1.1.6
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_credit( $item ) {
        return empty( $item->credit ) ? '&#8212' : erp_ac_get_price( $item->credit, ['symbol' => false] );
    }

    /**
     * Balance
     *
     * @param  array $item
     *
     * @return string
     */
    function column_balance( $item ) {
        $balance = 0;

        $balance =  ( $item->debit + $this->account_prev_balance ) - $item->credit;
        $this->account_prev_balance = $balance;

        return erp_ac_get_price( $balance );
    }

    /**
     * Get section for sales table list
     *
     * @since  1.1.6
     *
     * @return array
     */
    public function get_section() {
        return [];
    }

    /**
     * Filters
     *
     * @param  string  $which
     *
     * @return void
     */
    public function extra_tablenav( $which ) {
        if ( 'top' == $which ) {
            echo '<div class="alignleft actions">';
            erp_html_form_input([
                'name'        => 'user_id',
                'type'        => 'hidden',
                'class'       => 'erp-ac-customer-search',
                'placeholder' => __( 'Search for Customer', 'erp' ),
            ]);

            erp_html_form_input([
                'name'        => 'start_date',
                'class'       => 'erp-date-picker-from',
                'value'       => isset( $_REQUEST['start_date'] ) && !empty( $_REQUEST['start_date'] ) ? $_REQUEST['start_date'] : '',
                'placeholder' => __( 'Start Date', 'erp' )
            ]);

            erp_html_form_input([
                'name'        => 'end_date',
                'class'       => 'erp-date-picker-to',
                'value'       => isset( $_REQUEST['end_date'] ) && !empty( $_REQUEST['end_date'] ) ? $_REQUEST['end_date'] : '',
                'placeholder' => __( 'End Date', 'erp' )
            ]);

            erp_html_form_input([
                'name'        => 'ref',
                'value'       => isset( $_REQUEST['ref'] ) && ! empty( $_REQUEST['ref'] ) ? $_REQUEST['ref'] : '',
                'placeholder' => __( 'Ref No.', 'erp' )
            ]);

            submit_button( __( 'Filter', 'erp' ), 'button', 'submit_filter_sales', false );

            echo '</div>';
        }
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items() {
        $ledger_id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : false;
        $columns               = $this->get_columns();
        $hidden                = array( );
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $per_page              = 25;
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page -1 ) * $per_page;
        $this->page_status     = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '2';

        // only ncessary because we have sample data
        $args = array(
            //'type'   => $this->type,
            'offset' => $offset,
            'number' => $per_page,
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        // search params
        if ( isset( $_REQUEST['start_date'] ) && !empty( $_REQUEST['start_date'] ) ) {
            $args['start_date'] = $_REQUEST['start_date'];
        }

        if ( isset( $_REQUEST['end_date'] ) && !empty( $_REQUEST['end_date'] ) ) {
            $args['end_date'] = $_REQUEST['end_date'];
        }

        if ( isset( $_REQUEST['form_type'] ) && ! empty( $_REQUEST['form_type'] ) ) {
            if ( $_REQUEST['form_type'] == 'deleted' ) {
                $args['status'] = $_REQUEST['form_type'];
            } else {
                $args['form_type'] = $_REQUEST['form_type'];
            }
        }

        if ( isset( $_REQUEST['ref'] ) && ! empty( $_REQUEST['ref'] ) ) {
            $args['ref'] = $_REQUEST['ref'];
        }

        if ( isset( $_REQUEST['section'] ) ) {
            $args['status']  = str_replace('-', '_', $_REQUEST['section'] );
        }

        if ( $ledger_id ) {
            $this->ledger_id = true;
            // $this->chart_group = erp_ac_chart_grouping();
            // var_dump( $this->chart_group ); die();
            // $individual_ledger = \WeDevs\ERP\Accounting\Model\Ledger::select('type_id')->find( $ledger_id );
            // $this->type_id     = isset( $individual_ledger->type_id ) ? $individual_ledger->type_id : false;

            $this->items = erp_ac_get_ledger_transactions( $args, $ledger_id );

        } else {
            $args['type'] = $this->type;
            $this->items = $this->get_transactions( $args );
        }

        $this->set_pagination_args( array(
            'total_items' => $ledger_id ? 0 : $this->get_transaction_count( $args ),
            'per_page'    => $per_page
        ) );
    }
}
