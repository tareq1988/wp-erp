<?php

use WeDevs\ERP\HRM\Employee;
use WeDevs\ERP\HRM\Models\Financial_Year;
use WeDevs\ERP\HRM\Models\Leave_Approval_Status;
use WeDevs\ERP\HRM\Models\Leave_Entitlement;
use WeDevs\ERP\HRM\Models\Leave_Holiday;
use \WeDevs\ERP\HRM\Models\Leave_Policy;
use \WeDevs\ERP\HRM\Models\Leave;
use WeDevs\ERP\HRM\Models\Leave_Request;
use WeDevs\ERP\HRM\Models\Leave_Request_Detail;
use WeDevs\ERP\HRM\Models\Leaves_Unpaid;

/**
 * Get holiday between two date
 *
 * @since  0.1
 *
 * @param  date $start_date
 * @param  date $end_date
 *
 * @return array
 */
function erp_hr_leave_get_holiday_between_date_range( $start_date, $end_date ) {
    $holiday = new Leave_Holiday();

    $holiday = $holiday->where( function ( $condition ) use ( $start_date ) {
        $condition->where( 'start', '<=', $start_date );
        $condition->where( 'end', '>=', $start_date );
    } );

    $holiday = $holiday->orWhere( function ( $condition ) use ( $end_date ) {
        $condition->where( 'start', '<=', $end_date );
        $condition->where( 'end', '>=', $end_date );
    } );


    $holiday = $holiday->orWhere( function ( $condition ) use ( $start_date, $end_date ) {
        $condition->where( 'start', '>=', $start_date );
        $condition->where( 'start', '<=', $end_date );
    } );

    $holiday = $holiday->orWhere( function ( $condition ) use ( $start_date, $end_date ) {
        $condition->where( 'end', '>=', $start_date );
        $condition->where( 'end', '<=', $end_date );
    } );

    $results = $holiday->get()->toArray();

    $holiday_extrat    = [];
    $given_date_extrat = erp_extract_dates( $start_date, $end_date );

    foreach ( $results as $result ) {
        $date_extrat    = erp_extract_dates( $result['start'], $result['end'] );
        $holiday_extrat = array_merge( $holiday_extrat, $date_extrat );
    }

    $extract = array_intersect( $given_date_extrat, $holiday_extrat );

    return $extract;
}

/**
 * Checking is user take leave within date rang in before
 *
 * @since  0.1
 *
 * @param  string $start_date
 * @param  string $end_date
 * @param  int $user_id
 *
 * @return boolean
 */
function erp_hrm_is_leave_recored_exist_between_date( $start_date, $end_date, $user_id, $f_year ) {
    global $wpdb;

    if ( ! is_numeric( $start_date ) ) {
        $start_date = current_datetime()->modify( $start_date )->setTime( 0, 0, 0 )->getTimestamp();
    }

    if ( ! is_numeric( $end_date ) ) {
        $end_date = current_datetime()->modify( $end_date )->setTime( 0, 0, 0 )->getTimestamp();
    }

    $request_details_tbl  = "{$wpdb->prefix}erp_hr_leave_request_details";
    $available = Leave_Request_Detail::where( 'user_id', '=', $user_id )
                                     ->where( 'f_year', '=', $f_year )
                                     ->where( 'leave_date', '>=', $start_date )
                                     ->where( 'leave_date', '<=', $end_date )
                                     ->count();

    return $available ? true : false;
}

/**
 * Check leave duration exist or not the plicy days
 *
 * @since  0.1
 *
 * @param  string $start_date
 * @param  string $end_date
 * @param  int $policy_id
 * @param  int $user_id
 *
 * @return boolean
 */
function erp_hrm_is_valid_leave_duration( $start_date, $end_date, $policy_id, $user_id ) {

    if ( ! $user_id || ! $policy_id ) {
        return true;
    }

    $balance = erp_hr_leave_get_balance_for_single_entitlement( $policy_id );

    $user_enti_count    = $balance['day_out'];
    $policy_days        = $balance['total'];
    $working_day        = erp_hr_get_work_days_without_off_day( $start_date, $end_date );//erp_hr_get_work_days_between_dates( $start_date, $end_date );erp_hr_get_work_days_without_holiday
    $apply_days         = $working_day['total'] + $user_enti_count;

    if ( $apply_days > $policy_days ) {
        return false;
    }

    return true;
}

/**
 * Leave request time checking the apply date duration with the financial date duration
 *
 * @since  0.1
 *
 * @param  string $start_date
 * @param  string $end_date
 *
 * @return boolean
 */
function erp_hrm_is_valid_leave_date_range_within_financial_date_range( $start_date, $end_date ) {

    $financial_start_date = date( 'Y-m-d', strtotime( erp_financial_start_date() ) );
    $financial_end_date   = date( 'Y-m-d', strtotime( erp_financial_end_date() ) );
    $apply_start_date     = date( 'Y-m-d', strtotime( $start_date ) );
    $apply_end_date       = date( 'Y-m-d', strtotime( $end_date ) );

    if ( $financial_start_date > $apply_start_date || $apply_start_date > $financial_end_date ) {
        return false;
    }

    if ( $financial_start_date > $apply_end_date || $apply_end_date > $financial_end_date ) {
        return false;
    }

    return true;
}

/**
 * Insert a new leave policy
 *
 * @since 0.1
 *
 * @param array $args
 *
 * @return int $policy_id
 */
function erp_hr_leave_insert_policy( $args = array() ) {
    $defaults = array(
        'id' => null
    );

    $args = wp_parse_args( $args, $defaults );

    $common = array(
        'leave_id'       => $args['leave_id'],
        'department_id'  => $args['department_id'],
        'designation_id' => $args['designation_id'],
        'location_id'    => $args['location_id'],
        'f_year'         => $args['f_year']
    );

    $extra = apply_filters( 'erp_hr_leave_insert_policy_extra', array(
        'description'          => $args['description'],
        'days'                 => $args['days'],
        'color'                => $args['color'],
        'gender'               => $args['gender'],
        'marital'              => $args['marital'],
        'applicable_from_days' => $args['applicable_from']
    ) );

    /**
     * Update
     */
    if ( $args['id'] ) {
        $where = array();

        foreach ( $common as $key => $value ) {
            $where[] = array( $key, $value );
        }

        $exists = Leave_Policy::where( $where )->first();

        if ( $exists ) {
            return new WP_Error( 'exists', esc_html__( 'Policy already exists.', 'erp' ) );
        }

        $leave_policy = Leave_Policy::find( $args['id'] )
                            ->update( array_merge( $common, $extra ) );

        do_action( 'erp_hr_leave_update_policy', $args['id'] );

        return $leave_policy->id;
    }

    /**
     * Create
     */
    $leave_policy = Leave_Policy::firstOrCreate( $common, $extra );

    if ( ! $leave_policy->wasRecentlyCreated ) {
        return new WP_Error( 'exists', esc_html__( 'Policy already exists.', 'erp' ) );
    }

    do_action( 'erp_hr_leave_insert_policy', $args['id'] );

    return $leave_policy->id;
}

/**
 * Apply policy in existing employee
 *
 * @since 0.1
 * @since 1.2.0 Using `erp_hr_apply_policy_to_employee` for both Immediate and
 *              Scheduled policy when `instant_apply` is true
 *
 * @param  object $policy Leave_Policies model
 * @param  array $args
 *
 * @return void
 */
function erp_hr_apply_policy_existing_employee( $policy, $args ) {
    if ( ! erp_validate_boolean( $args['instant_apply'] ) ) {
        return;
    }

    erp_bulk_policy_assign($policy);
//    erp_hr_apply_policy_to_employee( $policy );
}

/**
 * Apply a leave policy to all or filtered employees
 *
 * @since 1.2.0
 *
 * @param object $policy Leave_Policies eloquent object
 * @param array $employee_ids Employee ids
 *
 * @return void
 */
function erp_hr_apply_policy_to_employee( $policy, $employee_ids = [] ) {
    if ( is_int( $policy ) ) {
        $policy = $policy = Leave_Policy::find( $policy );
    }

    $db     = \WeDevs\ORM\Eloquent\Facades\DB::instance();
    $prefix = $db->db->prefix;

    $employees = $db->table( 'erp_hr_employees as employee' )
                    ->select( 'employee.user_id' )
                    ->leftJoin( "{$prefix}usermeta as gender", function ( $join ) {
                        $join->on( 'employee.user_id', '=', 'gender.user_id' )->where( 'gender.meta_key', '=', 'gender' );
                    } )
                    ->leftJoin( "{$prefix}usermeta as marital_status", function ( $join ) {
                        $join->on( 'employee.user_id', '=', 'marital_status.user_id' )->where( 'marital_status.meta_key', '=', 'marital_status' );
                    } )
                    ->where( 'status', '=', 'active' );

    if ( ! empty( $employee_ids ) && is_array( $employee_ids ) ) {
        $employees->whereIn( 'employee.user_id', $employee_ids );
    }

    if ( $policy->department > 0 ) {
        $employees->where( 'department', $policy->department );
    }

    if ( $policy->designation > 0 ) {
        $employees->where( 'designation', $policy->designation );
    }

    if ( $policy->location > 0 ) {
        $employees->where( 'location', $policy->location );
    }

    if ( $policy->gender != - 1 ) {
        $employees->where( 'gender.meta_value', $policy->gender );
    }

    if ( $policy->marital != - 1 ) {
        $employees->where( 'marital_status.meta_value', $policy->marital );
    }

    if ( $policy->activate == 2 && ! empty( $policy->execute_day ) ) {
        $current_date = date( 'Y-m-d', current_time( 'timestamp' ) );

        $employees->where(
            $db->raw( "DATEDIFF( '$current_date', `employee`.`hiring_date` )" ), '>=', $policy->execute_day
        );
    }

    $employees = $employees->get();

    if ( ! empty( $employees ) ) {
        foreach ( $employees as $employee ) {
            erp_hr_apply_leave_policy( $employee->user_id, $policy );
        }
    }
}

/**
 * Assign entitlement
 *
 * @since 0.1
 * @since 1.2.0 Calculate from_date and to_date based on policy
 *              effective_date and financial start/end dates
 *
 * @param  int $user_id
 * @param  object $leave_policy
 *
 * @return void
 */
function erp_hr_apply_leave_policy( $user_id, $policy ) {
    $financial_year = erp_get_financial_year_dates();

    $from_date                      = ! empty( $policy->effective_date ) ? $policy->effective_date : $financial_year['start'];
    $from_date_timestamp            = strtotime( $from_date );
    $financial_year_start_timestamp = strtotime( $financial_year['start'] );

    if ( $from_date_timestamp < $financial_year_start_timestamp ) {
        $from_date = date( 'Y-m-d 00:00:00', $financial_year_start_timestamp );
    } else {
        $from_date = date( 'Y-m-d 00:00:00', $from_date_timestamp );
    }

    $to_date                      = $financial_year['end'];
    $financial_year_end_timestamp = strtotime( $financial_year['end'] );

    if ( $from_date_timestamp > $financial_year_end_timestamp ) {
        $financial_year_end_timestamp += YEAR_IN_SECONDS;
        $to_date                      = date( 'Y-m-d 23:59:59', $financial_year_end_timestamp );
    }

    $policy = [
        'user_id'   => $user_id,
        'policy_id' => $policy->id,
        'days'      => $policy->value,
        'from_date' => $from_date,
        'to_date'   => $to_date,
        'comments'  => $policy->description
    ];

    erp_hr_leave_insert_entitlement( $policy );
}

/**
 * Insert a new policy entitlement for an employee
 *
 * @since 0.1
 * @since 1.2.0 Use `erp_get_financial_year_dates` for financial start and end dates
 * @since 1.5.15 updated due to database structure change
 *
 * @param  array $args
 *
 * @return int|object New entitlement id or WP_Error object
 */
function erp_hr_leave_insert_entitlement( $args = [] ) {
    /*
     * Workflow:
     * 1. Check if required fields exists
     * 2. Check if policy already assigned for current user
     * 3. Check if we can assign this employee ie: 60 days waiting period based on joining date -- user trn_id
     * 5. Check if we can assign this policy to this employee based on filters
     * 4. finally add this policy to database.
     */

    $defaults = array(
        'user_id'       => 0,
        'leave_id'      => 0,
        'created_by'    => get_current_user_id(),
        'trn_id'        => 0,
        'trn_type'      => 'leave_policies',
        'day_in'        => 0,
        'day_out'       => 0,
        'description'   => '',
        'f_year'        => '',
    );

    $fields = wp_parse_args( $args, $defaults );

    // sanitize user inputs
    array_walk_recursive( $fields, function( &$key, &$value ) {
        $key = sanitize_key( $key );
        switch ( $key ) {
            case 'user_id':
            case 'leave_id':
            case 'created_by':
            case 'trn_id':
            case 'f_year':
                $value = absint( $value );
                break;

            case 'day_in':
            case 'day_out':
                // can be float value
                if ( (float) $value == $value ) {
                    $value = floatval( $value );
                }
                else {
                    $value = absint( $value );
                }
                break;

            case 'trn_type':
            case 'description':
                $value = sanitize_text_field( wp_unslash( $value ) );
                break;

            default:
                $value = sanitize_text_field( wp_unslash( $value ) );
                break;
        }
    } );

    // Check if required fields exists
    if ( ! $fields['user_id'] ) {
        return new WP_Error( 'no-user', esc_attr__( 'No employee provided.', 'erp' ) );
    }

    if ( ! $fields['leave_id']) {
        return new WP_Error( 'no-policy', esc_attr__( 'No policy provided.', 'erp' ) );
    }

    if ( ! $fields['trn_id']) {
        return new WP_Error( 'no-trn-id', esc_attr__( 'No transaction id is provided.', 'erp' ) );
    }

    if ( ! $fields['trn_type']) {
        return new WP_Error( 'no-trn-type', esc_attr__( 'No transaction type is provided.', 'erp' ) );
    }

    if ( ! $fields['f_year']) {
        return new WP_Error( 'no-financial-year', esc_attr__( 'No financial year is provided.', 'erp' ) );
    }

    if ( $fields['day_in'] == 0 && $fields['day_out'] == 0 ) {
        return new WP_Error( 'no-date', esc_attr__( 'No date provided.', 'erp' ) );
    }

    // Check if policy already assigned for current user - only if transaction type is: leave_policies
    if ( $fields['trn_type'] === 'leave_policies' ) {
        $entitlement = Leave_Entitlement::where( 'user_id', '=', $fields['user_id'] );
        $entitlement->where( 'leave_id', '=', $fields['leave_id'] );
        $entitlement->where( 'trn_type', '=', 'leave_policies' );
        $entitlement->where( 'f_year', '=', $fields['f_year'] );

        $existing_entitlement = $entitlement->get();

        if ( $existing_entitlement->count() ) {
            return $existing_entitlement->first()->id;
            //return new WP_Error( 'policy-already-assigned', 'policy already assigned. ID: ' . $existing_entitlement->first()->id);
        }

        // Check if we can assign this employee

        // get employee from user id
        $employee = new Employee( $fields['user_id'] );

        // check if this user is a valid employee
        if ( ! $employee->is_employee() ) {
            return new WP_Error( 'invalid-employee-' . $fields['user_id'], esc_attr__( 'Error: Invalid Employee. No employee found with given ID.', 'erp' ) );
        }

        // get policy data
        $policy = Leave_Policy::find( $fields['trn_id'] );
        if ( ! $policy ) {
            return new WP_Error( 'invalid-policy-' . $fields['trn_id'], esc_attr__( 'Error: Invalid Policy. No leave policy found with given ID.', 'erp' ) );
        }

        // check policy filter is same as employee filters
        if (    ( $policy->department_id    != '-1'   && $employee->get_department()        != $policy->department_id )
             || ( $policy->designation_id   != '-1'   && $employee->get_designation()       != $policy->designation_id )
             || ( $policy->location_id      != '-1'   && $employee->get_location()          != $policy->location_id )
             || ( $policy->gender           != '-1'   && $employee->get_gender()            != $policy->gender )
             || ( $policy->marital          != '-1'   && $employee->get_marital_status()    != $policy->marital )
        ) {
            return new WP_Error( 'invalid-employee-' . $fields['user_id'], esc_attr__( 'Error: Invalid Employee. Policy does not match with employee profile.', 'erp' ) );
        }

        // get employee joining date and compare it with policy's applicable form date
        $compare_with = current_datetime();
        $compare_with = $compare_with->modify( $employee->get_hiring_date() );
        $compare_with = $compare_with->modify( '+' . $policy->applicable_from_days . ' days' );

        $today = current_datetime();

        if ( $compare_with > $today ) {
            return new WP_Error( 'invalid-entitlement-days', esc_attr__( 'Error: Employee is not eligible for this leave policy yet.', 'erp' ) );
        }
    }

    // add this policy to database.
    $entitlement = new Leave_Entitlement();
    $entitlement->user_id       = $fields['user_id'];
    $entitlement->leave_id      = $fields['leave_id'];
    $entitlement->created_by    = $fields['created_by'];
    $entitlement->trn_id        = $fields['trn_id'];
    $entitlement->trn_type      = $fields['trn_type'];
    $entitlement->day_in        = $fields['day_in'];
    $entitlement->day_out       = $fields['day_out'];
    $entitlement->description   = $fields['description'];
    $entitlement->f_year        = $fields['f_year'];
    $entitlement->save();

    if ( $fields['trn_type'] === 'leave_policies' ) {
        do_action( 'erp_hr_leave_insert_new_entitlement', $entitlement->id, $fields );
    }

    return $entitlement->id;
}

/**
 * Apply `Immediately` type policies on new employee
 *
 * @since 1.2.0
 *
 * @param int $user_id Employee user_id provided by `erp_hr_employee_new` hook
 *
 * @return void
 */
function erp_hr_apply_policy_on_new_employee( $user_id ) {
    $policies = Leave_Policy::where( 'activate', 1 )->get();

    $policies->each( function ( $policy ) use ( $user_id ) {
        erp_hr_apply_policy_to_employee( $policy, [ $user_id ] );
    } );
}

/**
 * Apply `Scheduled` type policies on new employee
 *
 * @since 1.2.0
 *
 * @return void
 */
function erp_hr_apply_scheduled_policies() {
    $policies = Leave_Policy::where( 'activate', 2 )->get();

    $policies->each( function ( $policy ) {
        erp_hr_apply_policy_to_employee( $policy );
    } );
}

/**
 * Insert a leave holiday
 *
 * @since 0.1
 *
 * @param array $args
 *
 * @return integer [$holiday_id]
 */
function erp_hr_leave_insert_holiday( $args = array() ) {

    $defaults = array(
        'id'          => null,
        'title'       => '',
        'start'       => current_time( 'mysql' ),
        'end'         => '',
        'description' => '',
    );

    $args = wp_parse_args( $args, $defaults );

    // some validation
    if ( empty( $args['title'] ) ) {
        return new WP_Error( 'no-name', __( 'No title provided.', 'erp' ) );
    }

    if ( empty( $args['start'] ) ) {
        return new WP_Error( 'no-value', __( 'No start date provided.', 'erp' ) );
    }

    if ( empty( $args['end'] ) ) {
        return new WP_Error( 'no-value', __( 'No end date provided.', 'erp' ) );
    }

    $args['title'] = sanitize_text_field( $args['title'] );

    $holiday_id = (int) $args['id'];
    unset( $args['id'] );

    $holiday = new Leave_Holiday();

    if ( ! $holiday_id ) {
        // insert a new
        $leave_policy = $holiday->create( $args );

        if ( $leave_policy ) {
            do_action( 'erp_hr_new_holiday', $leave_policy->insert_id, $args );

            return $leave_policy->id;
        }

    } else {
        do_action( 'erp_hr_before_update_holiday', $holiday_id, $args );

        if ( $holiday->find( $holiday_id )->update( $args ) ) {
            do_action( 'erp_hr_after_update_holiday', $holiday_id, $args );

            return $holiday_id;
        }
    }
}

/**
 * Get all leave policies with different condition
 *
 * @since 0.1
 *
 * @since 1.5.15 updated code to reflect new leave data structure
 *
 * @param array $args
 *
 * @return array
 */
function erp_hr_leave_get_policies( $args = array() ) {

    $defaults = array(
        'number'        => 99,
        'offset'        => 0,
        'orderby'       => 'id',
        'order'         => 'ASC',
        'department_id' => '-1',
        'location_id'   => '-1',
        'designation_id' => '-1',
        'gender'        => '-1',
        'marital'       => '-1',
        'f_year'        => '',
    );

    $args = wp_parse_args( $args, $defaults );

    // sanitize inputs
    array_walk_recursive( $args, function( &$key, &$value ) {
        $key = sanitize_key( $key );
        switch ( $key ) {
            case 'number':
            case 'offset':
            case 'department_id':
            case 'location_id':
            case 'designation_id':
            case 'f_year':
                $value = absint( $value );
                break;

            case 'orderby':
            case 'order':
            case 'gender':
            case 'marital':
                $value = sanitize_text_field( $value );
                break;

            default:
                $value = sanitize_text_field( $value );
                break;
        }
    } );

    $cache_key = 'erp-get-policies-' . md5( serialize( $args ) );
    $policies  = wp_cache_get( $cache_key, 'erp' );

    if ( false === $policies ) {
        $policies = Leave_Policy::skip( $args['offset'] )
                                ->take( $args['number'] )
                                ->orderBy( $args['orderby'], $args['order'] );

        if ( $args['department_id'] != '-1' ) {
            $policies->where( 'department_id', '=', $args['department_id'] );
        }

        if ( $args['location_id'] != '-1' ) {
            $policies->where( 'location_id', '=', $args['location_id'] );
        }

        if ( $args['designation_id'] != '-1' ) {
            $policies->where( 'designation_id', '=', $args['designation_id'] );
        }

        if ( $args['gender'] != '-1' ) {
            $policies->where( 'gender', '=', $args['gender'] );
        }

        if ( $args['marital'] != '-1' ) {
            $policies->where( 'marital', '=', $args['marital'] );
        }

        if ( $args['f_year'] != '' ) {
            $policies->where( 'f_year', '=', $args['f_year'] );
        }

        $policies = $policies->get();

        $formatted_data = array();

        foreach( $policies as $key => $policy ) {
            $department  = empty( $policy->department ) ? 'All Departments' : $policy->department->title;
            $designation = empty( $policy->designation ) ? 'All Designations' : $policy->designation->title;

            $formatted_data[$key]['id']             = $policy->id;
            $formatted_data[$key]['leave_id']       = $policy->leave_id;
            $formatted_data[$key]['name']           = $policy->leave->name;
            $formatted_data[$key]['description']    = $policy->description;
            $formatted_data[$key]['days']           = $policy->days;
            $formatted_data[$key]['color']          = $policy->color;
            $formatted_data[$key]['department_id']  = $policy->department_id;
            $formatted_data[$key]['department']     = $department;
            $formatted_data[$key]['designation_id'] = $policy->designation_id;
            $formatted_data[$key]['designation']    = $designation;
            $formatted_data[$key]['location_id']    = $policy->location_id;
            $formatted_data[$key]['f_year']         = $policy->financial_year->fy_name;
            $formatted_data[$key]['gender']         = $policy->gender;
            $formatted_data[$key]['marital']        = $policy->marital;
        }

        $policies = erp_array_to_object( $formatted_data );
        wp_cache_set( $cache_key, $policies, 'erp' );
    }

    return $policies;
}

/**
 * Fetch a leave policy by match policy name
 *
 * @since 1.3.2
 *
 * @param string $name
 *
 * @return \stdClass
 */
function erp_hr_leave_get_policy_by_name( $name ) {
    return Leave_Policy::where( 'name', $name )->first();
}

/**
 * Fetch a leave policy by policy id
 *
 * @since 0.1
 * @since 1.2.0 Return Eloquent Leave_Policies model
 *
 * @param integer $policy_id
 *
 * @return \stdClass
 */
function erp_hr_leave_get_policy( $policy_id ) {
    return Leave_Policy::find( $policy_id );
}

/**
 * Count total leave policies
 *
 * @since 0.1
 *
 * @return integer
 */
function erp_hr_count_leave_policies() {
    return Leave_Policy::count();
}

/**
 * Fetch all holidays by company
 *
 * @since 0.1
 *
 * @param array $args
 *
 * @return array
 */
function erp_hr_get_holidays( $args = [] ) {

    $defaults = array(
        'number'  => 20,
        'offset'  => 0,
        'orderby' => 'created_at',
        'order'   => 'DESC',
    );

    $args = wp_parse_args( $args, $defaults );

    $holiday = new Leave_Holiday();

    $holiday_results = $holiday->select( array( 'id', 'title', 'start', 'end', 'description' ) );

    $holiday_results = erp_hr_holiday_filter_param( $holiday_results, $args );

    //if not search then execute nex code
    if ( isset( $args['id'] ) && ! empty( $args['id'] ) ) {
        $id              = intval( $args['id'] );
        $holiday_results = $holiday_results->where( 'id', '=', "$id" );
    }

    $cache_key = 'erp-get-holidays-' . md5( serialize( $args ) );
    $holidays  = wp_cache_get( $cache_key, 'erp' );

    if ( false === $holidays ) {

        if ( $args['number'] == '-1' ) {
            $holidays = erp_array_to_object( $holiday_results->get()->toArray() );
        } else {
            $holidays = erp_array_to_object(
                $holiday_results->skip( $args['offset'] )
                                ->take( $args['number'] )
                                ->orderBy( $args['orderby'], $args['order'] )
                                ->get()
                                ->toArray()
            );
        }

        wp_cache_set( $cache_key, $holidays, 'erp' );
    }

    return $holidays;
}

/**
 * Count total holidays
 *
 * @since 0.1
 *
 * @return \stdClass
 */
function erp_hr_count_holidays( $args ) {

    $holiday = new Leave_Holiday();
    $holiday = erp_hr_holiday_filter_param( $holiday, $args );

    return $holiday->count();
}

/**
 * Filter parameter for holidays
 *
 * @since 0.1
 *
 * @param  object $holiday
 * @param  array $args
 *
 * @return object
 */
function erp_hr_holiday_filter_param( $holiday, $args ) {

    $args_s = isset( $args['s'] ) ? $args['s'] : '';

    if ( $args_s && ! empty( $args['s'] ) ) {
        $holiday = $holiday->where( 'title', 'LIKE', "%$args_s%" );
    }

    if ( isset( $args['from'] ) && ! empty( $args['from'] ) ) {
        $holiday = $holiday->where( 'start', '>=', $args['from'] );
    }

    if ( isset( $args['to'] ) && ! empty( $args['to'] ) ) {
        $holiday = $holiday->where( 'end', '<=', $args['to'] );
    }

    if ( isset( $args['s'] ) && ! empty( $args['s'] ) ) {
        $holiday = $holiday->orWhere( 'description', 'LIKE', "%$args_s%" );
    }

    return $holiday;
}

/**
 * Remove holidays
 *
 * @since 0.1
 *
 * @return \stdClass
 */
function erp_hr_delete_holidays( $holidays_id ) {

    if ( is_array( $holidays_id ) ) {

        foreach ( $holidays_id as $key => $holiday_id ) {
            do_action( 'erp_hr_leave_holiday_delete', $holiday_id );
        }

        Leave_Holiday::destroy( $holidays_id );

    } else {
        do_action( 'erp_hr_leave_holiday_delete', $holidays_id );

        return Leave_Holiday::find( $holidays_id )->delete();
    }
}

/**
 * Get policies as formatted for dropdown
 *
 * @param array $args data to filter leave policies
 *
 * @return array
 * @since 0.1
 * @since 1.5.15 added $args argument
 *
 *
 */
function erp_hr_leave_get_policies_dropdown_raw( $args = array() ) {
    return wp_list_pluck( erp_hr_leave_get_policies( $args ), 'name', 'id' );
}

/**
 * Delete a policy
 *
 * @since 0.1
 *
 * @param  int|array $policy_ids
 *
 * @return void
 */
function erp_hr_leave_policy_delete( $policy_ids ) {
    if ( ! is_array( $policy_ids ) ) {
        $policy_ids = [ $policy_ids ];
    }

    $policies = Leave_Policy::find( $policy_ids );

    $policies->each( function ( $policy ) {
        $has_entitlements = $policy->entitlements()->count();

        if ( ! $has_entitlements ) {
            $policy->delete();

            do_action( 'erp_hr_leave_policy_delete', $policy );
        }
    } );
}


/**
 * Get assign policies according to employee entitlement
 *
 * @since 0.1
 *
 * @param  integer $employee_id
 *
 * @return boolean|array
 */
function erp_hr_get_assign_policy_from_entitlement( $employee_id, $date = null ) {

    $financial_year_dates = erp_get_financial_year_dates( $date );
    $f_year_ids = get_financial_year_from_date_range( $financial_year_dates['start'], $financial_year_dates['end'] );

    if ( ! is_array( $f_year_ids ) || empty( $f_year_ids ) ) {
        return  false;
    }

    global $wpdb;

    $entitlement_table = "{$wpdb->prefix}erp_hr_leave_entitlements";
    $leave_table = "{$wpdb->prefix}erp_hr_leaves";

     $policies = Leave_Entitlement::select( $entitlement_table . '.id', $leave_table . '.name' )
         ->leftjoin( $leave_table, $entitlement_table . '.leave_id', '=', $leave_table . '.id' )
         ->where( 'trn_type', '=', 'leave_policies' )
         ->where( 'user_id', '=', $employee_id )
         ->where( 'f_year', '=', $f_year_ids[0] )
         ->get()
         ->toArray();

     if ( ! empty( $policies ) ) {
         foreach ( $policies as $policy ) {
             $dropdown[ $policy['id'] ] = stripslashes( $policy['name'] );
         }

         return $dropdown;
     }

    return false;
}

/**
 * Add a new leave request
 *
 * @since 0.1
 * @since 1.5.15
 *
 * @param  array $args
 *
 * @return integet request_id
 */
function erp_hr_leave_insert_request( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'user_id'      => 0,
        'leave_policy' => 0,
        'start_date'   => current_datetime()->getTimestamp(),
        'end_date'     => current_datetime()->getTimestamp(),
        'reason'       => '',
        'status'       => 0
    );

    $args = wp_parse_args( $args, $defaults );

    if ( ! intval( $args['user_id'] ) ) {
        return new WP_Error( 'no-employee', esc_attr__( 'No employee ID provided.', 'erp' ) );
    }

    if ( ! intval( $args['leave_policy'] ) ) {
        return new WP_Error( 'no-policy', esc_attr__( 'No leave policy provided.', 'erp' ) );
    }

    $period = erp_hr_get_work_days_between_dates( $args['start_date'], $args['end_date'] );

    if ( is_wp_error( $period ) ) {
        return $period;
    }

    // get balance
    $entitlement = Leave_Entitlement::find( $args['leave_policy'] );

    if ( ! $entitlement ) {
        return new WP_Error( 'no-entitlement', esc_attr__( 'No entitlement found with given id.', 'erp' ) );
    }

    // validate start and end date
    if ( $args['start_date'] > $args['end_date'] ) {
        return new WP_Error( 'invalid-dates', esc_attr__( 'Invalid date range.', 'erp' ) );
    }

    $current_date = current_datetime()->format('Y-m-d');
    if ( $args['start_date'] < $current_date || $args['end_date'] < $current_date ) {
        return new WP_Error( 'invalid-dates', esc_attr__( 'Invalid date range. You can not apply for past dates.', 'erp' ) );
    }

    // check start_date and end_date are in the same f_year
    $f_year_start = current_datetime()->setTimestamp( $entitlement->financial_year->start_date)->format( 'Y-m-d' );
    $f_year_end = current_datetime()->setTimestamp( $entitlement->financial_year->end_date)->format( 'Y-m-d' );

    if ( ( $args['start_date'] < $f_year_start || $args['start_date'] > $f_year_end ) || ( $args['end_date'] < $f_year_start || $args['end_date'] > $f_year_end )  ) {
        return new WP_Error( 'invalid-dates', sprintf( esc_attr__( 'Invalid leave duration. Please apply between %s and %s.', 'erp' ), erp_format_date( $f_year_start ), erp_format_date( $f_year_end ) ) );
    }

    // handle overlapped leaves
    $leave_record_exist = erp_hrm_is_leave_recored_exist_between_date( $args['start_date'], $args['end_date'], $args['user_id'], $entitlement->f_year );
    if ( $leave_record_exist ) {
        return new WP_Error( 'invalid-dates', esc_attr__( 'Existing Leave Record found within selected range!', 'erp' ) );
    }


    // prepare the periods
    $leaves = array();
    if ( $period['days'] ) {
        foreach ( $period['days'] as $date ) {
            if ( ! $date['count'] ) { // skip if holiday or not working day
                continue;
            }

            $leaves[] = array(
                'date'          => $date['date'],
                'length_hours'  => '08:00:00',
                'length_days'   => '1.00',
                'start_time'    => '00:00:00',
                'end_time'      => '00:00:00',
                'duration_type' => 1
            );
        }
    }

    if ( $leaves ) {

        $request = apply_filters( 'erp_hr_leave_new_args', [
            'user_id'    => $args['user_id'],
            'leave_id'   => $entitlement->leave_id,
            'leave_entitlement_id' => $entitlement->id,
            'day_status_id' => '1',
            'days'       => count( $leaves ),
            'start_date' => current_datetime()->modify( $args['start_date'] )->setTime( 0, 0, 0 )->getTimestamp(),
            'end_date'   => current_datetime()->modify( $args['end_date'] )->setTime( 0, 0, 0 )->getTimestamp(),
            'reason'     => wp_kses_post( $args['reason'] ),
            'created_by' => get_current_user_id(),
            'created_at' => current_datetime()->getTimestamp(),
            'updated_at' => current_datetime()->getTimestamp(),
        ] );

        if ( $wpdb->insert( $wpdb->prefix . 'erp_hr_leave_requests', $request ) ) {
            $request_id = $wpdb->insert_id;

            do_action( 'erp_hr_leave_new', $request_id, $request, $leaves );

            return $request_id;
        }
    }

    return false;
}

/**
 * Fetch a single request
 *
 * @param  int $request_id
 *
 * @return object
 */
function erp_hr_get_leave_request( $request_id ) {
    $request_data = erp_hr_get_leave_requests( array( 'request_id' => $request_id ) );

    if ( isset( $request_data['data'] )  && is_array( $request_data['data'] ) && ! empty( $request_data['data'] ) ) {
        return $request_data['data'][0];
    }

    return null;
}

/**
 * Fetch the leave requests
 *
 * @since 0.1
 *
 * @param  array $args
 *
 * @return array
 */
function erp_hr_get_leave_requests( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'request_id'    => 0,
        'user_id'       => 0,
        'policy_id'     => 0,
        'status'        => 1,
        'year'          => '',
        'f_year'        => '',
        'number'        => 20,
        'offset'        => 0,
        'orderby'       => 'created_at',
        'order'         => 'DESC',
        'start_date'    => '',
        'end_date'      => ''
    );

    $args  = wp_parse_args( $args, $defaults );

    array_walk_recursive( $args, function( &$key, &$value ) {
        $key = sanitize_key( wp_unslash( $key ) );
        $value = sanitize_text_field( $value );
    });

    // fix orderby parameter
    if ( $args['orderby'] == 'created_on' ) {
        $args['orderby'] = 'created_at';
    }

    $cache_key = 'erp_hr_leave_requests_' . md5( serialize( $args ) );
    $requests  = wp_cache_get( $cache_key, 'erp' );

    if ( false !== $requests ) {
        return $requests;
    }

    //return erp_array_to_object( $formatted_data );

    $leave_requests_table = $wpdb->prefix . 'erp_hr_leave_requests';
    $tables = " FROM $leave_requests_table as request";
    $fields = 'SELECT SQL_CALC_FOUND_ROWS request.id, u.display_name';
    $join = " LEFT JOIN {$wpdb->users} as u ON u.ID = request.user_id";
    $where = ' WHERE 1=1';

    $groupby = '';
    $orderby = " ORDER BY request.{$args['orderby']} {$args['order']}";

    $offset = absint( $args['offset'] );
    $number = absint( $args['number'] );
    $limit = $args['number'] == '-1' ? '' : " LIMIT {$offset}, {$number}";

    // filter by request_id

    if ( is_numeric( $args['request_id'] ) && $args['request_id'] > 0 ) {
        $where .= " AND request.id = " . intval( $args['request_id'] );
    }

    // filter by name
    if ( isset( $args['s'] ) && $args['s'] !== '' ) {
        $where .= " AND u.display_name like '%" . esc_sql( trim( $args['s'] ) ) . "%'";
    }

    if ( 'all' != $args['status'] && $args['status'] != '' ) {
        if ( in_array( $args['status'], array( 1, 3 )  ) ) {
            // get accepted and rejected requests
            /*
             * SELECT c.id, cch.leave_request_id, c.user_id, c.leave_id, cch.approval_status_id FROM wp_erp_hr_leave_requests AS c INNER JOIN wp_erp_hr_leave_approval_status AS cch ON cch.leave_request_id = c.id WHERE cch.id = ( SELECT MAX(id) FROM wp_erp_hr_leave_approval_status WHERE leave_request_id = c.id and approval_status_id=1)
             */
            $fields .= ', status1.approval_status_id AS status, status1.message as message';
            $join .= " INNER JOIN {$wpdb->prefix}erp_hr_leave_approval_status AS status1 ON status1.leave_request_id = request.id";
            $where .= " and status1.id = ( SELECT MAX(id) FROM {$wpdb->prefix}erp_hr_leave_approval_status WHERE leave_request_id = request.id and approval_status_id=" . intval( $args['status'] ) . ')';
        }
        else {
            // get pending requests
            $where .= " and NOT EXISTS ( SELECT  null FROM {$wpdb->prefix}erp_hr_leave_approval_status as status WHERE request.id = status.leave_request_id)";
        }
    }
    else {
        // query for all status
        /*
         * select t.id, l1.leave_request_id, t.user_id, l1.approval_status_id, u.display_name from wp_erp_hr_leave_requests t left join wp_users as u on u.ID = t.user_id left join wp_erp_hr_leave_approval_status l1 on t.id = l1.leave_request_id left join wp_erp_hr_leave_approval_status l2 on l1.leave_request_id = l2.leave_request_id and l1.id < l2.id where l2.id is null
         */

        $fields .= ', status1.approval_status_id as status';
        $join .= " left join {$wpdb->prefix}erp_hr_leave_approval_status status1 on request.id = status1.leave_request_id";
        $join .= " left join {$wpdb->prefix}erp_hr_leave_approval_status status2 on status1.leave_request_id = status2.leave_request_id and status1.id < status2.id";
        $where .= ' and status2.id is null';
    }

    if ( $args['user_id'] != '0' ) {
        if ( empty( $where ) ) {
            $where .= " WHERE request.user_id = " . intval( $args['user_id'] );
        } else {
            $where .= " AND request.user_id = " . intval( $args['user_id'] );
        }
    }

    if ( $args['policy_id'] ) {
        $where .= " AND request.leave_id = " . intval( $args['policy_id'] );
    }

    if ( ! empty( $args['year'] ) ) {
        $from_date_string = $args['year'] . '-01-01 00:00:00';
        $from_date = current_datetime();
        $from_date = $from_date->modify( $from_date_string );

        $to_date_string = $args['year'] . '-12-31 00:00:00';
        $to_date = current_datetime();
        $to_date = $to_date->modify( $to_date_string );

        $where .= " AND request.start_date >= {$from_date->getTimestamp()} AND request.end_date <= {$to_date->getTimestamp()}";
    }

    if ( ! empty( $args['f_year'] ) ) {
        $join .= " left join {$wpdb->prefix}erp_hr_leave_entitlements as entl on request.leave_entitlement_id = entl.id";
        $where .= ' and entl.f_year = ' . absint( wp_unslash( $args['f_year'] ) );
    }

    if ( $args['start_date']  && $args['end_date'] ) {
        //dates can be timestamps
        if ( is_numeric( $args['start_date'] ) ) {
            $from_date = current_datetime();
            $from_date = $from_date->setTimestamp( $args['start_date'] );
        }
        else {
            $from_date = current_datetime();
            $from_date = $from_date->modify( $args['start_date'] )->setTime( 0, 0, 0 );
        }

        // dates can be timstamps
        if ( is_numeric( $args['end_date'] ) ) {
            $to_date = current_datetime();
            $to_date = $to_date->setTimestamp( $args['end_date'] );
        }
        else {
            $to_date = current_datetime();
            $to_date = $to_date->modify( $args['end_date'] )->setTime( 23, 59, 59 );
        }

        $where .= " AND request.start_date >= {$from_date->getTimestamp()} AND request.start_date <= {$to_date->getTimestamp()}";
    }

    $query = $fields . $tables . $join . $where . $orderby . $limit;
    $requests = $wpdb->get_results( $query, ARRAY_A );

    $total_row_found = absint( $wpdb->get_var( "SELECT FOUND_ROWS()" ) );

    //echo "<pre>"; print_r( $requests ); die;

    $formatted_data = array();
    $users = array();
    if ( is_array( $requests ) && ! empty( $requests ) ) {

        $available_leaves = array();

        foreach ( $requests as $single_request ) {
            $request = Leave_Request::find( $single_request['id'] );

            // get available days
            if ( ! isset( $available_leaves[ $request->user_id ] ) || ! array_key_exists( $request->leave->id, $available_leaves[ $request->user_id ] ) ) {

                $entitlement = erp_hr_leave_get_entitlement( $request->user_id, $request->leave->id, $request->start_date );

                if ( is_wp_error( $entitlement ) ) {
                    continue;
                }

                $policy_data = erp_hr_leave_get_balance_for_single_policy( $entitlement );

                if ( is_wp_error( $policy_data ) ) {
                    continue;
                }

                $available_leaves[ $request->user_id ][ $request->leave->id ] = $policy_data;
            }

            $available = isset( $available_leaves[ $request->user_id ][ $request->leave->id ] )
                ? $available_leaves[ $request->user_id ][ $request->leave->id ]['available'] : 0;
            $extra = isset( $available_leaves[ $request->user_id ][ $request->leave->id ] )
                ? $available_leaves[ $request->user_id ][ $request->leave->id ]['extra_leave'] : 0;
            $spent = isset( $available_leaves[ $request->user_id ][ $request->leave->id ] )
                ? $available_leaves[ $request->user_id ][ $request->leave->id ]['spent'] : 0;
            $entitlement = isset( $available_leaves[ $request->user_id ][ $request->leave->id ] )
                ? $available_leaves[ $request->user_id ][ $request->leave->id ]['entitlement'] : 0;

            $temp_data = array();
            $temp_data['id']             = $request->id;
            $temp_data['user_id']        = $request->user_id;
            $temp_data['name']           = $single_request['display_name'];
            $temp_data['display_name']   = $single_request['display_name'];
            $temp_data['leave_id']       = $request->leave_id;
            $temp_data['policy_name']    = $request->leave->name;
            $temp_data['start_date']     = $request->start_date;
            $temp_data['end_date']       = $request->end_date;
            $temp_data['days']           = $request->days;
            $temp_data['entitlement']    = $entitlement;
            $temp_data['available']      = $available;
            $temp_data['extra_leaves']    = $extra;
            $temp_data['spent']          = $spent;
            $temp_data['status']         = isset( $single_request['status'] ) ? $single_request['status'] : 2;
            $temp_data['reason']         = $request->reason;
            $temp_data['message']         = isset( $single_request['message'] ) ? $single_request['message'] : '';

            $formatted_data[] =  $temp_data;
        }
    }

    $requests_data = array( 'data' => erp_array_to_object( $formatted_data ), 'total' => $total_row_found );
    wp_cache_set( $cache_key, $requests_data, 'erp', HOUR_IN_SECONDS );

    return $requests_data;
}

/**
 * Get leave requests count
 *
 * @since 0.1
 *
 * @return array
 */
function erp_hr_leave_get_requests_count() {
    global $wpdb;

    $statuses = erp_hr_leave_request_get_statuses();


    $cache_key = 'erp-hr-leave-request-counts';
    $counts   = wp_cache_get( $cache_key, 'erp' );


    if ( false === $counts ) {
        $counts   = array();
        $total = 0;

        foreach ( $statuses as $status => $label ) {
            $counts[ $status ] = array( 'count' => 0, 'label' => $label );
        }

        //get accepted and rejected leave count
        $accepted_rejected_status = $wpdb->get_results(
            "SELECT count(m1.leave_request_id) AS count, m1.approval_status_id AS id FROM {$wpdb->prefix}erp_hr_leave_approval_status m1
                    LEFT JOIN {$wpdb->prefix}erp_hr_leave_approval_status m2 ON (m1.leave_request_id = m2.leave_request_id AND m1.id < m2.id)
                    WHERE m2.id IS NULL GROUP BY m1.approval_status_id", ARRAY_A );

        if ( is_array( $accepted_rejected_status ) && ! empty( $accepted_rejected_status ) ) {
            foreach ( $accepted_rejected_status as $item ) {
                $counts[ $item['id'] ]['count'] = $item['count'];
                $total += $item['count'];
            }
        }

        //get pending leave count
        $pending_count = $wpdb->get_var(
            "SELECT COUNT( DISTINCT(id) ) FROM {$wpdb->prefix}erp_hr_leave_requests as request WHERE NOT EXISTS
            ( SELECT  null FROM {$wpdb->prefix}erp_hr_leave_approval_status as status WHERE request.id = status.leave_request_id)"
        );

        $counts[2]['count'] = $pending_count;
        $total += $pending_count;
        $counts['all']['count'] = $total;


        wp_cache_set( $cache_key, $counts, 'erp' );
    }

    return $counts;
}

/**
 * Update leave request status
 *
 * Statuses and their ids
 * delete -  3
 * reject -  3
 * approve - 1
 * pending - 2
 *
 * @since 0.1
 *
 * @param  integer $request_id
 * @param  string $status
 *
 * @return object Eloquent Leave_request model
 */
function erp_hr_leave_request_update_status( $request_id, $status, $comments = '' ) {

    if ( ! current_user_can( 'erp_leave_manage' ) ) {
        wp_die( esc_html__( 'You do not have sufficient permissions to do this action', 'erp' ) );
    }

    $request = Leave_request::find( $request_id );

    if ( empty( $request ) ) {
        return new WP_Error( 'no-request-found', __( 'Invalid leave request', 'erp' ) );
    }

    $status = absint( $status );

    $old_leave_status = isset( $request->latest_approval_status->approval_status_id ) ? absint( $request->latest_approval_status->approval_status_id ) : 2; // by default status is pending

    // return if old and new status are same.
    if ( $old_leave_status == $status ) {
        return new WP_Error( 'no-leave-status', __( 'Invalid leave status. Please check your input.', 'erp' ) );
    }

    // check if reject reason exist
    if ( $status === 3 && $comments === '' ) {
        return new WP_Error( 'no-leave-reason', __( 'Please provide a reject reason for given leave request.', 'erp' ) );
    }

    // get entitlements
    if ( ! $request->entitlement->id ) {
        return new WP_Error( 'invalid-entitlement', __( 'No Entitlement found for given request.', 'erp' ) );
    }

    // past records can't be edited
    $financial_years = array();
    $current_start_date = current_datetime()->modify( erp_financial_start_date() )->getTimestamp();
    foreach ( Financial_Year::all() as $f_year ) {
        if ( $f_year['start_date'] < $current_start_date ) {
            continue;
        }
        $financial_years[ $f_year['id'] ] = $f_year['fy_name'];
    }

    if ( ! array_key_exists( $request->entitlement->f_year, $financial_years ) ) {
        return new WP_Error( 'invalid-entitlement', __( 'Error: You can not modify past financial year requests.', 'erp' ) );
    }

    // approval status table data
    $approval_status_data = array(
        'leave_request_id'      => $request_id,
        'approval_status_id'    => $status,
        'approved_by'           => get_current_user_id(),
        'approved_date'         => current_datetime()->getTimestamp(),
    );

    // leave entitlement table data
    $entitlement_data = array(
        'user_id'       => $request->user_id,
        'leave_id'      => $request->leave_id,
        'created_by'    => get_current_user_id(),
        'trn_id'        => 0,
        'trn_type'      => 'leave_approval_status',
        'description'   => '',
        'day_in'        => 0,
        'day_out'       => 0,
        'f_year'        => 0,
    );

    // unpaid leave table data
    $unpaid_leave_data = array(
        'leave_id'                  => $request->leave_id,
        'leave_request_id'          => $request_id,
        'leave_approval_status_id'  => 0,
        'user_id'                   => $request->user_id,
        'days'                      => 0,
    );

    //
    switch ( $old_leave_status ) {
        case 1: // approved
            if ( $status === 3 ) { // reject this request
                // 1. Get latest approval_status_id for current request
                if ( ! $request->latest_approval_status->id ) {
                    return new WP_Error( 'no-approval-status', esc_attr__( 'Invalid Request: No previous records found for given request.') );
                }
                $old_approval_status_id = $request->latest_approval_status->id;

                // 2. Add new approval status record
                $approval_status_data['message'] = $comments;
                $approval_status = Leave_Approval_Status::create( $approval_status_data );

                // 3. Add new leave entitlement record
                $entitlement_data['day_in']     = $request->days;
                $entitlement_data['f_year']     = $request->entitlement->f_year;
                $entitlement_data['trn_id']     = $approval_status->id;
                $entitlement_data['description'] = 'Rejected';
                $leave_entitlement = Leave_Entitlement::create( $entitlement_data );

                // 4. Delete data from leave request details table
                $deleted = Leave_Request_Detail::where( 'leave_request_id', '=', $request->id )->delete();

                // 5. Delete data from unpaid leave table
                $deleted = Leaves_Unpaid::where( 'leave_request_id', '=', $request->id )->delete();

                // 6. Delete data from entitlement table for trn_type = unpaid leave
                $deleted = Leave_Entitlement::where('trn_id', '=', $old_approval_status_id )
                                            ->where( 'trn_type', '=', 'unpaid_leave' )->delete();
            }
            break;

        case 2: // pending
        case 3: // rejected
            if ( $status === 1 ) { // approve this request
                // 0. check if we are in the same financial year
                $f_year_start = $request->entitlement->financial_year->start_date;
                $f_year_end = $request->entitlement->financial_year->end_date;

                if ( ( $request->start_date < $f_year_start || $request->start_date > $f_year_end ) || ( $request->end_date < $f_year_start || $request->end_date > $f_year_end )  ) {
                    return new WP_Error( 'invalid-date-range', sprintf( esc_attr__( 'Invalid leave duration. Please apply between %s and %s.', 'erp' ), erp_format_date( $f_year_start ), erp_format_date( $f_year_end ) ) );
                }

                // 1. check if we got same date range already approved
                $leave_exist = erp_hrm_is_leave_recored_exist_between_date( $request->start_date, $request->end_date, $request->user_id, $request->entitlement->f_year );

                if ( $leave_exist ) {
                    return new WP_Error( 'leave-exist', esc_attr__( 'Approved leave request found within given range!', 'erp' ) );
                }

                $balance = erp_hr_leave_get_balance_for_single_entitlement( $request->entitlement->id );
                if ( empty( $balance ) ) {
                    return new WP_Error( 'invalid-entitlement-id', esc_attr__( 'No entitlement found for given request. Please check your input.', 'erp' ) );
                }

                $work_days = erp_hr_get_work_days_between_dates( erp_format_date( $request->start_date ), erp_format_date( $request->end_date ) );

                if ( is_wp_error( $work_days ) ) {
                    return $work_days;
                }

                $extra_days = 0;

                // 2. check if leave available
                if ( $request->days > $balance['available'] ) {
                    // check if extra leaves enabled
                    $is_extra_leave_enabled = get_option( 'enable_extra_leave', 'no' );

                    if ( $is_extra_leave_enabled !== 'yes' ) {
                        return new WP_Error( 'extra-leave-disabled', esc_attr__( 'Sorry! given request do not have any leave left under this leave policy. If you still want to process this request, please enable Extra Leave feature from settings.', 'erp' ) );
                    }

                    // some days are unpaid leaves
                    $extra_days = $request->days - $balance['available'];
                }

                // 3. send data to leave approval status table
                $approval_status = Leave_Approval_Status::create( $approval_status_data );

                // 4. send data to leave entitlement table - day out
                $entitlement_data['day_out']    = $request->days;
                $entitlement_data['f_year']     = $request->entitlement->f_year;
                $entitlement_data['trn_id']     = $approval_status->id;
                $entitlement_data['description'] = 'Approved';

                $leave_entitlement = Leave_Entitlement::create( $entitlement_data );

                // 5. send data to request details table
                $leave_request_details_data = array();
                foreach ( $work_days['days'] as $work_day ) {
                    $leave_request_details_data[] = array(
                        'leave_request_id'          => $request_id,
                        'leave_approval_status_id'  => $approval_status->id,
                        'workingday_status'         => $work_day['count'],
                        'user_id'                   => $request->user_id,
                        'f_year'                    => $request->entitlement->f_year,
                        'leave_date'                => current_datetime()->modify( $work_day['date'] )->setTime( 0, 0, 0 )->getTimestamp(),
                        'created_at'                => current_datetime()->getTimestamp(),
                        'updated_at'                => current_datetime()->getTimestamp(),
                    );
                }

                if ( ! empty( $leave_request_details_data ) )  {
                    $request_details = Leave_Request_Detail::insert( $leave_request_details_data );
                }

                // 6. insert extra if exist
                if ( $extra_days ) {
                    // 1. insert into leave entitlement table
                    $entitlement_data['day_in']     = $extra_days;
                    $entitlement_data['day_out']    = 0;
                    $entitlement_data['trn_type']   = 'unpaid_leave';
                    $entitlement_data['description'] = 'Account';

                    $second_leave_entitlement = Leave_Entitlement::create( $entitlement_data );

                    // 2. insert into unpaid leave table
                    $unpaid_leave_data['days'] = $extra_days;
                    $unpaid_leave_data['leave_approval_status_id'] = $approval_status->id;
                    $unpaid_leave = Leaves_Unpaid::create( $unpaid_leave_data );
                }
            }
            elseif ( $status === 3 ) { // reject this request
                // 1. send data to leave approval status table
                $approval_status_data['message'] = $comments;
                $approval_status = Leave_Approval_Status::create( $approval_status_data );
            }
            break;

        default:
            return new WP_Error( 'invalid-status', esc_attr__( 'Invalid leave request status.', 'erp' ) );
            break;
    }

    // notification email
    if ( 1 === $status ) {

        $approved_email = wperp()->emailer->get_email( 'Approved_Leave_Request' );

        if ( is_a( $approved_email, '\WeDevs\ERP\Email' ) ) {
            $approved_email->trigger( $request_id );
        }

    } else if ( 3 === $status ) {

        $rejected_email = wperp()->emailer->get_email( 'Rejected_Leave_Request' );

        if ( is_a( $rejected_email, '\WeDevs\ERP\Email' ) ) {
            $rejected_email->trigger( $request_id );
        }
    }

    $status = ( $status == 1 ) ? 'approved' : 'pending';

    do_action( "erp_hr_leave_request_{$status}", $request_id, $request );

    return $request;
}

/**
 * Get leave requests status
 *
 * added filter `erp_hr_leave_approval_statuses` on version 1.5.15
 *
 * @since 0.1
 *
 * @param  int|boolean $status
 *
 * @return array|string
 */
function erp_hr_leave_request_get_statuses( $status = false ) {
    $statuses = apply_filters( 'erp_hr_leave_approval_statuses', array(
        'all' => esc_attr__( 'All', 'erp' ),
        '1'   => esc_attr__( 'Approved', 'erp' ),
        '2'   => esc_attr__( 'Pending', 'erp' ),
        '3'   => esc_attr__( 'Rejected', 'erp' )
    ) );

    if ( false !== $status && array_key_exists( $status, $statuses ) ) {
        return $statuses[ $status ];
    }

    return $statuses;
}

/**
 * Entitlement checking
 *
 * Check if an employee has already entitled to a policy in
 * a certain calendar year
 *
 * @since 0.1
 *
 * @param  integer $employee_id
 * @param  integer $policy_id
 * @param  integer $year
 *
 * @return bool
 */
function erp_hr_leave_has_employee_entitlement( $employee_id, $policy_id, $year ) {
    global $wpdb;

    $from_date = $year . '-01-01';
    $to_date   = $year . '-12-31';

    $query  = "SELECT id FROM {$wpdb->prefix}erp_hr_leave_entitlements
        WHERE user_id = %d AND policy_id = %d AND from_date = %s AND to_date = %s";
    $result = $wpdb->get_var( $wpdb->prepare( $query, $employee_id, $policy_id, $from_date, $to_date ) );

    return $result;
}

/**
 * Get Leave Entitlement For A User
 * @param array $args
 */
function erp_hr_leave_get_entitlement( $user_id, $leave_id, $start_date ) {
    global $wpdb;
    // get financial year from date
    $financial_year_dates = erp_get_financial_year_dates( $start_date );
    $f_year_ids = get_financial_year_from_date_range( $financial_year_dates['start'], $financial_year_dates['end'] );
    if ( empty( $f_year_ids ) ) {
        return new WP_Error( 'invalid-financial-year', esc_attr__( 'No financial year found with given date.', 'erp' ) );
    }
    $f_year = $f_year_ids[0];

    // get entitlement
    $entitlement = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}erp_hr_leave_entitlements WHERE user_id = %d and leave_id = %d and f_year = %d and trn_type = %s",
            array( $user_id, $leave_id, $f_year, 'leave_policies' )
        )
    );

    if ( null === $entitlement ) {
        return new WP_Error( 'invalid-leave-entitlement', esc_attr__( 'No entitlement found.', 'erp' ) );
    }

    return $entitlement;
}

/**
 * Get all the leave entitlements of a calendar year
 *
 * @since 0.1
 * @since 1.2.0 Depricate `year` arg and using `from_date` and `to_date` instead
 *
 * @param  integer $year
 *
 * @return array
 */
function erp_hr_leave_get_entitlements( $args = array() ) {
    global $wpdb;

    // get default financial year
    $f_year = 0;
    $financial_year_dates = erp_get_financial_year_dates();
    $f_year_ids = get_financial_year_from_date_range( $financial_year_dates['start'], $financial_year_dates['end'] );
    if ( ! empty( $f_year_ids ) ) {
        $f_year = $f_year_ids[0];
    }

    $defaults = array(
        'user_id'       => 0,
        'leave_id'      => 0,
        'year'          => $f_year,
        'number'        => 20,
        'offset'        => 0,
        'orderby'       => 'en.user_id, en.created_at',
        'order'         => 'DESC',
        'debug'         => false,
        'emp_status'    => ''
    );

    $args  = wp_parse_args( $args, $defaults );
    $where = "WHERE 1 = 1 AND en.trn_type = 'leave_policies'";

    /**
     * @deprecated 1.2.0 Use $args['from_date'] and $args['to_date'] instead
     */
    if ( ! empty( $args['year'] ) ) {
        $where     .= " AND en.f_year = " . absint( $args['year'] );
    }

    if ( $args['user_id'] ) {
        $where .= " AND en.user_id = " . absint( $args['user_id'] );
    }

    if ( ! empty( $args['search'] ) ) {
        $where .= $wpdb->prepare(" AND u.display_name LIKE '%%%s%%' ", $args['search'] );
    }

    if ( $args['leave_id'] ) {
        $where .= " AND en.leave_id = " . absint( $args['leave_id'] );
    }

    if ( $args['emp_status'] == 'active') {
        $where .= " AND emp.status = 'active'";
    }

    $query = "SELECT SQL_CALC_FOUND_ROWS en.*, u.display_name as employee_name, l.name as policy_name, emp.status as emp_status
        FROM `{$wpdb->prefix}erp_hr_leave_entitlements` AS en
        LEFT JOIN {$wpdb->prefix}erp_hr_leaves AS l ON l.id = en.leave_id
        LEFT JOIN {$wpdb->users} AS u ON en.user_id = u.ID
        LEFT JOIN {$wpdb->prefix}erp_hr_employees AS emp ON en.user_id = emp.user_id
        $where
        ORDER BY {$args['orderby']} {$args['order']}
        LIMIT %d,%d;";

    $sql     = $wpdb->prepare( $query, absint( $args['offset'] ), absint( $args['number'] ) );
    $results = $wpdb->get_results( $sql );

    $total_row_found = absint( $wpdb->get_var( "SELECT FOUND_ROWS()" ) );

    return array( 'data' => $results, 'total' => $total_row_found );
}

/**
 * Count leave entitlement
 *
 * @since 0.1
 *
 * @param  array $args
 *
 * @return integer
 */
function erp_hr_leave_count_entitlements( $args = array() ) {
    $financial_year_dates = erp_get_financial_year_dates();

    $defaults = [
        'from_date' => $financial_year_dates['start'],
        'to_date'   => $financial_year_dates['end']
    ];

    $args = wp_parse_args( $args, $defaults );

    return Leave_Entitlement::where( 'from_date', '>=', $args['from_date'] )
                                                   ->where( 'to_date', '<=', $args['to_date'] )
                                                   ->count();
}

/**
 * Delete entitlement with leave request
 *
 * @since 0.1
 *
 * @param  integer $id
 * @param  integer $user_id
 * @param  integer $policy_id
 *
 * @return void
 */
function erp_hr_delete_entitlement( $id, $user_id, $policy_id ) {
//    $leave_recored = \WeDevs\ERP\HRM\Models\Leave_request::where( 'user_id', '=', $user_id )
//                                                         ->where( 'policy_id', '=', $policy_id )->get()->toArray();
//    $leave_recored = wp_list_pluck( $leave_recored, 'status' );
//
//    if ( in_array( '1', $leave_recored ) ) {
//        return;
//    }
//
//    if ( \WeDevs\ERP\HRM\Models\Leave_Entitlement::find( $id )->delete() ) {
//        return \WeDevs\ERP\HRM\Models\Leave_request::where( 'user_id', '=', $user_id )
//                                                   ->where( 'policy_id', '=', $policy_id )
//                                                   ->delete();
//    }

    return Leave_Entitlement::find( $id )->delete();
}

/**
 * Erp get leave balance
 *
 * @since 0.1
 * @since 1.1.18 Add start_date in where clause
 * @since 1.2.1  Fix main query statement
 * @since 1.5.15 changed according to new db structure
 *
 * @param  integer $user_id
 *
 * @return float|boolean
 */
function erp_hr_leave_get_balance( $user_id, $date = null ) {
    global $wpdb;

    $query = "select en.id, en.leave_id, en.day_in, en.f_year, fy.start_date, fy.end_date, l.name as policy_name";
    $query .= " from {$wpdb->prefix}erp_hr_leave_entitlements as en";
    $query .= " LEFT JOIN {$wpdb->prefix}erp_hr_financial_years as fy on fy.id = en.f_year";
    $query .= " LEFT JOIN {$wpdb->prefix}erp_hr_leaves as l on l.id = en.leave_id";
    $query .= " where user_id = %d and trn_type='leave_policies'";

    if ( $date !== null ) {
        $query .= " and fy.id = " . absint( $date );
    }

    $results = $wpdb->get_results( $wpdb->prepare( $query, $user_id ) );

    $balance = [];

    if ( ! empty( $results ) ) {
        foreach ( $results as $result ) {
            $days_count = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT sum(day_in) as day_in, sum(day_out) as day_out FROM {$wpdb->prefix}erp_hr_leave_entitlements WHERE user_id = %d AND leave_id = %d and f_year = %d ",
                    array( $user_id, $result->leave_id, $result->f_year )
                ),
                ARRAY_A
            );

            if ( is_array( $days_count ) && ! empty( $days_count ) ) {
                $day_in = floatval( $days_count['day_in'] );
                $day_out = floatval( $days_count['day_out'] );

                // check for extra leave
                $extra_leave = 0 ;
                $available = $day_in - $day_out;
                if ( $available == 0 ) {
                    $extra_leave = $wpdb->get_var(
                        $wpdb->prepare(
                            "SELECT sum(day_in) as day_in FROM {$wpdb->prefix}erp_hr_leave_entitlements WHERE user_id = %d AND leave_id = %d and f_year = %d AND trn_type = %s",
                            array( $user_id, $result->leave_id, $result->f_year, 'unpaid_leave' )
                        )
                    );
                }

                $balance[ $result->leave_id ] = array(
                    'entitlement_id' => $result->id,
                    'days'          => $result->day_in,
                    'from_date'     => $result->start_date,
                    'to_date'       => $result->end_date,
                    'leave_id'      => $result->leave_id,
                    'policy'        => $result->policy_name,
                    'scheduled'     => 0,
                    'entitlement'   => $result->day_in,
                    'total'         => $day_in,
                    'available'     => $available,
                    'extra_leave'   => $extra_leave,
                    'day_in'        => $day_in,
                    'day_out'       => $day_out,
                    'spent'         => $day_out,
                );
            }
        }
    }

    return $balance;
}

/**
 * Erp get leave balance for a single entitlement
 *
 * @since 1.5.15
 *
 * @param  integer $user_id
 *
 * @return float|boolean
 */
function erp_hr_leave_get_balance_for_single_entitlement( $entitlement_id ) {
    global $wpdb;

    $query = "select en.id, en.user_id, en.leave_id, en.day_in, en.f_year, fy.start_date, fy.end_date, l.name as policy_name";
    $query .= " from {$wpdb->prefix}erp_hr_leave_entitlements as en";
    $query .= " LEFT JOIN {$wpdb->prefix}erp_hr_financial_years as fy on fy.id = en.f_year";
    $query .= " LEFT JOIN {$wpdb->prefix}erp_hr_leaves as l on l.id = en.leave_id";
    $query .= " where en.id = %d";

    $result = $wpdb->get_row( $wpdb->prepare( $query, $entitlement_id ) );

    $balance = [];

    if ( ! empty( $result ) ) {
        $days_count = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT sum(day_in) as day_in, sum(day_out) as day_out FROM {$wpdb->prefix}erp_hr_leave_entitlements WHERE user_id = %d AND leave_id = %d and f_year = %d ",
                array( $result->user_id, $result->leave_id, $result->f_year )
            ),
            ARRAY_A
        );

        if ( is_array( $days_count ) && ! empty( $days_count ) ) {
            $day_in = floatval( $days_count['day_in'] );
            $day_out = floatval( $days_count['day_out'] );

            // check for extra leave
            $extra_leave = 0 ;
            $available = $day_in - $day_out;
            if ( $available == 0 ) {
                $extra_leave = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT sum(day_in) as day_in FROM {$wpdb->prefix}erp_hr_leave_entitlements WHERE user_id = %d AND leave_id = %d and f_year = %d AND trn_type = %s",
                        array( $result->user_id, $result->leave_id, $result->f_year, 'unpaid_leave' )
                    )
                );
            }

            $balance = array(
                'entitlement_id' => $result->id,
                'f_year'         => $result->f_year,
                'days'          => $result->day_in,
                'from_date'     => $result->start_date,
                'to_date'       => $result->end_date,
                'leave_id'      => $result->leave_id,
                'policy'        => $result->policy_name,
                'scheduled'     => 0,
                'entitlement'   => $result->day_in,
                'total'         => $day_in,
                'available'     => $available,
                'extra_leave'   => $extra_leave,
                'day_in'        => $day_in,
                'day_out'       => $day_out,
                'spent'         => $day_out,
            );
        }
    }

    return $balance;
}

/**
 * Erp get leave balance for a single policy for a user
 *
 * @since 1.5.15
 *
 * @param  integer|object $leave_entitlement_id
 *
 * @return float|boolean
 */
function erp_hr_leave_get_balance_for_single_policy( $entitlement ) {
    global $wpdb;

    if ( is_int( $entitlement ) ) {
        $entitlement = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}erp_hr_leave_entitlements WHERE id = %d AND trn_type = %s",
                array( $entitlement, 'leave_policies' )
            )
        );
    }

    if ( ! is_object( $entitlement ) ) {
        return new WP_Error( 'invalid-entitlement-object', esc_attr__( 'Invalid entitlement data.', 'erp' ) );
    }

    $days_count = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT sum(day_in) as day_in, sum(day_out) as day_out FROM {$wpdb->prefix}erp_hr_leave_entitlements WHERE user_id = %d AND leave_id = %d and f_year = %d ",
            array( $entitlement->user_id, $entitlement->leave_id, $entitlement->f_year )
        ),
        ARRAY_A
    );

    $day_in = floatval( $days_count['day_in'] );
    $day_out = floatval( $days_count['day_out'] );
    $extra_leave = 0 ;
    $available = $day_in - $day_out;
    if ( $available == 0 ) {
        $extra_leave = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT sum(day_in) as day_in FROM {$wpdb->prefix}erp_hr_leave_entitlements WHERE user_id = %d AND leave_id = %d and f_year = %d AND trn_type = %s",
                array( $entitlement->user_id, $entitlement->leave_id, $entitlement->f_year, 'unpaid_leave' )
            )
        );
    }

    return array(
        'leave_id'      => $entitlement->leave_id,
        'scheduled'     => 0,
        'entitlement'   => $entitlement->day_in,
        'total'         => $day_in,
        'spent'         => $day_out,
        'available'     => $available,
        'extra_leave'   => $extra_leave
    );
}

/**
 * Get cuurent month approve leave request list
 *
 * @since 0.1
 * @since 1.2.0 Ignore terminated employees
 * @since 1.2.2 Exclude past requests
 *              Sort results by start_date
 *
 * @return array
 */
function erp_hr_get_current_month_leave_list() {
    $end_of_current_month = current_datetime()->modify('last day of this month')->setTime( 23, 59, 59 );
    $args = array(
        'status'        => 1, // get only approved
        'start_date'    => current_datetime()->setTime(0, 0)->getTimestamp(),
        'end_date'      => $end_of_current_month->getTimestamp()
    );
    $leave_requests = erp_hr_get_leave_requests( $args );
    return $leave_requests['data'];
}

/**
 * Get next month leave request approved list
 *
 * @since 0.1
 * @since 1.2.0 Ignore terminated employees
 * @since 1.2.2 Sort results by start_date
 *
 * @return array
 */
function erp_hr_get_next_month_leave_list() {
    $args = array(
        'status'        => 1, // get only approved
        'start_date'    => current_datetime()->modify( 'first day of next month' )->setTime( 0, 0 )->getTimestamp(),
        'end_date'      => current_datetime()->modify( 'last day of next month' )->setTime( 23, 59, 59 )->getTimestamp()
    );
    $leave_requests = erp_hr_get_leave_requests( $args );
    return $leave_requests['data'];
}


/**
 * Leave period dropdown at entitlement create time
 *
 * @since 0.1
 *
 * @return void
 */
function erp_hr_leave_period() {

    $next_sart_date = date( 'Y-m-01 H:i:s', strtotime( '+1 year', strtotime( erp_financial_start_date() ) ) );
    $next_end_date  = date( 'Y-m-t H:i:s', strtotime( '+1 year', strtotime( erp_financial_end_date() ) ) );

    $date = [
        erp_financial_start_date() => erp_format_date( erp_financial_start_date() ) . ' - ' . erp_format_date( erp_financial_end_date() ),
        $next_sart_date            => erp_format_date( $next_sart_date ) . ' - ' . erp_format_date( $next_end_date )
    ];

    return $date;
}

/**
 * Apply entitlement yearly
 *
 * @since 0.1
 *
 * @return void
 */
function erp_hr_apply_entitlement_yearly() {

    $financial_start_date = erp_financial_start_date();
    $financial_end_date   = erp_financial_end_date();

    $before_financial_start_date = date( 'Y-m-01 H:i:s', strtotime( '-1 year', strtotime( $financial_start_date ) ) );
    $before_financial_end_date   = date( 'Y-m-t H:i:s', strtotime( '+11 month', strtotime( $before_financial_start_date ) ) );

    $entitlement = new Leave_Entitlement();

    $entitlement = $entitlement->where( function ( $condition ) use ( $before_financial_start_date, $before_financial_end_date ) {
        $condition->where( 'from_date', '>=', $before_financial_start_date );
        $condition->where( 'to_date', '<=', $before_financial_end_date );
    } );

    $entitlements = $entitlement->get()->toArray();

    foreach ( $entitlements as $key => $entitlement ) {

        $policy = array(
            'user_id'   => $entitlement['user_id'],
            'policy_id' => $entitlement['policy_id'],
            'days'      => $entitlement['days'],
            'from_date' => erp_financial_start_date(),
            'to_date'   => erp_financial_end_date(),
            'comments'  => $entitlement['comments']
        );

        erp_hr_leave_insert_entitlement( $policy );
    }
}

/**
 * Get calendar leave events
 *
 * @param   array|boolean $get filter args
 * @param   int|boolean $user_id Get leaves for given user only
 * @param   boolean $approved_only Get leaves which are approved
 *
 * @since 0.1
 *
 * @return array
 */
function erp_hr_get_calendar_leave_events( $get = false, $user_id = false, $approved_only = false ) {

    global $wpdb;

    $employee_tb = $wpdb->prefix . 'erp_hr_employees';
    $users_tb    = $wpdb->users;
    $request_tb  = $wpdb->prefix . 'erp_hr_leave_requests';
    $policy_tb   = $wpdb->prefix . 'erp_hr_leave_policies';

    $employee      = new \WeDevs\ERP\HRM\Models\Employee();
    $leave_request = new \WeDevs\ERP\HRM\Models\Leave_Request();

    $department  = isset( $get['department'] ) && ! empty( $get['department'] ) && $get['department'] != '-1' ? intval( $get['department'] ) : false;
    $designation = isset( $get['designation'] ) && ! empty( $get['designation'] ) && $get['designation'] != '-1' ? intval( $get['designation'] ) : false;

    $leave_request = $leave_request->where( $request_tb . '.status', '!=', 3 );

    if ( ! $get ) {
        $request = $leave_request->leftJoin( $users_tb, $request_tb . '.user_id', '=', $users_tb . '.ID' )
                                 ->leftJoin( $policy_tb, $request_tb . '.policy_id', '=', $policy_tb . '.id' )
                                 ->select( $users_tb . '.display_name', $request_tb . '.*', $policy_tb . '.color' );

        if ( $user_id ) {
            $request = $request->where( $request_tb . '.user_id', $user_id );
        }

        if ( $approved_only ) {
            $request = $request->where( $request_tb . '.status', 1 );
        }

        return erp_array_to_object( $request->get()->toArray() );
    }

    if ( $department && $designation ) {
        $leave_requests = $leave_request->leftJoin( $employee_tb, $request_tb . '.user_id', '=', $employee_tb . '.user_id' )
                                        ->leftJoin( $users_tb, $request_tb . '.user_id', '=', $users_tb . '.ID' )
                                        ->leftJoin( $policy_tb, $request_tb . '.policy_id', '=', $policy_tb . '.id' )
                                        ->select( $users_tb . '.display_name', $request_tb . '.*', $policy_tb . '.color' )
                                        ->where( $employee_tb . '.designation', '=', $designation )
                                        ->where( $employee_tb . '.department', '=', $department );

        if ( $approved_only ) {
            $leave_requests = $leave_requests->where( $request_tb . '.status', 1 );
        }

        $leave_requests = erp_array_to_object( $leave_requests->get()->toArray() );

    } else if ( $designation ) {
        $leave_requests = $leave_request->leftJoin( $employee_tb, $request_tb . '.user_id', '=', $employee_tb . '.user_id' )
                                        ->leftJoin( $users_tb, $request_tb . '.user_id', '=', $users_tb . '.ID' )
                                        ->leftJoin( $policy_tb, $request_tb . '.policy_id', '=', $policy_tb . '.id' )
                                        ->select( $users_tb . '.display_name', $request_tb . '.*', $policy_tb . '.color' )
                                        ->where( $employee_tb . '.designation', '=', $designation );

        if ( $approved_only ) {
            $leave_requests = $leave_requests->where( $request_tb . '.status', 1 );
        }

        $leave_requests = erp_array_to_object( $leave_requests->get()->toArray() );

    } else if ( $department ) {
        $leave_requests = $leave_request->leftJoin( $employee_tb, $request_tb . '.user_id', '=', $employee_tb . '.user_id' )
                                        ->leftJoin( $users_tb, $request_tb . '.user_id', '=', $users_tb . '.ID' )
                                        ->leftJoin( $policy_tb, $request_tb . '.policy_id', '=', $policy_tb . '.id' )
                                        ->select( $users_tb . '.display_name', $request_tb . '.*', $policy_tb . '.color' )
                                        ->where( $employee_tb . '.department', '=', $department );

        if ( $approved_only ) {
            $leave_requests = $leave_requests->where( $request_tb . '.status', 1 );
        }

        $leave_requests = erp_array_to_object( $leave_requests->get()->toArray() );
    }

    return $leave_requests;
}

/**
 * Get year ranges based on available financial years
 *
 * @since 1.2.0
 *
 * @return array
 */
function get_entitlement_financial_years() {
    $db     = \WeDevs\ORM\Eloquent\Facades\DB::instance();
    $prefix = $db->db->prefix;

    $min_max_dates = $db->table( 'erp_hr_leave_entitlements' )
                        ->select( $db->raw( 'min( `from_date` ) as min' ), $db->raw( 'max( `to_date` ) max' ) )
                        ->first();

    $start_year = $end_year = current_time( 'Y' );

    if ( ! empty( $min_max_dates->min ) ) {
        $min_date_fy_year = get_financial_year_from_date( $min_max_dates->min );

        $start_year = $min_date_fy_year['start'];
        $end_year   = date( 'Y', strtotime( $min_max_dates->max ) );

    } else {
        return [];
    }

    $start_month = erp_get_option( 'gen_financial_month', 'erp_settings_general', 1 );

    $years = [];

    for ( $i = $start_year; $i <= $end_year; $i ++ ) {
        if ( 1 === absint( $start_month ) ) {
            $years[] = $i;

        } else if ( ! ( ( $i + 1 ) > $end_year ) ) {
            $years[] = $i . '-' . ( $i + 1 );

        } else if ( $start_year === $end_year ) {
            $years[] = ( $i - 1 ) . '-' . $i;
        }
    }

    return $years;
}

/**
 * Generate leave reports
 *
 * @since 1.3.2
 *
 * @param array $employees
 * @param null $start_date
 * @param null $end_date
 *
 * @return array
 *
 */
function erp_get_leave_report( array $employees, $start_date = null, $end_date = null ) {
    $year_dates = erp_get_financial_year_dates( date( 'Y-m-d' ) );
    if ( ! $start_date ) {
        $start_date = $year_dates['start'];
    }
    if ( ! $end_date ) {
        $end_date = $year_dates['end'];
    }
    $employees_report = \WeDevs\ERP\HRM\Models\Employee::whereIn( 'user_id', $employees );
    $employees_report = $employees_report->select( 'user_id' )
                                         ->with( [
                                             'leave_requests' => function ( $q ) use ( $start_date, $end_date ) {
                                                 $q->where( 'status', '=', '1' )
                                                   ->whereDate( 'start_date', '>=', $start_date )
                                                   ->whereDate( 'end_date', '<=', $end_date );
                                             },
                                             'entitlements'   => function ( $q ) use ( $start_date, $end_date ) {
                                                $entitlement_start_date = date('Y', strtotime( $start_date ) ) . '-01-01';
                                                $entitlement_end_date   = date('Y', strtotime( $end_date ) ) . '-12-31';

                                                $q->whereDate( 'from_date', '>=', $entitlement_start_date )
                                                   ->whereDate( 'to_date', '<=', $entitlement_end_date )
                                                   ->JoinWithPolicy();
                                             }
                                         ] )
                                         ->get();

    $reports = [];
    foreach ( $employees_report as $employee_report ) {
        $entitlements = [];
        foreach ( $employee_report->entitlements as $entitlement ) {
            $report = [
                'entitlement_id' => $entitlement->id,
                'days'           => $entitlement->days,
                'from_date'      => $entitlement->from_date,
                'to_date'        => $entitlement->to_date,
                'policy'         => $entitlement->name,
                'policy_id'      => $entitlement->policy_id,
                'color'          => $entitlement->color,
                'spent'          => 0,
            ];

            $entitlements[ $entitlement->policy_id ] = $report;
        }

        foreach ( $employee_report->leave_requests as $leave_report ) {
            if ( isset( $entitlements[ $leave_report->policy_id ] ) ) {
                $entitlements[ $leave_report->policy_id ]['spent'] += $leave_report->days;
            }

            $reports[ $employee_report->user_id ] = $entitlements;
        }

    }

    return $reports;
}

/**
 * Assign policy bulk
 *
 * @since 1.3.2
 *
 * @param $policy
 * @param array $employee_ids
 *
 */
function erp_bulk_policy_assign( $policy, $employee_ids = [] ) {
    if ( is_int( $policy ) ) {
        $policy = Leave_Policy::find( $policy );
    }

    $db     = \WeDevs\ORM\Eloquent\Facades\DB::instance();
    $prefix = $db->db->prefix;
    global $wpdb;

    $employees = $db->table( 'erp_hr_employees as employee' )
                    ->select( 'employee.user_id' )
                    ->leftJoin( "{$prefix}usermeta as gender", function ( $join ) {
                        $join->on( 'employee.user_id', '=', 'gender.user_id' )->where( 'gender.meta_key', '=', 'gender' );
                    } )
                    ->leftJoin( "{$prefix}usermeta as marital_status", function ( $join ) {
                        $join->on( 'employee.user_id', '=', 'marital_status.user_id' )->where( 'marital_status.meta_key', '=', 'marital_status' );
                    } )
                    ->where( 'status', '=', 'active' );
    if ( ! empty( $employee_ids ) && is_array( $employee_ids ) ) {
        $employees->whereIn( 'employee.user_id', $employee_ids );
    }

    if ( $policy->department > 0 ) {
        $employees->where( 'department', $policy->department );
    }

    if ( $policy->designation > 0 ) {
        $employees->where( 'designation', $policy->designation );
    }

    if ( $policy->location > 0 ) {
        $employees->where( 'location', $policy->location );
    }

    if ( $policy->gender != - 1 ) {
        $employees->where( 'gender.meta_value', $policy->gender );
    }

    if ( $policy->marital != - 1 ) {
        $employees->where( 'marital_status.meta_value', $policy->marital );
    }

    if ( $policy->activate == 2 && ! empty( $policy->execute_day ) ) {
        $current_date = date( 'Y-m-d', current_time( 'timestamp' ) );

        $employees->where(
            $db->raw( "DATEDIFF( '$current_date', `employee`.`hiring_date` )" ), '>=', $policy->execute_day
        );
    }

    $employees = $employees->get();

    if ( empty( $employees ) ) {
        return;
    }

    $financial_year = erp_get_financial_year_dates();

    $from_date                      = ! empty( $policy->effective_date ) ? $policy->effective_date : $financial_year['start'];
    $from_date_timestamp            = strtotime( $from_date );
    $financial_year_start_timestamp = strtotime( $financial_year['start'] );

    if ( $from_date_timestamp < $financial_year_start_timestamp ) {
        $from_date = date( 'Y-m-d 00:00:00', $financial_year_start_timestamp );
    } else {
        $from_date = date( 'Y-m-d 00:00:00', $from_date_timestamp );
    }

    $to_date                      = $financial_year['end'];
    $financial_year_end_timestamp = strtotime( $financial_year['end'] );

    if ( $from_date_timestamp > $financial_year_end_timestamp ) {
        $financial_year_end_timestamp += YEAR_IN_SECONDS;
        $to_date                      = date( 'Y-m-d 23:59:59', $financial_year_end_timestamp );
    }


    $fields = [
        'user_id'    => '',
        'policy_id'  => $policy->id,
        'days'       => $policy->value,
        'from_date'  => $from_date,
        'to_date'    => $to_date,
        'comments'   => $policy->description,
        'id'         => null,
        'status'     => 1,
        'created_by' => get_current_user_id(),
        'created_on' => current_time( 'mysql' )
    ];

    foreach ( $employees as $employee ) {
        $user_id           = $employee->user_id;
        $fields['user_id'] = $user_id;
        $entitlement       = new Leave_Entitlement();
        $entitlement       = $entitlement->where( function ( $condition ) use ( $fields, $financial_year ) {
            $financial_start_date = $fields['from_date'] ? $fields['from_date'] : $financial_year['start'];
            $financial_end_date   = $fields['to_date'] ? $fields['to_date'] : $financial_year['end'];
            $condition->whereBetween( 'from_date', [ $financial_year['start'], $financial_end_date ] );
            $condition->where( 'to_date', '<=', $financial_end_date );
            $condition->where( 'user_id', '=', $fields['user_id'] );
            $condition->where( 'policy_id', '=', $fields['policy_id'] );
        } );

        $existing_entitlement = $entitlement->first();

        if ( $existing_entitlement ) {
            continue;
        }

        $result = $wpdb->insert( $wpdb->prefix . 'erp_hr_leave_entitlements', $fields );
        if ( $result ) {
            do_action( 'erp_hr_leave_insert_new_entitlement', $wpdb->insert_id, $fields );
        }

    }

}

/**
 * Get leave requests day status
 *
 * @since 1.5.15
 *
 * @param  int|boolean $status
 *
 * @return array|string
 */
function erp_hr_leave_days_get_statuses( $status = false ) {
    $statuses = apply_filters( 'erp_hr_leave_day_statuses', array(
        'all' => esc_attr__( 'All', 'erp' ),
        '1'   => esc_attr__( 'Full Day', 'erp' ),
        '2'   => esc_attr__( 'Monring', 'erp' ),
        '3'   => esc_attr__( 'Afternoon', 'erp' )
    ) );

    if ( false !== $status && array_key_exists( $status, $statuses ) ) {
        return $statuses[ $status ];
    }

    return $statuses;
}

/**
 * Insert / Update new leave policy name
 *
 * @since 1.5.15
 *
 * @return int
 */
function erp_hr_insert_leave_policy_name( $args = array() ) {
    $defaults = array(
        'id' => null
    );

    $args = wp_parse_args( $args, $defaults );

    /**
     * Update
     */
    if ( $args['id'] ) {
        $exists = Leave::where( 'name', $args['name'] )
                        ->where('id', '<>', $args['id'])
                        ->first();

        if ( $exists ) {
            return new WP_Error( 'exists', esc_html__('Name already exists', 'erp') );
        }

        $leave = Leave::find( $args['id'] )->update( $args );

        return $leave->id;
    }

    /**
     * Create
     */
    $exists = Leave::where('name', $args['name'])->first();

    if ( $exists ) {
        return new WP_Error( 'exists', esc_html__('Name already exists', 'erp') );
    }

    $leave = Leave::create( $args );

    return $leave->id;
}

/**
 * Remove leave policy name
 *
 * @since 1.5.15
 *
 * @return void
 */
function erp_hr_remove_leave_policy_name( $id ) {
    $has_policy = Leave_Policy::where('leave_id', $id )->first();

    if ( $has_policy ) {
        return new WP_Error( 'has_policy', __( 'Can not remove, connected with policy', 'erp' ) );
    }

    $leave = Leave::find( $id );

    $leave->delete();
}

/**
 * Build and return new policy create URL
 *
 * @since 1.5.15
 *
 * @return string
 */
function erp_hr_new_policy_url( $id = null ) {
    $params = array(
        'page'        => 'erp-hr',
        'section'     => 'leave',
        'sub-section' => 'policies',
        'action'      => 'new'
    );

    if ( $id ) {
        $params['id'] = absint( $id );
        $params['action'] = 'edit';
    }

    return add_query_arg( $params, admin_url( 'admin.php' ) );
}

/**
 * Build and return new policy create URL
 *
 * @since 1.5.15
 *
 * @return string
 */
function erp_hr_new_policy_name_url( $id = null ) {
    $params = array(
        'page'        => 'erp-hr',
        'section'     => 'leave',
        'sub-section' => 'policies',
        'type'        => 'policy-name'
    );

    if ( $id ) {
        $params['id'] = absint( $id );
        $params['action'] = 'edit';
    }

    return add_query_arg( $params, admin_url( 'admin.php' ) );
}

