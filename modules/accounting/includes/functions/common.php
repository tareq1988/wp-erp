<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Upload attachments
 *
 * @return array
 */
function erp_acct_upload_attachments($files) {
    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }

    $attachments = [];
    $movefiles = [];

    // Formatting request for upload
    for ( $i = 0; $i < count($files['name']); $i++ ) {
        $attachments[] = [
            'name' => $files['name'][$i],
            'type' => $files['type'][$i],
            'tmp_name' => $files['tmp_name'][$i],
            'error' => $files['error'][$i],
            'size' => $files['size'][$i]
        ];
    }

    foreach ( $attachments as $attachment ) {
        $movefiles[] = wp_handle_upload( $attachment, [ 'test_form' => false ] );
    }

    return $movefiles;
}

/**
 * Get payable data for given month
 *
 * @param $from
 * @param $to
 *
 * @return array|null|object
 */
function erp_acct_get_payables( $from, $to ) {
    global $wpdb;

    $from_date = date( "Y-m-d", strtotime( $from ) );
    $to_date = date( "Y-m-d", strtotime( $to ) );

    $purchases = $wpdb->prefix . 'erp_acct_purchase';
    $purchase_acct_details = $wpdb->prefix . 'erp_acct_purchase_account_details';

    $purchase_query = $wpdb->prepare( "Select voucher_no, SUM(ad.debit - ad.credit) as due, due_date
                              FROM $purchases
                              LEFT JOIN $purchase_acct_details as ad
                              ON ad.purchase_no = voucher_no  where due_date
                              BETWEEN %s and %s
                              Group BY voucher_no Having due < 0 ", $from_date, $to_date );

    $purchase_results = $wpdb->get_results( $purchase_query, ARRAY_A );

    $bills = $wpdb->prefix . 'erp_acct_bills';
    $bill_acct_details = $wpdb->prefix . 'erp_acct_bill_account_details';
    $bills_query = $wpdb->prepare( "Select voucher_no, SUM(ad.debit - ad.credit) as due, due_date
                              FROM $bills
                              LEFT JOIN $bill_acct_details as ad
                              ON ad.bill_no = voucher_no  where due_date
                              BETWEEN %s and %s
                              Group BY voucher_no Having due < 0 ", $from_date, $to_date );

    $bill_results = $wpdb->get_results( $bills_query, ARRAY_A );

    if ( !empty( $purchase_results) && !empty( $bill_results ) ) {
        return array_merge( $bill_results, $purchase_results );
    }

    if ( empty( $bill_results ) ) {
        return $purchase_results;
    }

    if ( empty( $purchase_results ) ) {
        return $bill_results;
    }

}

/**
 * Get Payable overview data
 *
 * @return array
 */
function erp_acct_get_payables_overview() {
    // get dates till coming 90 days
    $from_date = date( "Y-m-d" );
    $to_date = date( "Y-m-d", strtotime( "+90 day", strtotime( $from_date ) ) );

    $data = [];
    $amount = [
        'first'  => 0,
        'second' => 0,
        'third'  => 0,
    ];

    $result = erp_acct_get_payables( $from_date, $to_date );

    if ( !empty( $result ) ) {
        $from_date = new DateTime( $from_date );

        foreach ( $result as $item_data ) {
            $item = (object)$item_data;
            $later = new DateTime( $item->due_date );
            $diff = $later->diff( $from_date )->format( "%a" );

            //segment by date difference
            switch ( $diff ) {
                case ( $diff === 0 ):
                    $data['first'][] = $item_data;
                    $amount['first'] = $amount['first'] + abs( $item->due );
                    break;

                case ( $diff <= 30 ):
                    $data['first'][] = $item_data;
                    $amount['first'] = $amount['first'] + abs( $item->due );
                    break;

                case ( $diff <= 60 ):
                    $data['second'][] = $item_data;
                    $amount['second'] = $amount['second'] + abs( $item->due );
                    break;

                case ( $diff <= 90 ):
                    $data['third'][] = $item_data;
                    $amount['third'] = $amount['third'] + abs( $item->due );
                    break;

                default:

            }
        }
    }

    return [ 'data' => $data, 'amount' => $amount ];
}

/**
 * Insert check data
 *
 * @param array $check_data
 *
 * @return void
 */
function erp_acct_insert_check_data( $check_data ) {
    global $wpdb;

    $wpdb->insert( $wpdb->prefix . 'erp_acct_expense_checks', array(
        'trn_no'      => $check_data['voucher_no'],
        'check_no'    => $check_data['check_no'],
        'voucher_type'=> $check_data['voucher_type'],
        'amount'      => $check_data['amount'],
        'name'        => $check_data['name'],
        'pay_to'      => $check_data['pay_to'],
        'created_at'  => $check_data['created_at'],
        'created_by'  => $check_data['created_by'],
        'updated_at'  => $check_data['updated_at'],
        'updated_by'  => $check_data['updated_by'],
    ) );
}

/**
 * Update check data
 *
 * @param array $check_data
 * @param $check_no
 *
 * @return void
 */
function erp_acct_update_check_data( $check_data, $check_no ) {
    global $wpdb;

    $wpdb->insert( $wpdb->prefix . 'erp_acct_expense_checks', array(
        'trn_no'      => $check_data['voucher_no'],
        'voucher_type'=> $check_data['voucher_type'],
        'amount'      => $check_data['amount'],
        'name'        => $check_data['name'],
        'pay_to'      => $check_data['pay_to'],
        'created_at'  => $check_data['created_at'],
        'created_by'  => $check_data['created_by'],
        'updated_at'  => $check_data['updated_at'],
        'updated_by'  => $check_data['updated_by'],
    ), array(
        'check_no' => $check_no,
    ) );
}

/**
 * Get people name, email by id
 *
 * @param $people_id
 *
 * @return array
 */
function erp_acct_get_people_info_by_id( $people_id ) {
    global $wpdb;

    $row = $wpdb->get_row( "SELECT first_name, last_name, email FROM {$wpdb->prefix}erp_peoples WHERE id = {$people_id} LIMIT" );

    return $row;
}

/**
 * Get ledger name, slug by id
 *
 * @param $ledger_id
 *
 * @return array
 */
function erp_acct_get_ledger_by_id( $ledger_id ) {
    global $wpdb;

    $row = $wpdb->get_row( "SELECT name, slug, code FROM {$wpdb->prefix}erp_acct_ledgers WHERE id = {$ledger_id} LIMIT 1" );

    return $row;
}

/**
 * Get product type by id
 *
 * @param $product_type_id
 *
 * @return array
 */
function erp_acct_get_product_type_by_id( $product_type_id ) {
    global $wpdb;

    $row = $wpdb->get_row( "SELECT name FROM {$wpdb->prefix}erp_acct_product_types WHERE id = {$product_type_id} LIMIT 1" );

    return $row;
}

/**
 * Get product category by id
 *
 * @param $cat_id
 *
 * @return array
 */
function erp_acct_get_product_category_by_id( $cat_id ) {
    global $wpdb;

    $row = $wpdb->get_row( "SELECT name FROM {$wpdb->prefix}erp_acct_product_categories WHERE id = {$cat_id} LIMIT 1" );

    return $row;
}

/**
 * Get tax rate name by id
 *
 * @param $rate_name_id
 *
 * @return array
 */
// function erp_acct_get_tax_rate_name_by_id( $rate_name_id ) {
//     global $wpdb;

//     $row = $wpdb->get_row( "SELECT name FROM {$wpdb->prefix}erp_acct_tax_rate_names WHERE id = {$rate_name_id} LIMIT 1" );

//     return $row->name;
// }

/**
 * Get tax agency name by id
 *
 * @param $agency_id
 *
 * @return array
 */
function erp_acct_get_tax_agency_by_id( $agency_id ) {
    global $wpdb;

    $row = $wpdb->get_row( "SELECT name FROM {$wpdb->prefix}erp_acct_tax_agencies WHERE id = {$agency_id} LIMIT 1" );

    return $row->name;
}

/**
 * Get tax category by id
 *
 * @param $cat_id
 *
 * @return array
 */
function erp_acct_get_tax_category_by_id( $cat_id ) {
    global $wpdb;

    if ( null !== $cat_id ) {
        return $wpdb->get_var( "SELECT name FROM {$wpdb->prefix}erp_acct_tax_categories WHERE id = {$cat_id}" );
    }

    return '';
}

/**
 * Get transaction status by id
 *
 * @param $trn_id
 *
 * @return string
 */
function erp_acct_get_trn_status_by_id( $trn_id ) {
    global $wpdb;

    if ( !$trn_id ) {
        return 'pending';
    }

    $row = $wpdb->get_row( "SELECT type_name FROM {$wpdb->prefix}erp_acct_trn_status_types WHERE id = {$trn_id}" );

    return ucfirst( str_replace( '_', ' ', $row->type_name ) );
}

/**
 * Get payment method by id
 *
 * @param $trn_id
 *
 * @return array
 */
function erp_acct_get_payment_method_by_id( $method_id ) {
    global $wpdb;

    $row = $wpdb->get_row( "SELECT name FROM {$wpdb->prefix}erp_acct_payment_methods WHERE id = {$method_id} LIMIT 1" );

    return $row;
}

/**
 * Get check transaction type by id
 *
 * @param $trn_id
 *
 * @return array
 */
function erp_acct_get_check_trn_type_by_id( $trn_type_id ) {
    global $wpdb;

    $row = $wpdb->get_row( "SELECT name FROM {$wpdb->prefix}erp_acct_check_trn_tables WHERE id = {$trn_type_id} LIMIT 1" );

    return $row;
}


/**
 * Get Accounting Quick Access Menus
 *
 * @return array
 */
function erp_acct_quick_access_menu() {
    return [
        'invoice' => [
            'title' => 'Invoice',
            'slug'  => 'invoice',
            'url'   => 'invoices/new'
        ],
        'estimate' => [
            'title' => 'Estimate',
            'slug'  => 'estimate',
            'url'   => 'estimates/new'
        ],
        "rec_payment" => [
            'title' => 'Receive Payment',
            'slug'  => 'payment',
            'url'   => 'payments/new'
        ],
        "bill" => [
            'title' => 'Bill',
            'slug'  => 'bill',
            'url'   => 'bills/new'
        ],
        "pay_bill" => [
            'title' => 'Pay Bill',
            'slug'  => 'pay_bill',
            'url'   => 'pay-bills/new'
        ],
        "purchase-order" => [
            'title' => 'Purchase Order',
            'slug'  => 'purchase-orders',
            'url'   => 'purchase-orders/new'
        ],
        "purchase" => [
            'title' => 'Purchase',
            'slug'  => 'purchase',
            'url'   => 'purchases/new'
        ],
        "pay_purchase" => [
            'title' => 'Pay Purchase',
            'slug'  => 'pay_purchase',
            'url'   => 'pay-purchases/new'
        ],
        "expense" => [
            'title' => 'Expense',
            'slug'  => 'expense',
            'url'   => 'expenses/new'
        ],
        "check" => [
            'title' => 'Check',
            'slug'  => 'check',
            'url'   => 'checks/new'
        ],
        "journal" => [
            'title' => 'Journal',
            'slug'  => 'journal',
            'url'   => 'journals/new'
        ],
        "tax_rate" => [
            'title' => 'Tax Payment',
            'slug'  => 'pay_tax',
            'url'   => 'pay-tax'
        ]
    ];
}

/**
 * Get check transaction type by voucher_no
 *
 * @param $trn_id
 *
 * @return array
 */
function erp_acct_get_trn_type_by_voucher_no( $voucher_no ) {
    global $wpdb;

    $row = $wpdb->get_row( "SELECT type FROM {$wpdb->prefix}erp_acct_voucher_no WHERE id = {$voucher_no} LIMIT 1" );

    return $row->type;
}

/**
 * Change a string to slug
 */
function slugify($str) {
    // replace non letter or digits by _
    $str = preg_replace('~[^\pL\d]+~u', '_', $str);

    return strtolower($str);
}

/**
 * Get ledger account name by ledger id
 *
 * @param $id
 * @return mixed
 */
function erp_acct_get_ledger_name_by_id( $id ) {
    global $wpdb;

    $sql = $wpdb->prepare("SELECT name FROM {$wpdb->prefix}erp_acct_ledgers WHERE id = %d", $id);

    $result = $wpdb->get_row( $sql );

    return $result->name;
}

