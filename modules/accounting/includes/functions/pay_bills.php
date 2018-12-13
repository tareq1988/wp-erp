<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Get all pay_bills
 *
 * @param $data
 * @return mixed
 */
function erp_acct_get_pay_bills() {
    global $wpdb;

    $rows = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "erp_acct_pay_bill", ARRAY_A );

    return $rows;
}

/**
 * Get a pay_bill
 *
 * @param $bill_no
 * @return mixed
 */
function erp_acct_get_pay_bill( $bill_no ) {
    global $wpdb;

    $row = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "erp_acct_pay_bill WHERE voucher_no = {$bill_no}", ARRAY_A );

    return $row;
}

/**
 * Insert a pay_bill
 *
 * @param $data
 * @param $pay_bill_id
 * @param $due
 * @return mixed
 */
function erp_acct_insert_pay_bill( $data ) {
    global $wpdb;

    $created_by = get_current_user_id();
    $data['created_at'] = date("Y-m-d H:i:s");
    $data['created_by'] = $created_by;
    $bill_no = '';

    try {
        $wpdb->query( 'START TRANSACTION' );

        $wpdb->insert( $wpdb->prefix . 'erp_acct_voucher_no', array(
            'type'       => 'pay_bill',
            'created_at' => $data['created_at'],
            'created_by' => $created_by,
            'updated_at' => isset( $data['updated_at'] ) ? $data['updated_at'] : '',
            'updated_by' => isset( $data['updated_by'] ) ? $data['updated_by'] : ''
        ) );

        $voucher_no = $wpdb->insert_id;
        $bill_no = $voucher_no;

        $pay_bill_data = erp_acct_get_formatted_pay_bill_data( $data, $voucher_no );

        $wpdb->insert( $wpdb->prefix . 'erp_acct_pay_bill', array(
            'voucher_no'      => $voucher_no,
            'trn_date'        => $pay_bill_data['trn_date'],
            'amount'          => $pay_bill_data['amount'],
            'particulars'     => $pay_bill_data['particulars'],
            'attachments'     => $pay_bill_data['attachments'],
            'created_at'      => $pay_bill_data['created_at'],
            'created_by'      => $created_by,
            'updated_at'      => $pay_bill_data['updated_at'],
            'updated_by'      => $pay_bill_data['updated_by'],
        ) );

        $items = $pay_bill_data['bill_details'];

        foreach ( $items as $key => $item ) {
            $wpdb->insert( $wpdb->prefix . 'erp_acct_pay_bill_details', array(
                'voucher_no'  => $voucher_no,
                'bill_no'     => $item['id'],
                'amount'      => $item['amount'],
                'created_at'  => $pay_bill_data['created_at'],
                'created_by'  => $pay_bill_data['created_by'],
                'updated_at'  => $pay_bill_data['updated_at'],
                'updated_by'  => $pay_bill_data['updated_by'],
            ) );

            erp_acct_insert_pay_bill_data_into_ledger( $pay_bill_data, $item );
        }

        $wpdb->insert( $wpdb->prefix . 'erp_acct_bill_account_details', array(
            'bill_no'     => $bill_no,
            'trn_no'      => $voucher_no,
            'particulars' => $pay_bill_data['particulars'],
            'debit'       => $pay_bill_data['amount'],
            'credit'      => 0,
            'created_at'  => $pay_bill_data['created_at'],
            'created_by'  => $pay_bill_data['created_by'],
            'updated_at'  => $pay_bill_data['updated_at'],
            'updated_by'  => $pay_bill_data['updated_by'],
        ) );

        erp_acct_insert_people_trn_data( $pay_bill_data, $pay_bill_data['vendor_id'], 'debit' );

        $wpdb->query( 'COMMIT' );

    } catch (Exception $e) {
        $wpdb->query( 'ROLLBACK' );
        return new WP_error( 'pay-bill-exception', $e->getMessage() );
    }

    return $bill_no;

}

/**
 * Update a pay_bill
 *
 * @param $data
 * @param $pay_bill_id
 * @param $due
 * @return mixed
 */
function erp_acct_update_pay_bill( $data, $pay_bill_id ) {

    global $wpdb;

    $updated_by = get_current_user_id();
    $data['updated_at'] = date("Y-m-d H:i:s");
    $data['updated_by'] = $updated_by;

    try {
        $wpdb->query( 'START TRANSACTION' );

        $pay_bill_data = erp_acct_get_formatted_pay_bill_data( $data, $pay_bill_id );

        $wpdb->update( $wpdb->prefix . 'erp_acct_pay_bill', array(
            'bill_no'         => $pay_bill_data['bill_no'],
            'trn_date'        => $pay_bill_data['trn_date'],
            'amount'          => $pay_bill_data['total'],
            'type'            => $pay_bill_data['type'],
            'particulars'     => $pay_bill_data['particulars'],
            'attachments'     => $pay_bill_data['attachments'],
            'status'          => $pay_bill_data['status'],
            'created_at'      => $pay_bill_data['created_at'],
            'created_by'      => $pay_bill_data['created_by'],
            'updated_at'      => $pay_bill_data['updated_at'],
            'updated_by'      => $pay_bill_data['updated_by'],
        ), array(
            'voucher_no'      => $pay_bill_id
        ) );

        $items = $pay_bill_data['bill_details'];

        foreach ( $items as $key => $item ) {
            $wpdb->update( $wpdb->prefix . 'erp_acct_pay_bill_details', array(
                'bill_no'     => $item['id'],
                'amount'      => $item['amount'],
                'created_at'  => $pay_bill_data['created_at'],
                'created_by'  => $pay_bill_data['created_by'],
                'updated_at'  => $pay_bill_data['updated_at'],
                'updated_by'  => $pay_bill_data['updated_by'],
            ), array(
                'voucher_no'  => $pay_bill_id
            ) );

            erp_acct_update_bill_data_into_ledger( $pay_bill_data, $pay_bill_id, $item );
        }

        $wpdb->update( $wpdb->prefix . 'erp_acct_bill_account_details', array(
            'bill_no'     => $pay_bill_id,
            'particulars' => $pay_bill_data['particulars'],
            'debit'       => 0,
            'credit'      => $pay_bill_data['amount'],
            'created_at'  => $pay_bill_data['created_at'],
            'created_by'  => $pay_bill_data['created_by'],
            'updated_at'  => $pay_bill_data['updated_at'],
            'updated_by'  => $pay_bill_data['updated_by'],
        ), array(
            'trn_no'      => $pay_bill_id
        ) );

        $wpdb->query( 'COMMIT' );

    } catch (Exception $e) {
        $wpdb->query( 'ROLLBACK' );
        return new WP_error( 'bill-exception', $e->getMessage() );
    }

    return $pay_bill_id;

}

/**
 * Delete a pay_bill
 *
 * @param $id
 * @return void
 */
function erp_acct_delete_pay_bill( $id ) {
    global $wpdb;

    if ( !$id ) {
        return;
    }

    $wpdb->delete( $wpdb->prefix . 'erp_acct_pay_bill', array( 'ID' => $id ) );
}

/**
 * Void a pay_bill
 *
 * @param $id
 * @return void
 */
function erp_acct_void_pay_bill( $id ) {
    global $wpdb;

    if ( !$id ) {
        return;
    }

    $wpdb->update($wpdb->prefix . 'erp_acct_pay_bill',
        array(
            'status' => 'void',
        ),
        array( 'voucher_no' => $id )
    );
}

/**
 * Get formatted pay_bill data
 *
 * @param $data
 * @param $voucher_no
 *
 * @return mixed
 */
function erp_acct_get_formatted_pay_bill_data( $data, $voucher_no ) {
    $pay_bill_data = [];

    $pay_bill_data['voucher_no']   = ! empty( $voucher_no ) ? $voucher_no : 0;
    $pay_bill_data['trn_no']       = ! empty( $voucher_no ) ? $voucher_no : 0;
    $pay_bill_data['vendor_id']    = isset( $data['vendor_id'] ) ? $data['vendor_id'] : 1;
    $pay_bill_data['trn_date']     = isset( $data['date'] ) ? $data['date'] : date( "Y-m-d" );
    $pay_bill_data['amount']       = isset( $data['amount'] ) ? $data['amount'] : 0;
    $pay_bill_data['ref']          = isset( $data['ref'] ) ? $data['ref'] : 0;
    $pay_bill_data['trn_by']       = isset( $data['trn_by'] ) ? $data['trn_by'] : 0;
    $pay_bill_data['particulars']  = isset( $data['particulars'] ) ? $data['particulars'] : '';
    $pay_bill_data['attachments']  = isset( $data['attachments'] ) ? $data['attachments'] : '';
    $pay_bill_data['bill_details'] = isset( $data['bill_details'] ) ? $data['bill_details'] : '';
    $pay_bill_data['status']       = isset( $data['status'] ) ? $data['status'] : 1;
    $pay_bill_data['created_at']   = date( "Y-m-d" );
    $pay_bill_data['created_by']   = isset( $data['created_by'] ) ? $data['created_by'] : '';
    $pay_bill_data['updated_at']   = isset( $data['updated_at'] ) ? $data['updated_at'] : '';
    $pay_bill_data['updated_by']   = isset( $data['updated_by'] ) ? $data['updated_by'] : '';

    return $pay_bill_data;
}

/**
 * Insert pay_bill/s data into ledger
 *
 * @param array $pay_bill_data
 * @param array $item_data
 *
 * @return mixed
 */
function erp_acct_insert_pay_bill_data_into_ledger( $pay_bill_data, $item_data ) {
    global $wpdb;

    // Insert amount in ledger_details
    $wpdb->insert( $wpdb->prefix . 'erp_acct_ledger_details', array(
        'ledger_id'   => $item_data['ledger_id'],
        'trn_no'      => $pay_bill_data['trn_no'],
        'particulars' => $pay_bill_data['particulars'],
        'debit'       => $item_data['amount'],
        'credit'      => 0,
        'trn_date'    => $pay_bill_data['trn_date'],
        'created_at'  => $pay_bill_data['created_at'],
        'created_by'  => $pay_bill_data['created_by'],
        'updated_at'  => $pay_bill_data['updated_at'],
        'updated_by'  => $pay_bill_data['updated_by'],
    ) );

}

/**
 * Update pay_bill/s data into ledger
 *
 * @param array $pay_bill_data
 * * @param array $pay_bill_no
 * @param array $item_data
 *
 * @return mixed
 */
function erp_acct_update_pay_bill_data_into_ledger( $pay_bill_data, $pay_bill_no, $item_data ) {
    global $wpdb;

    // Update amount in ledger_details
    $wpdb->update( $wpdb->prefix . 'erp_acct_ledger_details', array(
        'ledger_id'   => $item_data['ledger_id'],
        'particulars' => $pay_bill_data['particulars'],
        'debit'       => $item_data['amount'],
        'credit'      => 0,
        'trn_date'    => $pay_bill_data['trn_date'],
        'created_at'  => $pay_bill_data['created_at'],
        'created_by'  => $pay_bill_data['created_by'],
        'updated_at'  => $pay_bill_data['updated_at'],
        'updated_by'  => $pay_bill_data['updated_by'],
    ), array(
        'trn_no' => $pay_bill_no,
    ) );

}

/**
 * Get Pay bills count
 *
 * @return int
 */
function erp_acct_get_pay_bill_count() {
    global $wpdb;

    $row = $wpdb->get_row( "SELECT COUNT(*) as count FROM " . $wpdb->prefix . "erp_acct_pay_bill" );

    return $row->count;
}

