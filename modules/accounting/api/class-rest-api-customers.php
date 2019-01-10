<?php
namespace WeDevs\ERP\Accounting\API;

use WP_REST_Server;
use WP_REST_Response;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Customers_Controller extends \WeDevs\ERP\API\REST_Controller {
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
    protected $rest_base = 'accounting/v1/customers';

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes() {
        register_rest_route( $this->namespace, '/' . $this->rest_base, [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_customers' ],
                'args'                => $this->get_collection_params(),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_view_customer' );
                },
            ],
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'create_customer' ],
                'args'                => $this->get_collection_params(),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_create_customer' );
                },
            ],
            'schema' => [ $this, 'get_item_schema' ],
        ] );

        register_rest_route( $this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_customer' ],
                'args'                => [
                    'context' => $this->get_context_param( [ 'default' => 'view' ] ),
                ],
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_view_customer' );
                },
            ],
            [
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => [ $this, 'update_customer' ],
                'args'                => $this->get_collection_params(),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_edit_customer' );
                },
            ],
            [
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => [ $this, 'delete_customer' ],
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_delete_customer' );
                },
            ],
            'schema' => [ $this, 'get_public_item_schema' ],
        ] );

        register_rest_route( $this->namespace, '/' . $this->rest_base . '/delete/(?P<ids>[\d,?]+)', [
            [
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => [ $this, 'bulk_delete_customers' ],
                'args'                => [
                    'ids'   => [ 'required' => true ]
                ],
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_delete_customer' );
                },
            ],
            'schema' => [ $this, 'get_public_item_schema' ],
        ] );

        register_rest_route( $this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)' . '/transactions', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_transactions' ],
                'args'                => $this->get_collection_params(),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_view_customer' );
                },
            ],
        ] );
        register_rest_route( $this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)' . '/transactions/filter', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'filter_transactions' ],
                'args'                => $this->get_collection_params(),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_view_customer' );
                },
            ],
        ] );

        register_rest_route( $this->namespace, '/' . $this->rest_base . '/country', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_countries' ],
                'args'                => $this->get_collection_params(),
                'permission_callback' => function ( $request ) {
                    return current_user_can( 'erp_ac_view_customer' );
                },
            ]
        ] );
    }

    /**
     * Get a collection of customers
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_customers( $request ) {
        $args = [
            'number' => $request['per_page'],
            'offset' => ( $request['per_page'] * ( $request['page'] - 1 ) ),
            'type'   => 'customer'
        ];

        $items       = erp_get_peoples( $args );
        $total_items = erp_get_peoples( [ 'type' => 'customer', 'count' => true ] );
        $total_items = is_array( $total_items ) ? count( $total_items ) : $total_items;

        $formatted_items = []; $additional_fields = [];

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        foreach ( $items as $item ) {
            if ( isset( $request['include'] ) ) {
                $include_params = explode( ',', str_replace( ' ', '', $request['include'] ) );

                if ( in_array( 'owner', $include_params ) ) {
                    $customer_owner_id = ( $item->user_id ) ? get_user_meta( $item->user_id, 'contact_owner', true ) : erp_people_get_meta( $item->id, 'contact_owner', true );

                    $item->owner = $this->get_user( $customer_owner_id );
                    $additional_fields = ['owner' => $item->owner];
                }
            }

            $data = $this->prepare_item_for_response( $item, $request, $additional_fields );
            $formatted_items[] = $this->prepare_response_for_collection( $data );
        }

        $response = rest_ensure_response( $formatted_items );
        $response = $this->format_collection_response( $response, $request, $total_items );

        $response->set_status( 200 );

        return $response;
    }

    /**
     * Get a specific customer
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_customer( $request ) {
        $id   = (int) $request['id'];
        $item = erp_get_people( $id );
        $item = (array) $item;

        if ( empty( $id ) || empty( $item['id'] ) ) {
            return new WP_Error( 'rest_customer_invalid_id', __( 'Invalid resource id.' ), [ 'status' => 404 ] );
        }

        $additional_fields = [];
        if ( isset( $request['include'] ) ) {
            $include_params = explode( ',', str_replace( ' ', '', $request['include'] ) );

            if ( in_array( 'owner', $include_params ) ) {
                $customer_owner_id = ( $item->user_id ) ? get_user_meta( $item->user_id, 'contact_owner', true ) : erp_people_get_meta( $item->id, 'contact_owner', true );

                $item->owner = $this->get_user( $customer_owner_id );
                $additional_fields = ['owner' => $item->owner];
            }
        }

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;
        $item  = $this->prepare_item_for_response( $item, $request, $additional_fields );
        $response = rest_ensure_response( $item );

        $response->set_status( 200 );

        return $response;
    }

    /**
     * Create a customer
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Request
     */
    public function create_customer( $request ) {

        if ( false != email_exists( $request['email'] ) ) {
            return new WP_Error( 'rest_customer_invalid_id', __( 'Email already exists!' ), [ 'status' => 400 ] );
        }

        $item = $this->prepare_item_for_database( $request );

        $id   = erp_insert_people( $item );

        $customer = (array) erp_get_people( $id );
        $customer['id'] = $id;

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $response = $this->prepare_item_for_response( $customer, $request, $additional_fields );
        $response = rest_ensure_response( $response );
        $response->set_status( 201 );

        return $response;
    }

    /**
     * Update a customer
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Request
     */
    public function update_customer( $request ) {
        $id = (int) $request['id'];

        $item = erp_get_people( $id );
        if ( ! $item ) {
            return new WP_Error( 'rest_customer_invalid_id', __( 'Invalid resource id.' ), [ 'status' => 400 ] );
        }

        $item = $this->prepare_item_for_database( $request );

        $id   = erp_insert_people( $item );

        $customer = (array) erp_get_people( $id );
        $customer['id'] = $id;

        $additional_fields['namespace'] = $this->namespace;
        $additional_fields['rest_base'] = $this->rest_base;

        $response = $this->prepare_item_for_response( $customer, $request, $additional_fields );
        $response = rest_ensure_response( $response );
        $response->set_status( 200 );

        return $response;
    }

    /**
     * Delete a customer
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Request
     */
    public function delete_customer( $request ) {
        $id = (int) $request['id'];

        $data = [
            'id'   => $id,
            'hard' => false,
            'type' => 'customer'
        ];

        erp_delete_people( $data );

        return new WP_REST_Response( true, 204 );
    }

    /**
     * Bulk Delete customers
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Request
     */
    public function bulk_delete_customers( $request ) {
        $ids = (string) $request['ids'];

        $data = [
            'id'   => explode(',' ,$ids),
            'hard' => false,
            'type' => 'customer'
        ];

        erp_delete_people( $data );

        return new WP_REST_Response( true, 204 );
    }

    /**
     * Get a collection of transactions
     *
     * @param WP_REST_Request $request
     *
     * @return WP_Error|WP_REST_Response
     */
    public function get_transactions( $request ) {
        $id = (int) $request['id'];

        $transactions = erp_acct_get_people_transactions( $id );

        return new WP_REST_Response( $transactions, 200 );
    }

    /**
     * Get countries
     *
     * @return object
     */
    public function get_countries( $request ) {
        $country    =   \WeDevs\ERP\Countries::instance();
        $c          =   $country->get_countries();
        $state      =   $country->get_states();
        $response   =   array(  'country' => $c, 'state' => $state );
        $response   =   rest_ensure_response( $response );
        return $response;
    }

    /**
     * Get transaction by date
     *
     * @param  object $request
     * @return array
     */
    public function filter_transactions( $request ) {
        $id         = $request['id'];
        $start_date = $request['start_date'];
        $end_date   = $request['end_date'];
        $args       = [
            'start_date' => $start_date,
            'end_date'   => $end_date
        ];
        $transactions   =   erp_people_filter_transaction( $id, $args );
        $response       =   rest_ensure_response( $transactions );

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
        // required arguments.
        if ( isset( $request['first_name'] ) ) {
            $prepared_item['first_name'] = $request['first_name'];
        }
        if ( isset( $request['last_name'] ) ) {
            $prepared_item['last_name'] = $request['last_name'];
        }
        if ( isset( $request['email'] ) ) {
            $prepared_item['email'] = $request['email'];
        }

        // optional arguments.
        if ( isset( $request['id'] ) ) {
            $prepared_item['id'] = absint( $request['id'] );
        }
        if ( isset( $request['phone'] ) ) {
            $prepared_item['phone'] = $request['phone'];
        }
        if ( isset( $request['website'] ) ) {
            $prepared_item['website'] = $request['website'];
        }
        if ( isset( $request['other'] ) ) {
            $prepared_item['other'] = $request['other'];
        }
        if ( isset( $request['notes'] ) ) {
            $prepared_item['notes'] = $request['notes'];
        }
        if ( isset( $request['street_1'] ) ) {
            $prepared_item['street_1'] = $request['street_1'];
        }
        if ( isset( $request['street_2'] ) ) {
            $prepared_item['street_2'] = $request['street_2'];
        }
        if ( isset( $request['city'] ) ) {
            $prepared_item['city'] = $request['city'];
        }
        if ( isset( $request['state'] ) ) {
            $prepared_item['state'] = $request['state']['id'];
        }
        if ( isset( $request['postal_code'] ) ) {
            $prepared_item['postal_code'] = $request['postal_code'];
        }
        if ( isset( $request['country'] ) ) {
            $prepared_item['country'] = $request['country']['id'];
        }
        if ( isset( $request['company'] ) ) {
            $prepared_item['company'] = $request['company'];
        }
        if ( isset( $request['mobile'] ) ) {
            $prepared_item['mobile'] = $request['mobile'];
        }
        if ( $request['fax'] ) {
            $prepared_item['fax'] = $request['fax'];
        }

        $prepared_item['type'] = 'customer';

        return $prepared_item;
    }

    /**
     * Prepare a single user output for response
     *
     * @param array|object $item
     * @param WP_REST_Request $request Request object.
     * @param array $additional_fields (optional)
     *
     * @return WP_REST_Response $response Response data.
     */
    public function prepare_item_for_response( $item, $request, $additional_fields = [] ) {
        $item = (object) $item;

        $data = [
            'id'          => (int) $item->id,
            'first_name'  => $item->first_name,
            'last_name'   => $item->last_name,
            'email'       => $item->email,
            'phone'       => $item->phone,
            'mobile'      => $item->mobile,
            'fax'         => $item->fax,
            'website'     => $item->website,
            'notes'       => $item->notes,
            'other'       => $item->other,
            'company'     => $item->company,
            'billing'     => [
                'first_name'    => $item->first_name,
                'last_name'     => $item->last_name,
                'street_1'      => $item->street_1,
                'street_2'      => $item->street_2,
                'city'          => $item->city,
                'state'         => $item->state,
                'postal_code'   => $item->postal_code,
                'country'       => $item->country,
                'email'         => $item->email,
                'phone'         => $item->phone
            ],
        ];

        $data = array_merge( $data, $additional_fields );

        // Wrap the data in a response object
        $response = rest_ensure_response( $data );

        $response = $this->add_links( $response, $item, $additional_fields );

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
            'title'      => 'customer',
            'type'       => 'object',
            'properties' => [
                'id'          => [
                    'description' => __( 'Unique identifier for the resource.' ),
                    'type'        => 'integer',
                    'context'     => [ 'embed', 'view', 'edit' ],
                    'readonly'    => true,
                ],
                'first_name'  => [
                    'description' => __( 'First name for the resource.' ),
                    'type'        => 'string',
                    'context'     => [ 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'last_name'   => [
                    'description' => __( 'Last name for the resource.' ),
                    'type'        => 'string',
                    'context'     => [ 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                    'required'    => true,
                ],
                'email'       => [
                    'description' => __( 'The email address for the resource.' ),
                    'type'        => 'string',
                    'format'      => 'email',
                    'context'     => [ 'edit' ],
                    'required'    => true,
                ],
                'phone'       => [
                    'description' => __( 'Phone for the resource.' ),
                    'type'        => 'string',
                    'context'     => [ 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'other'       => [
                    'description' => __( 'Other for the resource.' ),
                    'type'        => 'string',
                    'context'     => [ 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'website'         => [
                    'description' => __( 'Website of the resource.' ),
                    'type'        => 'string',
                    'format'      => 'uri',
                    'context'     => [ 'embed', 'view', 'edit' ],
                ],
                'notes'           => [
                    'description' => __( 'Notes of the resource.' ),
                    'type'        => 'string',
                    'context'     => [ 'embed', 'view', 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'billing'            => [
                    'description' => __( 'List of billing address data.', 'erp' ),
                    'type'        => 'object',
                    'context'     => [ 'view', 'edit' ],
                    'properties'  => [
                        'first_name' => [
                            'description' => __( 'First name.', 'erp' ),
                            'type'        => 'string',
                            'context'     => [ 'view', 'edit' ],
                        ],
                        'last_name'  => [
                            'description' => __( 'Last name.', 'erp' ),
                            'type'        => 'string',
                            'context'     => [ 'view', 'edit' ],
                        ],
                        'street_1'  => [
                            'description' => __( 'Address line 1', 'erp' ),
                            'type'        => 'string',
                            'context'     => [ 'view', 'edit' ],
                        ],
                        'street_2'  => [
                            'description' => __( 'Address line 2', 'erp' ),
                            'type'        => 'string',
                            'context'     => [ 'view', 'edit' ],
                        ],
                        'city'       => [
                            'description' => __( 'City name.', 'erp' ),
                            'type'        => 'string',
                            'context'     => [ 'view', 'edit' ],
                        ],
                        'state'      => [
                            'description' => __( 'ISO code or name of the state, province or district.', 'erp' ),
                            'type'        => 'string',
                            'context'     => [ 'view', 'edit' ],
                        ],
                        'postal_code'   => [
                            'description' => __( 'Postal code.', 'erp' ),
                            'type'        => 'string',
                            'context'     => [ 'view', 'edit' ],
                        ],
                        'country'    => [
                            'description' => __( 'ISO code of the country.', 'erp' ),
                            'type'        => 'string',
                            'context'     => [ 'view', 'edit' ],
                        ],
                        'email'       => [
                            'description' => __( 'The email address for the resource.' ),
                            'type'        => 'string',
                            'format'      => 'email',
                            'context'     => [ 'edit' ],
                        ],
                        'phone'       => [
                            'description' => __( 'Phone for the resource.' ),
                            'type'        => 'string',
                            'context'     => [ 'edit' ],
                        ],
                    ],
                ],
            ],
        ];


        return $schema;
    }
}
