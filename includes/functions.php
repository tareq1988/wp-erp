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
        'AED' => __( 'United Arab Emirates Dirham', 'wp-erp' ),
        'AUD' => __( 'Australian Dollars', 'wp-erp' ),
        'BDT' => __( 'Bangladeshi Taka', 'wp-erp' ),
        'BRL' => __( 'Brazilian Real', 'wp-erp' ),
        'BGN' => __( 'Bulgarian Lev', 'wp-erp' ),
        'CAD' => __( 'Canadian Dollars', 'wp-erp' ),
        'CLP' => __( 'Chilean Peso', 'wp-erp' ),
        'CNY' => __( 'Chinese Yuan', 'wp-erp' ),
        'COP' => __( 'Colombian Peso', 'wp-erp' ),
        'CZK' => __( 'Czech Koruna', 'wp-erp' ),
        'DKK' => __( 'Danish Krone', 'wp-erp' ),
        'DOP' => __( 'Dominican Peso', 'wp-erp' ),
        'EUR' => __( 'Euros', 'wp-erp' ),
        'HKD' => __( 'Hong Kong Dollar', 'wp-erp' ),
        'HRK' => __( 'Croatia kuna', 'wp-erp' ),
        'HUF' => __( 'Hungarian Forint', 'wp-erp' ),
        'ISK' => __( 'Icelandic krona', 'wp-erp' ),
        'IDR' => __( 'Indonesia Rupiah', 'wp-erp' ),
        'INR' => __( 'Indian Rupee', 'wp-erp' ),
        'NPR' => __( 'Nepali Rupee', 'wp-erp' ),
        'ILS' => __( 'Israeli Shekel', 'wp-erp' ),
        'JPY' => __( 'Japanese Yen', 'wp-erp' ),
        'KIP' => __( 'Lao Kip', 'wp-erp' ),
        'KRW' => __( 'South Korean Won', 'wp-erp' ),
        'MYR' => __( 'Malaysian Ringgits', 'wp-erp' ),
        'MXN' => __( 'Mexican Peso', 'wp-erp' ),
        'NGN' => __( 'Nigerian Naira', 'wp-erp' ),
        'NOK' => __( 'Norwegian Krone', 'wp-erp' ),
        'NZD' => __( 'New Zealand Dollar', 'wp-erp' ),
        'PYG' => __( 'Paraguayan Guaraní', 'wp-erp' ),
        'PHP' => __( 'Philippine Pesos', 'wp-erp' ),
        'PLN' => __( 'Polish Zloty', 'wp-erp' ),
        'GBP' => __( 'Pounds Sterling', 'wp-erp' ),
        'RON' => __( 'Romanian Leu', 'wp-erp' ),
        'RUB' => __( 'Russian Ruble', 'wp-erp' ),
        'SGD' => __( 'Singapore Dollar', 'wp-erp' ),
        'ZAR' => __( 'South African rand', 'wp-erp' ),
        'SEK' => __( 'Swedish Krona', 'wp-erp' ),
        'CHF' => __( 'Swiss Franc', 'wp-erp' ),
        'TWD' => __( 'Taiwan New Dollars', 'wp-erp' ),
        'THB' => __( 'Thai Baht', 'wp-erp' ),
        'TRY' => __( 'Turkish Lira', 'wp-erp' ),
        'USD' => __( 'US Dollars', 'wp-erp' ),
        'VND' => __( 'Vietnamese Dong', 'wp-erp' ),
        'EGP' => __( 'Egyptian Pound', 'wp-erp' ),
    ) ) );
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
            $currency_symbol = '&#2547;&nbsp;';
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
        return new WP_Error( 'invalid-date', __( 'Invalid date provided', 'wp-erp' ) );
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
        '1' => __( 'Very Bad', 'wp-erp' ),
        '2' => __( 'Poor', 'wp-erp' ),
        '3' => __( 'Average', 'wp-erp' ),
        '4' => __( 'Good', 'wp-erp' ),
        '5' => __( 'Excellent', 'wp-erp' )
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
    $full_country = ( isset( $countries[ $country ] ) ) ? $countries[ $country ] : $country;

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
        'interval'  => 60, // Number of seconds, 60s in 1 minutes
        'display'   => 'Every Minutes'
    );

    return (array)$schedules;
}

add_action( 'init', function() {

    if ( isset( $_GET['erp_email_preview'] ) ) {
        $employee_id = 37;
        $empl_welcome = new \WeDevs\ERP\HRM\Emails\New_Employee_Welcome();
        $empl_welcome->trigger( $employee_id );
        exit;
    }

}, 99 );

/**
 * forward given end_date by 1 day to make fullcalendar range compatible
 * 
 * @param string $end_date saved $end_date from db
 * 
 * @since 0.1
 * 
 * @return string end_date
 */
function erp_fullcalendar_end_date( $end_date ){
    return date( 'Y-m-d H:i:s', strtotime( $end_date . '+1 day' ) );
}