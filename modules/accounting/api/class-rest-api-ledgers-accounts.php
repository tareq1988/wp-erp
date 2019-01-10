<?php
namespace WeDevs\ERP\Accounting\API;

use WP_REST_Server;
use WP_REST_Response;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Ledgers_Accounts_Controller extends \WeDevs\ERP\API\REST_Controller {
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
    protected $rest_base = 'accounting/v1/ledgers';

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes() {

        register_rest_route( $this->namespace, '/' . $this->rest_base, [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_all_ledger_accounts' ],
                'args'                => $this->get_collection_params(),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_view_account_lists' );
                },
            ],
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'create_ledger_account' ],
                'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE ),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_create_account' );
                },
            ],
            'schema' => [ $this, 'get_public_item_schema' ],
        ] );

        register_rest_route( $this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_ledger_account' ],
                'args'                => [
                    'context' => $this->get_context_param( [ 'default' => 'view' ] ),
                ],
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_view_single_account' );
                },
            ],
            [
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => [ $this, 'update_ledger_account' ],
                'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_edit_account' );
                },
            ],
            [
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => [ $this, 'delete_ledger_account' ],
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_delete_account' );
                },
            ],
            'schema' => [ $this, 'get_public_item_schema' ],
        ] );

        register_rest_route( $this->namespace, '/' . $this->rest_base . '/(?P<chart_id>[\d]+)' . '/accounts', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_ledger_accounts_by_chart' ],
                'args'                => $this->get_collection_params(),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_view_account_lists' );
                },
            ],
        ] );

        register_rest_route( $this->namespace, '/' . $this->rest_base . '/accounts', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_chart_accounts' ],
                'args'                => $this->get_collection_params(),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_view_account_lists' );
                },
            ],
        ] );
    }

    /**
     * Get all the ledgers of a particular chart_id
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_all_ledger_accounts( $request ) {
        global $wpdb;
        $chart_ids = [];

        $sql = "SELECT
            ledger.id,
            ledger.chart_id,
            ledger.category_id,
            ledger.name as ledger_name,
            ledger.code,
            ledger.system,

            chart_of_account.name as account_name

            FROM {$wpdb->prefix}erp_acct_ledgers AS ledger
            RIGHT JOIN {$wpdb->prefix}erp_acct_chart_of_accounts AS chart_of_account ON ledger.chart_id = chart_of_account.id";

        $ledgers = $wpdb->get_results( $sql, ARRAY_A );

        $response = rest_ensure_response( $ledgers );

        $response->set_status( 200 );

        return $response;
    }

    /**
     * Get all the ledgers of a particular chart_id
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_ledger_accounts_by_chart( $request ) {
        global $wpdb; $chart_ids = [];

        $chart_of_accs = $wpdb->get_results( 'SELECT `id` FROM `chart_of_accounts`', ARRAY_N );

        foreach ( $chart_of_accs as $chart_of_acc ) {
            $chart_ids[] = $chart_of_acc[0];
        }

        if ( empty( $request['chart_id'] ) || ( isset ( $request['chart_id'] ) && !in_array( $request['chart_id'], $chart_ids ) ) ) {
            return new WP_Error( 'rest_empty_chart_id', __( 'Chart ID is Empty.' ), [ 'status' => 400 ] );
        }

        $items = $wpdb->get_results( "SELECT * FROM ledgers WHERE chart_id ={$request['chart_id']} ORDER BY category_id ASC" );

        $result = array_map( function( $item ) {
            $item->id       = (int) $item->id;
            $item->category_id = (int) $item->category_id;

            return $item;
        }, $items );

        return new WP_REST_Response( $result );
    }

    /**
     * Get a specific ledger
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_ledger_account( $request ) {
        global $wpdb; $items = array();

        $id      = (int) $request['id'];

        if ( empty( $id ) ) {
            return new WP_Error( 'rest_ledger_invalid_id', __( 'Invalid resource id.' ), [ 'status' => 404 ] );
        }

        $results = $wpdb->get_results( 'SELECT * FROM `ledgers` WHERE `id`=' . $id . ' ORDER BY `category_id` ASC' );

        $item     = $this->prepare_item_for_response( $results[0], $request );
        $response = rest_ensure_response( $item );

        return $response;

    }

    /**
     * Create an ledger
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Request
     */
    public function create_ledger_account( $request ) {
        global $wpdb;

        $item = $this->prepare_item_for_database( $request );

        $result = $wpdb->insert( 'ledgers', array(
            'id'            => $item['id'],
            'chart_id'      => $item['chart_id'],
            'category_id'   => $item['category_id'],
            'name'          => $item['name'],
            'code'          => $item['code'],
            'system'        => $item['system'],
        ) );

        $id = $item['id'];

        $request->set_param( 'context', 'edit' );
        $response = $this->prepare_item_for_response( (object) $result, $request );
        $response = rest_ensure_response( $response );
        $response->set_status( 201 );
        $response->header( 'Location', rest_url( sprintf( '/%s/%s/%d', $this->namespace, $this->rest_base, $id ) ) );

        return $response;
    }

    /**
     * Update an ledger
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Request
     */
    public function update_ledger_account( $request ) {
        global $wpdb;

        $id = (int) $request['id'];

        if ( empty( $id ) ) {
            return new WP_Error( 'rest_ledger_invalid_id', __( 'Invalid resource id.' ), [ 'status' => 404 ] );
        }

        $item = $this->prepare_item_for_database( $request );

        $wpdb->update( 'ledgers', array(
            'chart_id'      => $item['chart_id'],
            'category_id'   => $item['category_id'],
            'name'          => $item['name'],
            'code'          => $item['code'],
            'system'        => $item['system']), array( 'id' => $id )
        );

        $request->set_param( 'context', 'edit' );
        $response = $this->prepare_item_for_response( (object) $item, $request );
        $response = rest_ensure_response( $response );
        $response->set_status( 201 );
        $response->header( 'Location', rest_url( sprintf( '/%s/%s/%d', $this->namespace, $this->rest_base, $id ) ) );

        return $response;
    }

    /**
     * Delete an account
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Request
     */
    public function delete_ledger_account( $request ) {
        global $wpdb;

        $id = (int) $request['id'];

        if ( empty( $id ) ) {
            return new WP_Error( 'rest_ledger_invalid_id', __( 'Invalid resource id.' ), [ 'status' => 404 ] );
        }

        $wpdb->delete( 'ledgers', array( 'id' => $id ) );

        return new WP_REST_Response( true, 204 );
    }

    /**
     * Get chart of accounts
     * 
     * @param WP_REST_REQUEST $request
     * 
     * @return WP_ERROR|WP_REST_REQUEST
     */
    public function get_chart_accounts( $request ) {
        $accounts  = erp_acct_get_all_charts( $args );
        
        $response = rest_ensure_response( $accounts );

        $response->set_status( 200 );

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

        $prepared_item['id']          = isset( $request['id'] ) ? (int) $request['id'] : 0;
        $prepared_item['chart_id']    = isset( $request['chart_id'] ) ? (int) $request['chart_id'] : '';
        $prepared_item['category_id'] = isset( $request['category_id'] ) ? (int) $request['category_id'] : '';
        $prepared_item['name']        = isset( $request['name'] ) ? $request['name'] : '';
        $prepared_item['code']        = isset( $request['code'] ) ? $request['code'] : '';
        $prepared_item['system']      = isset( $request['system'] ) ? (int) $request['system'] : 1;

        return $prepared_item;
    }

    /**
     * Prepare a single user output for response
     *
     * @param object $item
     * @param WP_REST_Request $request Request object.
     * @param array $additional_fields (optional)
     *
     * @return WP_REST_Response $response Response data.
     */
    public function prepare_item_for_response( $item, $request, $additional_fields = [] ) {
        $data = [
            'id'          => $item->id,
            'chart_id'    => $item->chart_id,
            'category_id' => $item->category_id,
            'name'        => $item->name,
            'code'        => $item->code,
            'system'      => $item->system
        ];

        $data = array_merge( $data, $additional_fields );

        // Wrap the data in a response object
        $response = rest_ensure_response( $data );

        $response = $this->add_links( $response, $item );

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
            'title'      => 'chart of account',
            'type'       => 'object',
            'properties' => [
                'id'          => [
                    'description' => __( 'Unique identifier for the resource.' ),
                    'type'        => 'integer',
                    'context'     => [ 'embed', 'view', 'edit' ],
                    'readonly'    => true,
                ],
                'chart_id'  => [
                    'description' => __( 'Type for the resource.' ),
                    'type'        => 'integer',
                    'context'     => [ 'edit' ],
                    'required'    => true,
                ],
                'category_id'  => [
                    'description' => __( 'Code for the resource.' ),
                    'type'        => 'integer',
                    'context'     => [ 'edit' ],
                    'required'    => true,
                ],
                'name'  => [
                    'description' => __( 'Name for the resource.' ),
                    'type'        => 'string',
                    'context'     => [ 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'code'  => [
                    'description' => __( 'Description for the resource.' ),
                    'type'        => 'string',
                    'context'     => [ 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'system'  => [
                    'description' => __( 'Description for the resource.' ),
                    'type'        => 'integer',
                    'context'     => [ 'edit' ]
                ],
            ],
        ];

        return $schema;
    }
}
