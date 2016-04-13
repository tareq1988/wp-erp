<?php

/**
 * Processes all ERP actions sent via REQUEST by looking for the 'erp-action'
 * request and running do_action() to call the function
 *
 * @return void
 */
function erp_process_actions() {
    if ( isset( $_REQUEST['erp-action'] ) ) {
        do_action( 'erp_action_' . $_REQUEST['erp-action'], $_REQUEST );
    }
}

/**
 * Return the WP ERP version
 *
 * @return string The WP ERP version
 */
function erp_get_version() {
    return wperp()->version;
}

/**
 * Maps various caps to built in WordPress caps
 *
 *
 * @param array $caps Capabilities for meta capability
 * @param string $cap Capability name
 * @param int $user_id User id
 * @param mixed $args Arguments
 */
function erp_map_meta_caps( $caps = array(), $cap = '', $user_id = 0, $args = array() ) {
    return apply_filters( 'erp_map_meta_caps', $caps, $cap, $user_id, $args );
}

/**
 * Get full list of currency codes.
 *
 * @return array
 */
function erp_get_currencies() {
    return array_unique( apply_filters( 'erp_currencies', array(
        'AED' => __( 'United Arab Emirates Dirham', 'erp' ),
        'AUD' => __( 'Australian Dollars', 'erp' ),
        'BDT' => __( 'Bangladeshi Taka', 'erp' ),
        'BRL' => __( 'Brazilian Real', 'erp' ),
        'BGN' => __( 'Bulgarian Lev', 'erp' ),
        'CAD' => __( 'Canadian Dollars', 'erp' ),
        'CLP' => __( 'Chilean Peso', 'erp' ),
        'CNY' => __( 'Chinese Yuan', 'erp' ),
        'COP' => __( 'Colombian Peso', 'erp' ),
        'CZK' => __( 'Czech Koruna', 'erp' ),
        'DKK' => __( 'Danish Krone', 'erp' ),
        'DOP' => __( 'Dominican Peso', 'erp' ),
        'DZD' => __( 'Algerian Dinar', 'erp' ),
        'EUR' => __( 'Euros', 'erp' ),
        'HKD' => __( 'Hong Kong Dollar', 'erp' ),
        'HRK' => __( 'Croatia kuna', 'erp' ),
        'HUF' => __( 'Hungarian Forint', 'erp' ),
        'ISK' => __( 'Icelandic krona', 'erp' ),
        'IDR' => __( 'Indonesia Rupiah', 'erp' ),
        'INR' => __( 'Indian Rupee', 'erp' ),
        'NPR' => __( 'Nepali Rupee', 'erp' ),
        'ILS' => __( 'Israeli Shekel', 'erp' ),
        'JPY' => __( 'Japanese Yen', 'erp' ),
        'KIP' => __( 'Lao Kip', 'erp' ),
        'KRW' => __( 'South Korean Won', 'erp' ),
        'MYR' => __( 'Malaysian Ringgits', 'erp' ),
        'MXN' => __( 'Mexican Peso', 'erp' ),
        'NGN' => __( 'Nigerian Naira', 'erp' ),
        'NOK' => __( 'Norwegian Krone', 'erp' ),
        'NZD' => __( 'New Zealand Dollar', 'erp' ),
        'PYG' => __( 'Paraguayan Guaraní', 'erp' ),
        'PHP' => __( 'Philippine Pesos', 'erp' ),
        'PLN' => __( 'Polish Zloty', 'erp' ),
        'GBP' => __( 'Pounds Sterling', 'erp' ),
        'RON' => __( 'Romanian Leu', 'erp' ),
        'RUB' => __( 'Russian Ruble', 'erp' ),
        'SGD' => __( 'Singapore Dollar', 'erp' ),
        'ZAR' => __( 'South African rand', 'erp' ),
        'SEK' => __( 'Swedish Krona', 'erp' ),
        'CHF' => __( 'Swiss Franc', 'erp' ),
        'TWD' => __( 'Taiwan New Dollars', 'erp' ),
        'THB' => __( 'Thai Baht', 'erp' ),
        'TRY' => __( 'Turkish Lira', 'erp' ),
        'USD' => __( 'US Dollars', 'erp' ),
        'VND' => __( 'Vietnamese Dong', 'erp' ),
        'EGP' => __( 'Egyptian Pound', 'erp' ),
    ) ) );
}

/**
 * Get full list of currency ISO with symbol label.
 *
 * @return array
 */
function erp_get_currency_list_with_symbol() {
    $currencies      = erp_get_currencies();
    $currency_symbol = [];

    foreach ( $currencies as $iso => $currency ) {
        $currency_symbol[$iso] = sprintf( '%1$s (%2$s)', $currency, erp_get_currency_symbol( $iso ) );
    }

    return $currency_symbol;
}

/**
 * [erp_get_currencies_dropdown description]
 *
 * @param  string  [description]
 *
 * @return string
 */
function erp_get_currencies_dropdown( $selected = '' ) {
    $options    = '';
    $currencies = erp_get_currencies();

    foreach ($currencies as $key => $value) {
        $select  = ( $key == $selected ) ? ' selected="selected"' : '';
        $options .= sprintf( "<option value='%s'%s>%s</option>\n", esc_attr( $key ), $select, $value );
    }

    return $options;
}

/**
 * Get Currency symbol.
 *
 * @param string $currency (default: '')
 * @return string
 */
function erp_get_currency_symbol( $currency = '' ) {

    switch ( $currency ) {
        case 'AED' :
            $currency_symbol = 'د.إ';
            break;
        case 'BDT':
            $currency_symbol = '&#2547;';
            break;
        case 'BRL' :
            $currency_symbol = '&#82;&#36;';
            break;
        case 'BGN' :
            $currency_symbol = '&#1083;&#1074;.';
            break;
        case 'AUD' :
        case 'CAD' :
        case 'CLP' :
        case 'COP' :
        case 'MXN' :
        case 'NZD' :
        case 'HKD' :
        case 'SGD' :
        case 'USD' :
            $currency_symbol = '&#36;';
            break;
        case 'EUR' :
            $currency_symbol = '&euro;';
            break;
        case 'CNY' :
        case 'RMB' :
        case 'JPY' :
            $currency_symbol = '&yen;';
            break;
        case 'RUB' :
            $currency_symbol = '&#1088;&#1091;&#1073;.';
            break;
        case 'KRW' : $currency_symbol = '&#8361;'; break;
            case 'PYG' : $currency_symbol = '&#8370;'; break;
        case 'TRY' : $currency_symbol = '&#8378;'; break;
        case 'NOK' : $currency_symbol = '&#107;&#114;'; break;
        case 'ZAR' : $currency_symbol = '&#82;'; break;
        case 'CZK' : $currency_symbol = '&#75;&#269;'; break;
        case 'MYR' : $currency_symbol = '&#82;&#77;'; break;
        case 'DKK' : $currency_symbol = 'kr.'; break;
        case 'HUF' : $currency_symbol = '&#70;&#116;'; break;
        case 'IDR' : $currency_symbol = 'Rp'; break;
        case 'INR' : $currency_symbol = 'Rs.'; break;
        case 'NPR' : $currency_symbol = 'Rs.'; break;
        case 'ISK' : $currency_symbol = 'Kr.'; break;
        case 'ILS' : $currency_symbol = '&#8362;'; break;
        case 'PHP' : $currency_symbol = '&#8369;'; break;
        case 'PLN' : $currency_symbol = '&#122;&#322;'; break;
        case 'SEK' : $currency_symbol = '&#107;&#114;'; break;
        case 'CHF' : $currency_symbol = '&#67;&#72;&#70;'; break;
        case 'TWD' : $currency_symbol = '&#78;&#84;&#36;'; break;
        case 'THB' : $currency_symbol = '&#3647;'; break;
        case 'GBP' : $currency_symbol = '&pound;'; break;
        case 'RON' : $currency_symbol = 'lei'; break;
        case 'VND' : $currency_symbol = '&#8363;'; break;
        case 'NGN' : $currency_symbol = '&#8358;'; break;
        case 'HRK' : $currency_symbol = 'Kn'; break;
        case 'EGP' : $currency_symbol = 'EGP'; break;
        case 'DOP' : $currency_symbol = 'RD&#36;'; break;
        case 'DZD' : $currency_symbol = 'DA;'; break;
        case 'KIP' : $currency_symbol = '&#8365;'; break;
        default    : $currency_symbol = ''; break;
    }

    return apply_filters( 'erp_currency_symbol', $currency_symbol, $currency );
}

/**
 * Embed a JS template page with its ID
 *
 * @param  string  the file path of the file
 * @param  string  the script id
 *
 * @return void
 */
function erp_get_js_template( $file_path, $id ) {
    if ( file_exists( $file_path ) ) {
        echo '<script type="text/html" id="tmpl-' . $id . '">' . "\n";
        include_once $file_path;
        echo "\n" . '</script>' . "\n";
    }
}

/**
 * Embed a Vue Component template page with its ID
 *
 * @param  string  the file path of the file
 * @param  string  the script id
 *
 * @return void
 */
function erp_get_vue_component_template( $file_path, $id ) {
    if ( file_exists( $file_path ) ) {
        echo '<script type="text/x-template" id="'. $id . '">' . "\n";
        include_once $file_path;
        echo "\n" . '</script>' . "\n";
    }
}


if ( ! function_exists( 'strip_tags_deep' ) ) {

    /**
     * Strip tags from string or array
     *
     * @param  mixed  array or string to strip
     *
     * @return mixed  stripped value
     */
    function strip_tags_deep( $value ) {
        if ( is_array( $value ) ) {
            foreach ($value as $key => $val) {
                $value[ $key ] = strip_tags_deep( $val );
            }
        } elseif ( is_string( $value ) ) {
            $value = strip_tags( $value );
        }

        return $value;
    }
}

if ( ! function_exists( 'trim_deep' ) ) {

    /**
     * Trim from string or array
     *
     * @param  mixed  array or string to trim
     *
     * @return mixed  timmed value
     */
    function trim_deep( $value ) {
        if ( is_array( $value ) ) {
            foreach ($value as $key => $val) {
                $value[ $key ] = trim_deep( $val );
            }
        } elseif ( is_string( $value ) ) {
            $value = trim( $value );
        }

        return $value;
    }
}

/**
 * Helper function to print a label and value with a separator
 *
 * @param  string  the label
 * @param  string  the value to print
 * @param  string  separator
 *
 * @return void
 */
function erp_print_key_value( $label, $value, $sep = ' : ' ) {
    $value = empty( $value ) ? '&mdash;' : $value;

    printf( '<label>%s</label> <span class="sep">%s</span> <span class="value">%s</span>', $label, $sep, $value );
}

/**
 * Get a clickable phone or email address link
 *
 * @param  string  type. e.g: email|phone|url
 * @param  string  the value
 *
 * @return string  the link
 */
function erp_get_clickable( $type = 'email', $value = '' ) {
    if ( 'email' == $type ) {
        return sprintf( '<a href="mailto:%1$s">%1$s</a>', $value );
    } elseif ( 'url' == $type ) {
        return sprintf( '<a href="%1$s">%1$s</a>', $value );
    } elseif ( 'phone' == $type ) {
        return sprintf( '<a href="tel:%1$s">%1$s</a>', $value );
    }
}

/**
 * Get a formatted date from WordPress format
 *
 * @param  string  $date the date
 *
 * @return string  formatted date
 */
function erp_format_date( $date, $format = false ) {
    if ( ! $format ) {
        $format = erp_get_option( 'date_format', 'erp_settings_general', 'd-m-Y' );
    }

    $time = strtotime( $date );

    return date_i18n( $format, $time );
}

/**
 * Extract dates between two date range
 *
 * @param  string  $start_date
 * @param  string  $end_date
 *
 * @return array
 */
function erp_extract_dates( $start_date, $end_date ) {
    $start_date = new DateTime( $start_date );
    $end_date   = new DateTime( $end_date );
    $end_date->modify( '+1 day' ); // to get proper days in duration
    $diff = $start_date->diff( $end_date );

    // we got a negative date
    if ( $diff->invert || ! $diff->days ) {
        return new WP_Error( 'invalid-date', __( 'Invalid date provided', 'erp' ) );
    }

    $interval = DateInterval::createFromDateString( '1 day' );
    $period   = new DatePeriod( $start_date, $interval, $end_date );

    // prepare the periods
    $dates = array();
    foreach ( $period as $dt ) {
        $dates[] = $dt->format( 'Y-m-d' );
    }

    return $dates;
}

/**
 * Convert an two dimentational array to one dimentional array object
 *
 * @param  array   $array array of arrays
 *
 * @return array
 */
function erp_array_to_object( $array = [] ) {
    $new_array = [];

    if ( $array ) {
        foreach ($array as $key => $value) {
            $new_array[] = (object) $value;
        }
    }

    return $new_array;
}

/**
 * Check date in range or not
 *
 * @param  date   $start_date
 * @param  date   $end_date
 * @param  date   $date_from_user
 *
 * @return boolen
 */
function erp_check_date_in_range( $start_date, $end_date, $date_from_user ) {
    // Convert to timestamp
    $start_ts = strtotime( $start_date );
    $end_ts   = strtotime( $end_date );
    $user_ts  = strtotime( $date_from_user );

    // Check that user date is between start & end
    if ( ($user_ts >= $start_ts) && ($user_ts <= $end_ts) ) {
        return true;
    }

    return false;
}

/**
 * Check date range any point in range or not
 *
 * @param  date   $start_date
 * @param  date   $end_date
 * @param  date   $user_date_start
 * @param  date   $user_date_end
 *
 * @return boolen
 */
function erp_check_date_range_in_range_exist( $start_date, $end_date, $user_date_start, $user_date_end ) {

    if ( erp_check_date_in_range( $start_date, $end_date, $user_date_start ) ) {
        return true;
    }

    if ( erp_check_date_in_range( $start_date, $end_date, $user_date_end ) ) {
        return true;
    }

    return false;
}

/**
 * Get durataion between two date
 *
 * @param  date   $start_date
 * @param  date   $end_date
 *
 * @return integer
 */
function erp_date_duration( $start_date, $end_date ) {
    $datetime1 = new DateTime( $start_date );
    $datetime2 = new DateTime( $end_date );
    $interval  = $datetime1->diff( $datetime2 );

    return $interval->format('%a');
}

/**
 * Performance rating elemet
 *
 * @since 0.1
 *
 * @param  string $selected
 *
 * @return array
 */
function erp_performance_rating( $selected = '' ) {

    $rating = apply_filters( 'erp_performance_rating', array(
        '1' => __( 'Very Bad', 'erp' ),
        '2' => __( 'Poor', 'erp' ),
        '3' => __( 'Average', 'erp' ),
        '4' => __( 'Good', 'erp' ),
        '5' => __( 'Excellent', 'erp' )
    ) );

    if ( $selected ) {
        return isset( $rating[$selected] ) ? $rating[$selected] : '';
    }

    return $rating;
}

/**
 * Get erp option from settings framework
 *
 * @param  sting  $option_name name of the option
 * @param  string $section     name of the section. if it's a separate option, don't provide any
 * @param  string $default     default option
 * @return string
 */
function erp_get_option( $option_name, $section = false, $default = '' ) {

    if ( $section ) {
        $option = get_option( $section );

        if ( isset( $option[$option_name] ) ) {
            return $option[$option_name];
        } else {
            return $default;
        }
    } else {
        return get_option( $option_name, $default );
    }
}

/**
 * Get erp logo
 *
 * @return string url of the logo
 */
function erp_get_site_logo() {
    $logo = (int) erp_get_option( 'logo', 'erp_settings_design' );

    if ( $logo ) {
        $logo_url = wp_get_attachment_url( $logo );

        return $logo_url;
    }
}

/**
 * Get month array
 *
 * @param string $title
 *
 * @since  0.1
 *
 * @return array
 */
function erp_months_dropdown( $title = false ) {

    $months = [];

    if ( $title ) {
        $months['-1'] = $title;
    }

    for ( $m = 1; $m <= 12; $m++ ) {
        $months[$m] = date( 'F', mktime( 0, 0, 0, $m ) );
    }

    return $months;

}

/**
 * Get Company financial start date
 *
 * @since  0.1
 *
 * @return string date
 */
function erp_financial_start_date() {
    return date( 'Y-m-d H:i:s', mktime( 0, 0, 0,  erp_get_option( 'gen_financial_month', 'erp_settings_general', 1 ), 1 ) );
}

/**
 * Get Company financial end date
 *
 * @since  0.1
 *
 * @return string date
 */
function erp_financial_end_date() {
    $start_date = erp_financial_start_date();
    return  date( 'Y-m-t H:i:s', strtotime( '+11 month', strtotime( $start_date ) ) );
}

/**
 * Get all modules inserted in log table
 *
 * @since 0.1
 *
 * @return array
 */
function erp_get_audit_log_modules() {
    return \WeDevs\ERP\Admin\Models\Audit_Log::select( 'component' )->distinct()->get()->toArray();
}

/**
 * Get all modules inserted in log table
 *
 * @since 0.1
 *
 * @return array
 */
function erp_get_audit_log_sub_component() {
    return \WeDevs\ERP\Admin\Models\Audit_Log::select( 'sub_component' )->distinct()->get()->toArray();
}

/**
 * Erp Logging functions
 *
 * @since 0.1
 *
 * @return instance
 */
function erp_log() {
    return \WeDevs\ERP\Log::instance();
}

/**
 * A file based logging function for debugging
 *
 * @since 0.1
 *
 * @param  string  $message
 * @param  string  $type
 *
 * @return void
 */
function erp_file_log( $message, $type = '' ) {
    if ( ! empty( $type ) ) {
        $message = sprintf( "[%s][%s] %s\n", date( 'd.m.Y h:i:s' ), $type, $message );
    } else {
        $message = sprintf( "[%s] %s\n", date( 'd.m.Y h:i:s' ), $message );
    }

    error_log( $message, 3, dirname( WPERP_FILE ) . '/debug.log' );
}

/**
 * Get people types from various components
 *
 * @return array
 */
function erp_get_people_types() {
    return apply_filters( 'erp_people_types', [] );
}

/**
 * Get Country name by country code
 *
 * @since 1.0
 *
 * @param  string $code
 *
 * @return string
 */
function erp_get_country_name( $country ) {

    $load_cuntries_states = \WeDevs\ERP\Countries::instance();
    $countries = $load_cuntries_states->countries;

    // Handle full country name
    if ( '-1' != $country ) {
        $full_country = ( isset( $countries[ $country ] ) ) ? $countries[ $country ] : $country;
    } else {
        $full_country = '—';
    }

    return $full_country;
}

/**
 * Get State name by country and state code
 *
 * @since 1.0
 *
 * @param  string $country
 * @param  string $state
 *
 * @return string
 */
function erp_get_state_name( $country, $state ) {
    $load_cuntries_states = \WeDevs\ERP\Countries::instance();
    $states = $load_cuntries_states->states;

    // Handle full state name
    $full_state   = ( $country && $state && isset( $states[ $country ][ $state ] ) ) ? $states[ $country ][ $state ] : $state;

    return $full_state;
}

/**
 * Cron Intervel
 *
 * @since 1.0
 *
 * @param  array $schedules
 *
 * @return array
 */
function erp_cron_intervals( $schedules ) {

    $schedules['per_minute'] = array(
        'interval'  => MINUTE_IN_SECONDS,
        'display'   => __( 'Every Minute', 'erp' )
    );

    $schedules['weekly'] = array(
        'interval'  => DAY_IN_SECONDS * 7,
        'display'  => __( 'Once Weekly', 'erp' )
    );

    return (array)$schedules;
}

/**
 * Display erp activation notice.
 *
 * @since 1.0
 *
 * @return void
 */
function erp_activation_notice() {

    if ( !current_user_can( 'manage_options' ) ) {
        return;
    }
    $apikey  = get_option( 'wp_erp_apikey' );
    $dismiss = get_option( 'wp_erp_activation_dismiss' );

    if ( ! $apikey && ! $dismiss ) {
    ?>
    <div class="notice erp-activation-cloud-prompt" id="erp-activation-container">
        <div class="activation-prompt-text">
            <?php _e( "You're awesome for installing <strong>WP ERP!</strong> Get API Key to get access to wperp <em>cloud</em> features!", "wp-erp" ) ?>
        </div>

        <div class="activation-form-container">
            <input type="email" name="email" placeholder="email@example.com" value="<?php echo esc_attr( get_option( 'admin_email' ) ); ?>" />
            <button class="button-primary" id="get-api-key"><?php _e( 'Get API Key', 'erp' ); ?></button>
            <a id="dismiss" href="#"><?php _e( 'Dismiss', 'erp' ); ?></a>
        </div>
    </div>
    <?php
    }
}

/**
 * Erp activation's JavaScript enqueue.
 *
 * @since  1.0
 *
 * @return void
 */
function erp_activation_notice_javascript() { ?>
    <script type="text/javascript" >
    jQuery( document ).ready( function($) {

        $container = $( "#erp-activation-container" );
        $( "#erp-activation-container button#get-api-key" ).click( function(e) {
            e.preventDefault();

            var data = {
                'action': 'erp_activation_notice',
                'email': $(e.target).parent().find( "input[name=email]" ).val(),
                '_wpnonce': '<?php echo wp_create_nonce( "wp-erp-activation-nonce" ); ?>'
            };

            $.post( ajaxurl, data, function(response) {
                if( response.success ) {
                    $( "[id=erp-activation-container]" ).hide();
                    document.location.reload();
                } else {
                    if( response.data.error ) {
                        alert( response.data.error );
                    } else {
                        alert( response.data );
                    }
                }
            });
        });

        $( "#erp-activation-container a#dismiss" ).click( function(e) {
            e.preventDefault();

            var data = {
                'action': 'erp_activation_notice',
                'dismiss': true,
                '_wpnonce': '<?php echo wp_create_nonce( "wp-erp-activation-nonce" ); ?>'
            };

            $.post( ajaxurl, data, function(response) {
                if( response.success ) {
                    $container.hide();
                }
            });
        });

        $( "a#wp-erp-disconnect-api" ).click( function(e) {
            e.preventDefault();

            var data = {
                'action': 'erp_activation_notice',
                'disconnect': true,
                '_wpnonce': '<?php echo wp_create_nonce( "wp-erp-activation-nonce" ); ?>'
            };

            $.post( ajaxurl, data, function(response) {
                if( response.success ) {
                    document.location.reload();
                }
            });
        });
    });
    </script> <?php
}

/**
 * Activate or deactivate erp api cloud features by server.
 *
 * @return void
 */
function erp_api_mode_change() {
    header('Access-Control-Allow-Origin: *');

    $postdata    = $_POST;
    $api_key     = get_option( 'wp_erp_apikey' );

    $is_verified = erp_cloud_verify_request( $postdata, $api_key  );

    if ( $is_verified ) {
        $status = isset( $_POST['status'] ) && in_array( $_POST['status'], ['yes', 'no'] ) ? $_POST['status'] : 'yes';

        update_option( 'wp_erp_api_active', $_POST['status'] );
    }
}

/**
 * Determine if the erp cloud feature is active or not.
 *
 * @return boolean
 */
function erp_is_cloud_active() {
    $wp_erp_api_key    = get_option( 'wp_erp_apikey', null );
    $wp_erp_api_active = get_option( 'wp_erp_api_active', 'no' );

    if ( $wp_erp_api_key && 'yes' == $wp_erp_api_active ) {
        return true;
    }

    return false;
}

/**
 * Verify given http request.
 *
 * @param  array  $vars
 * @param  string $api_key
 *
 * @return boolean
 */
function erp_cloud_verify_request( $vars, $api_key ) {
    if ( ! isset( $vars['verify_key'] ) ) {
        return false;
    }

    $verify_key = $vars['verify_key'];

    unset( $vars['verify_key'] );

    return ( hash_hmac( 'sha256', serialize( $vars ), $api_key ) === $verify_key );
}

/**
 * forward given end_date by 1 day to make fullcalendar range compatible
 *
 * @param string $end_date saved $end_date from db
 *
 * @since 0.1
 *
 * @return string end_date
 */
function erp_fullcalendar_end_date( $end_date ) {
    return date( 'Y-m-d H:i:s', strtotime( $end_date . '+1 day' ) );
}

/**
 * Show user own media attachment
 *
 * @since 1.0
 *
 * @param  string $query
 *
 * @return string
 */
function erp_show_users_own_attachments( $query ) {
    if ( ! is_user_logged_in() ) {
        return $query;
    }

    $id = get_current_user_id();

    if ( ! current_user_can( 'manage_options' ) ) {
        if ( current_user_can( 'erp_hr_manager' )
            || current_user_can( 'employee' )
            || current_user_can( 'erp_crm_manager' )
            || current_user_can( 'erp_crm_agent' )
        ) {
            $query['author'] = $id;
        }
    }

    return $query;
}

/**
 * Get all registered addons for licensing
 *
 * @since 1.0
 *
 * @return array
 */
function erp_addon_licenses() {
    $licenses = [];

    return apply_filters( 'erp_settings_licenses', $licenses );
}

/**
 * Show a readable message about the license status
 *
 * @since 1.0
 *
 * @param  array  $addon
 *
 * @return string
 */
function erp_get_license_status( $addon ) {
    if ( ! is_object( $addon['status'] ) ) {
        return false;
    }

    $messages     = [];
    $html         = '';
    $license      = $addon['status'];
    $status_class = 'has-error';

    if ( false === $license->success ) {

        switch( $license->error ) {

            case 'expired' :

                $messages[] = sprintf(
                    __( 'Your license key expired on %s. Please <a href="%s" target="_blank" title="Renew your license key">renew your license key</a>.', 'erp' ),
                    date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) ),
                    'https://wperp.com/checkout/?edd_license_key=' . $addon['license'] . '&utm_campaign=admin&utm_source=licenses&utm_medium=expired'
                );
                break;

            case 'missing' :

                $messages[] = sprintf(
                    __( 'Invalid license. Please <a href="%s" target="_blank" title="Visit account page">visit your account page</a> and verify it.', 'erp' ),
                    'https://wperp.com/my-account?utm_campaign=admin&utm_source=licenses&utm_medium=missing'
                );
                break;

            case 'invalid' :
            case 'site_inactive' :

                $messages[] = sprintf(
                    __( 'Your %s is not active for this URL. Please <a href="%s" target="_blank" title="Visit account page">visit your account page</a> to manage your license key URLs.', 'erp' ),
                    $addon['name'],
                    'https://wperp.com/my-account?utm_campaign=admin&utm_source=licenses&utm_medium=invalid'
                );
                break;

            case 'item_name_mismatch' :

                $messages[] = sprintf( __( 'This is not a %s.', 'erp' ), $addon['name'] );
                break;

            case 'no_activations_left':
                $messages[] = sprintf( __( 'Your license key has reached its activation limit. <a href="%s">View possible upgrades</a> now.', 'erp' ), 'https://wperp.com/my-account/' );
                break;

        }
    } else {

        switch( $license->license ) {
            case 'expired' :

                $messages[] = sprintf(
                    __( 'Your license key expired on %s. Please <a href="%s" target="_blank" title="Renew your license key">renew your license key</a>.', 'erp' ),
                    date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) ),
                    'https://wperp.com/checkout/?edd_license_key=' . $addon['license'] . '&utm_campaign=admin&utm_source=licenses&utm_medium=expired'
                );
                break;

            case 'valid':
                $status_class = 'no-error';
                $now          = current_time( 'timestamp' );
                $expiration   = strtotime( $license->expires, current_time( 'timestamp' ) );

                if ( 'lifetime' === $license->expires ) {

                    $messages[] = __( 'License key never expires.', 'erp' );

                } elseif( $expiration > $now && $expiration - $now < ( DAY_IN_SECONDS * 30 ) ) {

                    $messages[] = sprintf(
                        __( 'Your license key expires soon! It expires on %s. <a href="%s" target="_blank" title="Renew license">Renew your license key</a>.', 'erp' ),
                        date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) ),
                        'https://wperp.com/checkout/?edd_license_key=' . $value . '&utm_campaign=admin&utm_source=licenses&utm_medium=renew'
                    );

                } else {

                    $messages[] = sprintf(
                        __( 'Your license key expires on %s.', 'erp' ),
                        date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) )
                    );

                }
                break;
        }

    }

    if ( ! empty( $messages ) ) {
        foreach( $messages as $message ) {

            $html .= '<div class="erp-license-status ' . $status_class . '">';
                $html .= '<p class="help">' . $message . '</p>';
            $html .= '</div>';

        }
    }

    return $html;
}
