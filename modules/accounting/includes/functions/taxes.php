<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Get all taxes
 *
 * @return mixed
 */

function erp_acct_get_all_tax_rates( $args = [] ) {
    global $wpdb;

    $defaults = [
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'tax.id',
        'order'      => 'ASC',
        'count'      => false,
        's'          => '',
    ];

    $args = wp_parse_args( $args, $defaults );

    $limit = '';

    if ( $args['number'] != '-1' ) {
        $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
    }

    $sql = "SELECT";
    $sql .= $args['count'] ? " COUNT( tax.id ) as total_number " : " tax.*, tax_rate_name.name ";
    $sql .= "FROM {$wpdb->prefix}erp_acct_taxes as tax
    LEFT JOIN {$wpdb->prefix}erp_acct_tax_rate_names AS tax_rate_name ON tax.tax_rate_id = tax_rate_name.id ORDER BY {$args['orderby']} {$args['order']} {$limit}";

    if ( $args['count'] ) {
        return $wpdb->get_var($sql);
    }

    return $wpdb->get_results( $sql, ARRAY_A );
}

/**
 * Get an single tax
 *
 * @param $tax_no
 *
 * @return mixed
 */

function erp_acct_get_tax_rate( $tax_no ) {
    global $wpdb;

    $sql = "SELECT

    tax.id,
    tax.tax_rate_id,
    tax.tax_number,
    tax.default,
    tax.created_at,
    tax.created_by,
    tax.updated_at,
    tax.updated_by,

    tax_item.tax_id,
    tax_item.component_name,
    tax_item.agency_id,
    tax_item.tax_cat_id

    FROM {$wpdb->prefix}erp_acct_taxes AS tax
    LEFT JOIN {$wpdb->prefix}erp_acct_tax_cat_agency AS tax_item ON tax.id = tax_item.tax_id

    WHERE tax.id = {$tax_no} LIMIT 1";

    $row = $wpdb->get_row( $sql, ARRAY_A );

    $row['tax_components'] = erp_acct_format_tax_line_items( $tax_no );

    for( $i = 0; $i < count( $row['tax_components'] ); $i++ ) {
        $row['tax_components'][$i]['agency'] = null; // we'll fill that later from VUE
        $row['tax_components'][$i]['category'] = null; // we'll fill that later from VUE

        $row['tax_components'][$i]['agency_name'] = erp_acct_get_tax_agency_by_id( $row['tax_components'][$i]['agency_id'] );
        $row['tax_components'][$i]['tax_cat_name'] = erp_acct_get_tax_category_by_id( $row['tax_components'][$i]['tax_cat_id'] );
    }

    return $row;
}

/**
 * Insert tax data
 *
 * @param $data
 * @return int
 */
function erp_acct_insert_tax_rate( $data ) {
    global $wpdb;

    $created_by = get_current_user_id();
    $data['created_at'] = date("Y-m-d H:i:s");
    $data['created_by'] = $created_by;

    $tax_data = erp_acct_get_formatted_tax_data( $data );

    $items = $data['tax_components'];

    if ( !empty( $tax_data['default'] ) && $tax_data['default'] ) {
        $sql = "UPDATE " . $wpdb->prefix . "erp_acct_taxes" . " SET `default`=0";
        $results = $wpdb->get_results( $sql );
    }

    $wpdb->insert($wpdb->prefix . 'erp_acct_taxes', array(
        'tax_rate_id'   => $tax_data['tax_rate_id'],
        'tax_number'    => $tax_data['tax_number'],
        'default'       => $tax_data['default'],
        'created_at'    => $tax_data['created_at'],
        'created_by'    => $tax_data['created_by'],
        'updated_at'    => $tax_data['updated_at'],
        'updated_by'    => $tax_data['updated_by'],
    ));

    $tax_id = $wpdb->insert_id;

    foreach ($items as $key => $item) {
        $wpdb->insert($wpdb->prefix . 'erp_acct_tax_cat_agency', array(
            'tax_id'         => $tax_id,
            'component_name' => $item['component_name'],
            'tax_cat_id'     => $item['tax_category_id'],
            'agency_id'      => $item['agency_id'],
            'tax_rate'       => $item['tax_rate'],
            'created_at'     => $tax_data['created_at'],
            'created_by'     => $tax_data['created_by'],
            'updated_at'     => $tax_data['updated_at'],
            'updated_by'     => $tax_data['updated_by'],
        ));

        $wpdb->insert($wpdb->prefix . 'erp_acct_tax_sales_tax_categories', array(
            'tax_id'                => $tax_id,
            'sales_tax_category_id' => $item['tax_category_id'],
            'tax_rate'              => $item['tax_rate'],
            'created_at'            => $tax_data['created_at'],
            'created_by'            => $tax_data['created_by'],
            'updated_at'            => $tax_data['updated_at'],
            'updated_by'            => $tax_data['updated_by'],
        ));
    }


    return $tax_id;

}

/**
 * Update tax data
 *
 * @param $data
 * @return int
 */
function erp_acct_update_tax_rate( $data, $id ) {
    global $wpdb;

    $updated_by = get_current_user_id();
    $data['updated_at'] = date("Y-m-d H:i:s");
    $data['updated_by'] = $updated_by;

    $tax_data = erp_acct_get_formatted_tax_data( $data );

    $wpdb->update($wpdb->prefix . 'erp_acct_taxes', array(
        'tax_rate_id' => $tax_data['tax_rate_id'],
        'tax_number' => $tax_data['tax_number'],
        'default'    => $tax_data['default'],
        'created_at' => $tax_data['created_at'],
        'created_by' => $tax_data['created_by'],
        'updated_at' => $tax_data['updated_at'],
        'updated_by' => $tax_data['updated_by'],
    ), array(
        'id' => $id
    ));

    if ( !empty( $tax_data['default'] ) && $tax_data['default'] ) {
        $sql = "UPDATE " . $wpdb->prefix . "erp_acct_taxes" . " SET `default`=0";
        $results = $wpdb->get_results( $sql );
    }

    $items = $data['tax_components'];

    foreach ($items as $key => $item) {
        $wpdb->update($wpdb->prefix . 'erp_acct_tax_cat_agency', array(
            'component_name' => $item['component_name'],
            'tax_cat_id'     => $item['tax_cat_id'],
            'agency_id'      => $item['agency_id'],
            'tax_rate'       => $item['tax_rate'],
            'created_at'     => $tax_data['created_at'],
            'created_by'     => $tax_data['created_by'],
            'updated_at'     => $tax_data['updated_at'],
            'updated_by'     => $tax_data['updated_by'],
        ), array(
            'tax_id' => $id
        ));

        $wpdb->update($wpdb->prefix . 'erp_acct_tax_sales_tax_categories', array(
            'sales_tax_category_id' => $item['tax_cat_id'],
            'tax_rate'              => $item['tax_rate'],
            'created_at' => $tax_data['created_at'],
            'created_by' => $tax_data['created_by'],
            'updated_at' => $tax_data['updated_at'],
            'updated_by' => $tax_data['updated_by'],
        ), array(
            'tax_id' => $id
        ));
    }

    return $id;

}


/**
 * Update tax data
 *
 * @param $data
 * @return int
 */
function erp_acct_quick_edit_tax_rate( $data, $id ) {
    global $wpdb;

    $updated_by = get_current_user_id();
    $data['updated_at'] = date("Y-m-d H:i:s");
    $data['updated_by'] = $updated_by;

    $tax_data = erp_acct_get_formatted_tax_data( $data );

    if ( !empty( $tax_data['default'] ) && $tax_data['default'] == 1  ) {
        $sql = "UPDATE " . $wpdb->prefix . "erp_acct_taxes" . " SET `default`=0";
        $results = $wpdb->get_results( $sql );
    }

    $wpdb->update($wpdb->prefix . 'erp_acct_taxes', array(
        'tax_number' => $tax_data['tax_number'],
        'default'    => $tax_data['default'],
        'updated_at' => $tax_data['updated_at'],
        'updated_by' => $tax_data['updated_by'],
    ), array(
        'id' => $id
    ));

    return $id;

}

/**
 * Update line item of a tax rate
 *
 * @param $data
 * @return int
 */
function erp_acct_edit_tax_rate_line( $data ) {
    global $wpdb;

    $updated_by = get_current_user_id();
    $data['updated_at'] = date("Y-m-d H:i:s");
    $data['updated_by'] = $updated_by;

    $tax_data = erp_acct_get_formatted_tax_line_data( $data );

    $wpdb->update($wpdb->prefix . 'erp_acct_tax_cat_agency', array(
        'component_name' => $tax_data['component_name'],
        'tax_cat_id'     => $tax_data['tax_cat_id'],
        'agency_id'      => $tax_data['agency_id'],
        'tax_rate'       => $tax_data['tax_rate'],
        'created_at'     => $tax_data['created_at'],
        'created_by'     => $tax_data['created_by'],
        'updated_at'     => $tax_data['updated_at'],
        'updated_by'     => $tax_data['updated_by'],
    ), array(
        'id' => $tax_data['db_id']
    ));

    return $tax_data['db_id'];

}

/**
 * Delete an tax
 *
 * @param $tax_no
 *
 * @return int
 */

function erp_acct_delete_tax_rate( $tax_no ) {
    global $wpdb;

    $wpdb->delete( $wpdb->prefix . 'erp_acct_taxes', array( 'id' => $tax_no ) );

    return $tax_no;
}

/**
 * Get all tax payments
 *
 * @return mixed
 */

function erp_acct_get_tax_pay_records( $args = [] ) {
    global $wpdb;

    $defaults = [
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'DESC',
        'count'      => false,
        's'          => '',
    ];

    $args = wp_parse_args( $args, $defaults );

    $limit = '';

    if ( $args['number'] != '-1' ) {
        $limit = "LIMIT {$args['number']} OFFSET {$args['offset']}";
    }

    $sql = "SELECT";
    $sql .= $args['count'] ? " COUNT( id ) as total_number " : " * ";
    $sql .= "FROM {$wpdb->prefix}erp_acct_tax_pay ORDER BY {$args['orderby']} {$args['order']} {$limit}";

    if ( $args['count'] ) {
        return $wpdb->get_var($sql);
    }

    return $wpdb->get_results( $sql, ARRAY_A );
}

/**
 * Make a tax payment
 *
 * @param $data
 * @return int
 */
function erp_acct_pay_tax( $data ) {
    global $wpdb;

    $created_by = get_current_user_id();
    $data['created_at'] = date('Y-m-d H:i:s');
    $data['created_by'] = $created_by;

    $wpdb->insert( $wpdb->prefix . 'erp_acct_voucher_no', array(
        'type'       => 'tax_payment',
        'created_at' => $data['created_at'],
        'created_by' => $data['created_by'],
        'updated_at' => isset( $data['updated_at'] ) ? $data['updated_at'] : null,
        'updated_by' => isset( $data['updated_by'] ) ? $data['updated_by'] : null
    ) );

    $voucher_no = $wpdb->insert_id;

    $tax_data = erp_acct_get_formatted_tax_data( $data );

    $wpdb->insert($wpdb->prefix . 'erp_acct_tax_pay', array(
        'voucher_no'   => $voucher_no,
        'trn_date'     => $tax_data['trn_date'],
        'particulars'  => $tax_data['particulars'],
        'amount'       => $tax_data['amount'],
        'voucher_type' => $tax_data['voucher_type'],
        'trn_by'       => $tax_data['trn_by'],
        'agency_id'    => $tax_data['agency_id'],
        'ledger_id'    => $tax_data['ledger_id'],
        'created_at'   => $tax_data['created_at'],
        'created_by'   => $tax_data['created_by'],
        'updated_at'   => $tax_data['updated_at'],
        'updated_by'   => $tax_data['updated_by'],
    ));

    // insert data into wp_erp_acct_tax_agency_details
    $wpdb->insert( $wpdb->prefix . 'erp_acct_tax_agency_details', [
        'agency_id'   => $tax_data['agency_id'],
        'trn_no'      => $voucher_no,
        'trn_date'    => $tax_data['trn_date'],
        'particulars' => $tax_data['particulars'],
        'debit'       => $tax_data['amount'],
        'credit'      => 0,
        'created_at'  => $tax_data['created_at'],
        'created_by'  => $tax_data['created_by']
    ] );

    $tax_data['voucher_no'] = $voucher_no;

    erp_acct_insert_tax_pay_data_into_ledger( $tax_data );

    return $voucher_no;

}

/**
 * Insert Tax pay data into ledger
 *
 * @param array $invoice_data
 *
 * @return mixed
 */
function erp_acct_insert_tax_pay_data_into_ledger( $tax_data ) {
    global $wpdb;

    // Insert amount in ledger_details
    $wpdb->insert( $wpdb->prefix . 'erp_acct_ledger_details', array(
        'ledger_id'   => $tax_data['ledger_id'],
        'trn_no'      => $tax_data['voucher_no'],
        'particulars' => $tax_data['particulars'],
        'debit'       => 0,
        'credit'      => $tax_data['amount'],
        'trn_date'    => $tax_data['trn_date'],
        'created_at'  => $tax_data['created_at'],
        'created_by'  => $tax_data['created_by'],
        'updated_at'  => $tax_data['updated_at'],
        'updated_by'  => $tax_data['updated_by'],
    ) );
}

/**
 * Format payment line items
 *
 * @param string $tax
 *
 * @return array
 */
function erp_acct_format_tax_line_items( $tax = 'all' ) {
    global $wpdb;

    $sql = "SELECT id as db_id, tax_id, component_name, agency_id, tax_cat_id, tax_rate ";

    if ( $tax == 'all' ) {
        $tax_sql = '';
    } else {
        $tax_sql = "WHERE tax_id = " .  $tax ;
    }
    $sql .= "FROM {$wpdb->prefix}erp_acct_tax_cat_agency {$tax_sql} ORDER BY tax_id";

    $results = $wpdb->get_results( $sql, ARRAY_A );

    return $results;
}

/**
 * Get formatted tax data
 *
 * @param $data
 * @param $voucher_no
 * @return mixed
 */
function erp_acct_get_formatted_tax_data( $data ) {
    $tax_data = [];

    $tax_data['tax_rate_id']     = isset($data['tax_rate_name']) ? $data['tax_rate_name'] : '';
    $tax_data['tax_number']      = isset($data['tax_number']) ? $data['tax_number'] : '';
    $tax_data['default']         = isset($data['default']) ? $data['default'] : 0;
    $tax_data['tax_rate']        = isset($data['tax_rate']) ? $data['tax_rate'] : 0;
    $tax_data['tax_id']          = isset($data['tax_id']) ? $data['tax_id'] : 0;
    $tax_data['trn_by']          = isset($data['trn_by']) ? $data['trn_by'] : '';
    $tax_data['tax_category_id'] = isset($data['tax_category_id']) ? $data['tax_category_id'] : 0;
    $tax_data['agency_id']       = isset($data['agency_id']) ? $data['agency_id'] : 0;
    $tax_data['agency_name']     = isset($data['agency_name']) ? $data['agency_name'] : '';
    $tax_data['tax_cat_name']    = isset($data['tax_cat_name']) ? $data['tax_cat_name'] : '';
    $tax_data['tax_components']  = isset($data['tax_components']) ? $data['tax_components'] : [];
    $tax_data['created_at']      = date('Y-m-d');
    $tax_data['created_by']      = isset($data['created_by']) ? $data['created_by'] : '';
    $tax_data['updated_at']      = isset($data['updated_at']) ? $data['updated_at'] : '';
    $tax_data['updated_by']      = isset($data['updated_by']) ? $data['updated_by'] : '';
    $tax_data['name']            = isset($data['name']) ? $data['name'] : '';
    $tax_data['description']     = isset($data['description']) ? $data['description'] : '';
    $tax_data['voucher_no']      = isset($data['voucher_no']) ? $data['voucher_no'] : '';
    $tax_data['trn_date']        = isset($data['trn_date']) ? $data['trn_date'] : date('Y-m-d');
    $tax_data['tax_period']      = isset($data['tax_period']) ? $data['tax_period'] : '';
    $tax_data['particulars']     = isset($data['particulars']) ? $data['particulars'] : '';
    $tax_data['amount']          = isset($data['amount']) ? $data['amount'] : '';
    $tax_data['ledger_id']       = isset($data['ledger_id']) ? $data['ledger_id'] : '';
    $tax_data['voucher_type']    = isset($data['voucher_type']) ? $data['voucher_type'] : '';

    return $tax_data;
}

/**
 * Get formatted tax data
 *
 * @param $data
 * @param $voucher_no
 * @return mixed
 */
function erp_acct_get_formatted_tax_line_data( $data ) {
    $tax_data = [];

    $tax_data['tax_id'] = isset($data['tax_id']) ? $data['tax_id'] : '';
    $tax_data['db_id'] = isset($data['db_id']) ? $data['db_id'] : '';
    $tax_data['rate_id'] = isset($data['rate_id']) ? $data['rate_id'] : '';
    $tax_data['component_name'] = isset($data['component_name']) ? $data['component_name'] : '';
    $tax_data['agency_id'] = isset($data['agency_id']) ? $data['agency_id'] : 0;
    $tax_data['tax_cat_id'] = isset($data['tax_cat_id']) ? $data['tax_cat_id'] : 0;
    $tax_data['tax_rate'] = isset($data['tax_rate']) ? $data['tax_rate'] : 0;
    $tax_data['created_at'] = isset($data['created_at']) ? $data['created_at'] : '';
    $tax_data['created_by'] = isset($data['created_by']) ? $data['created_by'] : '';

    return $tax_data;
}

/**
 * Tax summary
 */
function erp_acct_tax_summary() {
    global $wpdb;

    $sql = "SELECT
        tax.id AS tax_rate_id,
        tax.default,
        rate_name.name,

        sales_tax_category.sales_tax_category_id,
        sales_tax_category.tax_rate

        FROM {$wpdb->prefix}erp_acct_tax_sales_tax_categories AS sales_tax_category
        LEFT JOIN {$wpdb->prefix}erp_acct_tax_categories AS tax_category ON tax_category.id = sales_tax_category.sales_tax_category_id
        LEFT JOIN {$wpdb->prefix}erp_acct_tax_cat_agency AS cat_agency ON cat_agency.tax_cat_id = tax_category.id
        LEFT JOIN {$wpdb->prefix}erp_acct_taxes AS tax ON tax.id = sales_tax_category.tax_id
        LEFT JOIN {$wpdb->prefix}erp_acct_tax_rate_names AS rate_name ON rate_name.id = tax.tax_rate_id

        GROUP BY tax_rate_id, sales_tax_category_id";

    return $wpdb->get_results( $sql, ARRAY_A);
}
