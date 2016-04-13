<?php
/**
 * This is a file for peoples API
 *
 * Across the WP-ERP ecosystem, we will need various type of users who are not
 * actually WordPress users. In CRM, Accounting and many other parts, we will
 * need customers, clients, companies, vendors and many such type of users. This
 * is basically a unified way of letting every other components to use the same
 * functionality.
 *
 * Also we are taking advantange of WordPress metadata API to handle various
 * unknown types of data using the meta_key/meta_value system.
 */

/**
 * Get all peoples
 *
 * @since 1.0
 *
 * @param $args array
 *
 * @return array
 */
function erp_get_peoples( $args = [] ) {
    global $wpdb;

    $defaults = [
        'type'       => 'all',
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
        'trashed'    => false,
        'meta_query' => [],
        'count'      => false,
        'include'    => [],
        'exclude'    => []
    ];

    $args        = wp_parse_args( $args, $defaults );
    $people_type = is_array( $args['type'] ) ? implode( '-', $args['type'] ) : $args['type'];
    $cache_key   = 'erp-people-' . $people_type . '-' . md5( serialize( $args ) );
    $items       = wp_cache_get( $cache_key, 'erp' );

    if ( false === $items ) {
        $people = new WeDevs\ERP\Framework\Models\People();

        // Check if want all data without any pagination
        if ( ( $args['number'] != '-1' ) && ! $args['count'] ) {
            $people = $people->skip( $args['offset'] )->take( $args['number'] );
        }

        // Check if meta query apply
        if ( ! empty( $args['meta_query'] ) ) {

            $people_tb = $wpdb->prefix . 'erp_peoples';
            $peoplemeta_tb = $wpdb->prefix . 'erp_peoplemeta';

            $meta_key = isset( $args['meta_query']['meta_key'] ) ? $args['meta_query']['meta_key'] : '';
            $meta_value = isset( $args['meta_query']['meta_value'] ) ? $args['meta_query']['meta_value'] : '';
            $compare = isset( $args['meta_query']['compare'] ) ? $args['meta_query']['compare'] : '=';

            $people = $people->leftjoin( $peoplemeta_tb, $people_tb . '.id', '=', $peoplemeta_tb . '.erp_people_id' )->select( array( $people_tb . '.*', $peoplemeta_tb . '.meta_key', $peoplemeta_tb . '.meta_value' ) )
                        ->where( $peoplemeta_tb . '.meta_key', $meta_key )
                        ->where( $peoplemeta_tb . '.meta_value', $compare, $meta_value );
        }

        // Check if render only soft deleted row
        if ( $args['trashed'] ) {
            $people = $people->onlyTrashed();
        }

        // Check is the row want to search
        if ( isset( $args['s'] ) && ! empty( $args['s'] ) ) {
            $arg_s = $args['s'];
            $people = $people->where( 'first_name', 'LIKE', "%$arg_s%" )
                    ->orWhere( 'last_name', 'LIKE', "%$arg_s%" )
                    ->orWhere( 'company', 'LIKE', "%$arg_s%" );
        }

        $people = apply_filters( 'erp_people_query_object', $people );

        // Render all collection of data according to above filter (Main query)
        $items = $people->type( $args['type'] )
                ->orderBy( $args['orderby'], $args['order'] )
                ->get()
                ->toArray();

        $items = erp_array_to_object( $items );

        // Check if args count true, then return total count customer according to above filter
        if ( $args['count'] ) {
            $items = $people->type( $args['type'] )->count();
        }

        wp_cache_set( $cache_key, $items, 'erp' );
    }

    return $items;
}

/**
 * Get peoples by a given field
 *
 * @since 1.0
 *
 * @param  string $field
 * @param  mixed  $value
 *
 * @return array
 */
function erp_get_peoples_by( $field, $value ) {
    if ( is_array( $value ) ) {
        $peoples = WeDevs\ERP\Framework\Models\People::whereIn( $field, $value )->get()->toArray();
    } else {
        $peoples = WeDevs\ERP\Framework\Models\People::where( $field, $value )->get()->toArray();
    }

    return $peoples;
}

/**
 * Get users as array
 *
 * @since 1.0
 *
 * @param  array   $args
 *
 * @return array
 */
function erp_get_peoples_array( $args = [] ) {
    $users   = [];
    $peoples = erp_get_peoples( $args );

    foreach ( $peoples as $user ) {
        $users[ $user->id ] = ( 'company' == $user->type ) ? $user->company : $user->first_name . ' ' . $user->last_name;
    }

    return $users;
}

/**
 * Fetch people count from database
 *
 * @since 1.0
 *
 * @param string $type
 *
 * @return int
 */
function erp_get_peoples_count( $type = 'contact' ) {
    $cache_key = 'erp-people-count-' . $type;
    $count     = wp_cache_get( $cache_key, 'erp' );

    if ( false === $count ) {
        $count = WeDevs\ERP\Framework\Models\People::type( $type )->count();

        wp_cache_set( $cache_key, $count, 'erp' );
    }

    return intval( $count );
}

/**
 * Fetch a single people from database
 *
 * @since 1.0
 *
 * @param int   $id
 *
 * @return array
 */
function erp_get_people( $id = 0 ) {
    $cache_key = 'erp-people-single-' . $id;
    $people    = wp_cache_get( $cache_key, 'erp' );

    if ( false === $people ) {
        $peep = WeDevs\ERP\Framework\Models\People::withTrashed()->find( $id );

        if ( $peep->id ) {
            $people = (object) $peep->toArray();

            // include meta fields
            $people->date_of_birth = erp_people_get_meta( $id, 'date_of_birth', true );
            $people->source = erp_people_get_meta( $id, 'source', true );

            wp_cache_set( $cache_key, $people, 'erp' );
        }
    }

    return $people;
}

/**
 * Insert a new people
 *
 * @param array $args
 *
 * @return mixed integer on success, false otherwise
 */
function erp_insert_people( $args = array() ) {

    $defaults = array(
        'id'          => null,
        'first_name'  => '',
        'last_name'   => '',
        'email'       => '',
        'company'     => '',
        'phone'       => '',
        'mobile'      => '',
        'other'       => '',
        'website'     => '',
        'fax'         => '',
        'notes'       => '',
        'street_1'    => '',
        'street_2'    => '',
        'city'        => '',
        'state'       => '',
        'postal_code' => '',
        'country'     => '',
        'currency'    => '',
        'type'        => '',
        'user_id'     => null,
    );

    $args = wp_parse_args( $args, $defaults );

    if ( $args['type'] == 'contact' ) {
        if ( empty( $args['user_id'] ) ) {
            // some basic validation
            // Check if contact first name and last name provide or not
            if ( empty( $args['first_name'] ) ) {
                return new WP_Error( 'no-first_name', __( 'No First Name provided.', 'erp' ) );
            }
            if ( empty( $args['last_name'] ) ) {
                return new WP_Error( 'no-last_name', __( 'No Last Name provided.', 'erp' ) );
            }
        }
    }

    // Check if company name provide or not
    if ( $args['type'] == 'company' ) {
        if ( empty( $args['company'] ) ) {
            return new WP_Error( 'no-company', __( 'No Company Name provided.', 'erp' ) );
        }
    }

    // remove row id to determine if new or update
    $row_id = (int) $args['id'];
    unset( $args['id'] );

    if ( ! $row_id ) {

        $args['created'] = current_time( 'mysql' );

        // insert a new
        $people = WeDevs\ERP\Framework\Models\People::create( $args );

        do_action( 'erp_create_new_people', $people->id, $args );

        if ( $people->id ) {
            return $people->id;
        }

    } else {

        // do update method here
        WeDevs\ERP\Framework\Models\People::find( $row_id )->update( $args );

        do_action( 'erp_update_people', $row_id, $args );

        return $row_id;
    }

    return false;
}

/**
 * Add meta data field to a people.
 *
 * @since 1.0
 *
 * @param int    $people_id  People id.
 * @param string $meta_key   Metadata name.
 * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
 * @param bool   $unique     Optional. Whether the same key should not be added.
 *                           Default false.
 *
 * @return int|false Meta id on success, false on failure.
 */
function erp_people_add_meta( $people_id, $meta_key, $meta_value, $unique = false ) {
    return add_metadata( 'erp_people', $people_id, $meta_key, $meta_value, $unique);
}

/**
 * Retrieve people meta field for a people.
 *
 * @since 1.0
 *
 * @param int    $people_id People id.
 * @param string $key     Optional. The meta key to retrieve. By default, returns
 *                        data for all keys. Default empty.
 * @param bool   $single  Optional. Whether to return a single value. Default false.
 *
 * @return mixed Will be an array if $single is false. Will be value of meta data
 *               field if $single is true.
 */
function erp_people_get_meta( $people_id, $key = '', $single = false ) {
    return get_metadata( 'erp_people', $people_id, $key, $single);
}

/**
 * Update people meta field based on people id.
 *
 * Use the $prev_value parameter to differentiate between meta fields with the
 * same key and people id.
 *
 * If the meta field for the people does not exist, it will be added.
 *
 * @since 1.0
 *
 * @param int    $people_id  People id.
 * @param string $meta_key   Metadata key.
 * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
 * @param mixed  $prev_value Optional. Previous value to check before removing.
 *                           Default empty.
 *
 * @return int|bool Meta id if the key didn't exist, true on successful update,
 *                  false on failure.
 */
function erp_people_update_meta( $people_id, $meta_key, $meta_value, $prev_value = '' ) {
    return update_metadata( 'erp_people', $people_id, $meta_key, $meta_value, $prev_value );
}

/**
 * Remove metadata matching criteria from a people.
 *
 * You can match based on the key, or key and value. Removing based on key and
 * value, will keep from removing duplicate metadata with the same key. It also
 * allows removing all metadata matching key, if needed.
 *
 * @since 1.0
 *
 * @param int    $people_id  People id.
 * @param string $meta_key   Metadata name.
 * @param mixed  $meta_value Optional. Metadata value. Must be serializable if
 *                           non-scalar. Default empty.
 *
 * @return bool True on success, false on failure.
 */
function erp_people_delete_meta( $people_id, $meta_key, $meta_value = '' ) {
    return delete_metadata( 'erp_people', $people_id, $meta_key, $meta_value);
}

/**
 * Get the contact sources
 *
 * @return array
 */
function erp_crm_contact_sources() {
    $sources = array(
        'advert' => 'Advertisement',
        'chat' => 'Chat',
        'contact_form' => 'Contact Form',
        'employee_referral' => 'Employee Referral',
        'external_referral' => 'External Referral',
        'marketing_campaign' => 'Marketing campaign',
        'newsletter' => 'Newsletter',
        'online_store' => 'OnlineStore',
        'optin_form' => 'Optin Forms',
        'partner' => 'Partner',
        'phone' => 'Phone Call',
        'public_relations' => 'Public Relations',
        'sales_mail_alias' => 'Sales Mail Alias',
        'search_engine' => 'Search Engine',
        'seminar_internal' => 'Seminar-Internal',
        'seminar_partner' => 'Seminar Partner',
        'social_media' => 'Social Media',
        'trade_show' => 'Trade Show',
        'web_download' => 'Web Download',
        'web_research' => 'Web Research',
    );

    return apply_filters( 'erp_crm_contact_sources', $sources );
}
