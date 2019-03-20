<?php
namespace WeDevs\ERP\Accounting\API;

use WP_REST_Server;
use WP_REST_Response;
use WP_Error;

class Bank_Accounts_Controller extends \WeDevs\ERP\API\REST_Controller {
    /**
     * Endpoint namespace.
     *
     * @var string
     */
    protected $namespace = 'erp/v1';

    /**
     * Route base.
     *
     * @var string
     */
    protected $rest_base = 'accounting/v1/accounts';

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes() {
        register_rest_route( $this->namespace, '/' . $this->rest_base, [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_accounts' ],
                'args'                => $this->get_collection_params(),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_view_bank_accounts' );
                },
            ],
            'schema' => [ $this, 'get_public_item_schema' ],
        ] );

        register_rest_route( $this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_account' ],
                'args'                => [
                    'context' => $this->get_context_param( [ 'default' => 'view' ] ),
                ],
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_view_bank_accounts' );
                },
            ],
            [
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => [ $this, 'delete_account' ],
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_create_bank_transfer' );
                },
            ],
        ] );

        register_rest_route( $this->namespace, '/' . $this->rest_base . '/transfer', [
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'transfer_money' ],
                'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE ),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_create_bank_transfer' );
                },
            ],
        ] );

        register_rest_route( $this->namespace, '/' . $this->rest_base . '/list', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_transfer_list' ],
                'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::READABLE ),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_create_bank_transfer' );
                },
            ],
        ] );

        register_rest_route( $this->namespace, '/' . $this->rest_base . '/bank-accounts', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_bank_accounts' ],
                'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::READABLE ),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_view_bank_accounts' );
                },
            ],
        ] );

        register_rest_route( $this->namespace, '/' . $this->rest_base . '/cash-at-bank', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_cash_at_bank' ],
                'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::READABLE ),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_view_bank_accounts' );
                },
            ],
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'update_dashboard_accounts' ],
                'args'                => [],
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_create_bank_transfer' );
                },
            ],
        ] );

    }

    /**
     * Get a collection of accounts
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_accounts( $request ) {

        $items = erp_acct_get_transfer_accounts( true );

        $formatted_items = [];
        foreach ( $items as $item ) {
            $additional_fields = [];

            $data = $this->prepare_item_for_response( $item, $request, $additional_fields );
            $formatted_items[] = $this->prepare_response_for_collection( $data );
        }

        $response = rest_ensure_response( $formatted_items );
        $response = $this->format_collection_response( $response, $request, 0 );

        return $response;
    }

    /**
     * Get a specific account
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_account( $request ) {
        $id   = (int) $request['id'];
        $item = erp_acct_get_bank( $id );

        if ( empty( $id ) || empty( $item->id ) ) {
            return new WP_Error( 'rest_bank_account_invalid_id', __( 'Invalid resource id.' ), [ 'status' => 404 ] );
        }

        $item     = $this->prepare_item_for_response( $item, $request, [] );
        $response = rest_ensure_response( $item );

        return $response;
    }

    /**
     * Delete a specific account
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function delete_account( $request ) {
        $id   = (int) $request['id'];
        $item = erp_acct_delete_bank( $id );

        if ( empty( $id ) || empty( $item->id ) ) {
            return new WP_Error( 'rest_bank_account_invalid_id', __( 'Invalid resource id.' ), [ 'status' => 404 ] );
        }

        $item     = $this->prepare_item_for_response( $item, $request, [] );
        $response = rest_ensure_response( $item );

        return $response;
    }

    /**
     * Transfer money from one account to another
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Request
     */
    public function transfer_money( $request ) {
        $item = $this->prepare_item_for_database( $request );

        if ( empty( $item['from_account_id'] ) || empty( $item['to_account_id'] ) ) {
            return new WP_Error( 'rest_transfer_invalid_accounts', __( 'Both accounts should be present.' ), [ 'status' => 400 ] );
        }

        $ledger_details = erp_acct_get_balance_by_ledger( $item['from_account_id'] );
        if ( empty( $ledger_details ) ) {
            return new WP_Error( 'rest_transfer_invalid_account', __( 'Something Went Wrong! Account not found.' ), [ 'status' => 400 ] );
        }

        $from_balance = $ledger_details[0]['balance'];

        // if ( $from_balance < $item['amount'] ) {
        //     return new WP_Error( 'rest_transfer_insufficient_funds', __( 'Not enough money on selected transfer source.' ), [ 'status' => 400 ] );
        // }

        $id = erp_acct_perform_transfer( $item );

        if ( is_wp_error( $id ) ) {
            return $id;
        }

        return new WP_REST_Response( true, 201 );
    }

    /**
     * Get a list of transfers
     *
     * @param $request
     *
     * @return mixed|object|WP_REST_Response
     */
    public function get_transfer_list( $request ) {

        $args = [
            'order_by' => isset( $request['order_by'] ) ? $request['order_by'] : 'id',
            'order'    => isset( $request['order'] ) ? $request['order'] : 'DESC',
            'number'   => isset( $request['per_page'] ) ? $request['per_page'] : 20,
            'offset'   => ( $request['per_page'] * ( $request['page'] - 1 ) )
        ];

        $items = erp_acct_get_transfer_vouchers( $args );
        $accounts = erp_acct_get_transfer_accounts();
        $accounts = wp_list_pluck( $accounts, 'name', 'id' );

        $formatted_items = [];
        foreach ( $items as $item ) {
            $additional_fields = [];

            $data = $this->prepare_list_item_for_response( $item, $request, $additional_fields, $accounts );
            $formatted_items[] = $this->prepare_response_for_collection( $data );
        }

        $response = rest_ensure_response( $formatted_items );
        $response = $this->format_collection_response( $response, $request, 0 );

        return $response;
    }

    /**
     * Get a collection of bank accounts
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_bank_accounts( $request ) {
        $items = erp_acct_get_banks( true, true, false );

        if ( empty( $items ) ) {
            return new WP_Error( 'rest_empty_accounts', __( 'Bank accounts are empty.' ), [ 'status' => 204 ] );
        }

        foreach ( $items as $item ) {
            $additional_fields = [];

            $data = $this->prepare_bank_item_for_response( $item, $request, $additional_fields );
            $formatted_items[] = $this->prepare_response_for_collection( $data );
        }

        $response = rest_ensure_response( $formatted_items );
        $response = $this->format_collection_response( $response, $request, 0 );

        return $response;
    }

    /**
     * Get dashboard bank accounts
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_cash_at_bank( $request ) {
        $items = erp_acct_get_dashboard_banks();

        if ( empty( $items ) ) {
            return new WP_Error( 'rest_empty_accounts', __( 'Bank accounts are empty.' ), [ 'status' => 204 ] );
        }

        foreach ( $items as $item ) {
            $additional_fields = [];

            $data = $this->prepare_bank_item_for_response( $item, $request, $additional_fields );
            $formatted_items[] = $this->prepare_response_for_collection( $data );
        }

        $response = rest_ensure_response( $formatted_items );
        $response = $this->format_collection_response( $response, $request, 0 );

        return $response;
    }

    /**
     * Update dashboard bank accounts
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function update_dashboard_accounts( $request ) {
        global $wpdb;

        $wpdb->query('TRUNCATE TABLE ' . $wpdb->prefix . 'erp_acct_cash_at_banks');

        $items = $request['accounts']; $formatted_items = [];

        if ( empty( $items ) ) {
            return new WP_Error( 'rest_empty_accounts', __( 'Bank accounts are empty.' ), [ 'status' => 204 ] );
        }

        foreach ( $items as $item ) {
            $additional_fields = [];

            $wpdb->insert( $wpdb->prefix . 'erp_acct_cash_at_banks', array(
                'ledger_id' => $item['ledger_id'],
                'name'      => $item['name'],
                'balance'   => $item['balance'],
            ));

            $data = $this->prepare_dashboard_item_for_response( $item, $request, $additional_fields );
            $formatted_items[] = $this->prepare_response_for_collection( $data );
        }

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $response = rest_ensure_response( $formatted_items );
        $response->set_status( 201 );

        return $response;
    }

    /**
     * Prepare a single item for create or update
     *
     * @param WP_REST_Request $request Request object.
     *
     * @return array $prepared_item
     */
    protected function prepare_item_for_database( $request ) {
        $prepared_item = [];

        $prepared_item['date']            = date( 'Y-m-d', strtotime( $request['date'] ) );
        $prepared_item['from_account_id'] = isset( $request['from_account_id'] ) ? intval( $request['from_account_id'] ) : 0;
        $prepared_item['to_account_id']   = isset( $request['to_account_id'] ) ?intval( $request['to_account_id'] ) : 0;
        $prepared_item['amount']          = isset( $request['amount'] ) ? floatval( $request['amount'] ) : 0;
        $prepared_item['particulars']     = isset( $request['particulars'] ) ? sanitize_text_field( $request['particulars'] ) : '';

        return $prepared_item;
    }

    /**
     * Prepare a single account output for response
     *
     * @param object $item
     * @param WP_REST_Request $request Request object.
     * @param array $additional_fields (optional)
     *
     * @return WP_REST_Response $response Response data.
     */
    public function prepare_item_for_response( $item, $request, $additional_fields = [] ) {
        $item = (object) $item;

        $data = [
            'id'             => (int) $item->ledger_id,
//            'code'           => (int) $item->code,
            'name'           => $item->name,
//            'description'    => $item->description,
//            'account_number' => isset( $item->bank_details['account_number'] ) ? $item->bank_details['account_number']: '',
//            'balance'        => erp_acct_get_single_account_balance( intval( $item->id ) ),
            'balance'        => $item->balance,
        ];

        if ( isset( $request['include'] ) ) {
            $include_params = explode( ',', str_replace( ' ', '', $request['include'] ) );

            if ( in_array( 'created_by', $include_params ) ) {
                $data['created_by'] = $this->get_user( intval( $item->created_by ) );
            }
        }

        $data = array_merge( $data, $additional_fields );

        // Wrap the data in a response object
        $response = rest_ensure_response( $data );

        return $response;
    }

    /**
     * Prepare a single dashboard output for response
     *
     * @param object $item
     * @param WP_REST_Request $request Request object.
     * @param array $additional_fields (optional)
     *
     * @return WP_REST_Response $response Response data.
     */
    public function prepare_dashboard_item_for_response( $item, $request, $additional_fields = [] ) {

        if ( isset( $request['include'] ) ) {
            $include_params = explode( ',', str_replace( ' ', '', $request['include'] ) );

            if ( in_array( 'created_by', $include_params ) ) {
                $data['created_by'] = $this->get_user( intval( $item->created_by ) );
            }
        }

        $data = array_merge( $item, $additional_fields );

        // Wrap the data in a response object
        $response = rest_ensure_response( $data );

        return $response;
    }

    /**
     * @param $item
     * @param $request
     * @param $additional_fields
     * @param $accounts
     * @return mixed|WP_REST_Response
     */
    public function prepare_list_item_for_response(  $item, $request, $additional_fields, $accounts ){
        $item = (object) $item;

        $data = [
            'voucher'  => (int) $item->voucher_no,
            'ac_from'  => $accounts[$item->ac_from],
            'ac_to'    => $accounts[$item->ac_to],
            'trn_date' => $item->trn_date,
            'amount'   => $item->amount,
            'created_by' => $this->get_user(1)
        ];

        if ( isset( $request['include'] ) ) {
            $include_params = explode( ',', str_replace( ' ', '', $request['include'] ) );

            if ( in_array( 'created_by', $include_params ) ) {
                $data['created_by'] = $this->get_user( intval( $item->created_by ) );
            }
        }

        $data = array_merge( $data, $additional_fields );

        // Wrap the data in a response object
        $response = rest_ensure_response( $data );

        return $response;
    }

    /**
     * @param $item
     * @param $request
     * @param $additional_fields
     * @return mixed|WP_REST_Response
     */
    public function prepare_bank_item_for_response(  $item, $request, $additional_fields ){
        $data = array_merge( $item, $additional_fields );

        // Wrap the data in a response object
        $response = rest_ensure_response( $data );

        return $response;
    }

    /**
     * Get the User's schema, conforming to JSON Schema
     *
     * @return array
     */
    public function get_item_schema() {
        $schema = [
            '$schema'    => 'http://json-schema.org/draft-04/schema#',
            'title'      => 'bank account',
            'type'       => 'object',
            'properties' => [
                'id'              => [
                    'description' => __( 'Unique identifier for the resource.' ),
                    'type'        => 'integer',
                    'context'     => [ 'embed', 'view', 'edit' ],
                    'readonly'    => true,
                ],
                'date'            => [
                    'description' => __( 'Date for the resource.' ),
                    'type'        => 'string',
                    'context'     => [ 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'from_account_id' => [
                    'description' => __( 'From account id for the resource.' ),
                    'type'        => 'integer',
                    'context'     => [ 'edit' ],
                    'required'    => true,
                ],
                'to_account_id'   => [
                    'description' => __( 'To account id for the resource.' ),
                    'type'        => 'integer',
                    'context'     => [ 'edit' ],
                    'required'    => true,
                ],
                'amount'          => [
                    'description' => __( 'Amount for the resource.' ),
                    'type'        => 'integer',
                    'context'     => [ 'edit' ],
                    'required'    => true,
                ],
                'particulars'            => [
                    'description' => __( 'Particulars for the resource.' ),
                    'type'        => 'string',
                    'context'     => [ 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
            ],
        ];

        return $schema;
    }
}
