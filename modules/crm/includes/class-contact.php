<?php
namespace WeDevs\ERP\CRM;

/**
* Customer Class
*
* @since 1.0
*
* @package WP-ERP|CRM
*/
class Contact extends \WeDevs\ERP\People {

    protected $contact_type;

    /**
     * Load parent constructor
     *
     * @since 1.0
     *
     * @param int|object $contact
     */
    public function __construct( $contact = null, $type = null ) {
        parent::__construct( $contact );
        $this->contact_type = $type ? $type : $this->type ;
    }

    /**
     * Get the user info as an array
     *
     * @return array
     */
    public function to_array() {
        $fields = array(
            'id'            => 0,
            'user_id'       => '',
            'first_name'    => '',
            'last_name'     => '',
            'company'       => '',
            'avatar'        => array(
                'id'  => 0,
                'url' => ''
            ),
            'life_stage'    => '',
            'email'         => '',
            'date_of_birth' => '',
            'phone'         => '',
            'mobile'        => '',
            'website'       => '',
            'fax'           => '',
            'street_1'      => '',
            'street_2'      => '',
            'city'          => '',
            'country'       => '',
            'state'         => '',
            'postal_code'   => '',
            'type'          => '',
            'notes'         => '',
            'other'         => '',
            'social'        => [],
            'source'        => '',
            'assign_to'     => '',
            'group_id'      => [],
        );

        $social_field = erp_crm_get_social_field();

        foreach ( $social_field as $social_key => $social_value ) {
            $fields['social'][$social_key] = '';
        }

        if ( $this->id ) {
            foreach ( $this->data as $key => $value ) {
                $fields[$key] = $value;
            }

            $avatar_id              = (int) $this->get_meta( 'photo_id', true );
            $fields['avatar']['id'] = $avatar_id;

            if ( $avatar_id ) {
                $fields['avatar']['url'] = wp_get_attachment_url( $avatar_id );
            }

            foreach ( $fields['social'] as $key => $value ) {
                $fields['social'][$key] = $this->get_meta( $key, true );
            }

            $contact_groups           = erp_crm_get_editable_assign_contact( $this->id );
            $fields['contact_groups'] = $contact_groups;
            $fields['group_id']       = wp_list_pluck( $contact_groups, 'group_id' );

            $fields['life_stage']     = $this->get_meta( 'life_stage', true );
            $fields['date_of_birth']  = $this->get_meta( 'date_of_birth', true );
            $fields['source']         = $this->get_meta( 'source', true );
            $fields['assign_to']      = $this->get_meta( '_assign_crm_agent', true );
        }

        return apply_filters( 'erp_crm_get_contacts_fields', $fields, $this->data, $this->id, $this->contact_type );
    }

    /**
     * Get single customer page view url
     *
     * @return string the url
     */
    public function get_details_url() {
        if ( $this->id ) {

            if ( $this->contact_type == 'contact' ) {
                return admin_url( 'admin.php?page=erp-sales-customers&action=view&id=' . $this->id );
            }

            if ( $this->contact_type == 'company' ) {
                return admin_url( 'admin.php?page=erp-sales-companies&action=view&id=' . $this->id );
            }
        }
    }

    /**
     * Get an customer avatar
     *
     * @param  integer  avatar size in pixels
     *
     * @return string  image with HTML tag
     */
    public function get_avatar( $size = 32 ) {
        if ( $this->id ) {

            $user_photo_id = $this->get_meta( 'photo_id', true );

            if ( ! empty( $user_photo_id ) ) {
                $image = wp_get_attachment_thumb_url( $user_photo_id );
                return sprintf( '<img src="%1$s" alt="" class="avatar avatar-%2$s photo" height="auto" width="%2$s" />', $image, $size );
            }
        }

        return get_avatar( $this->email, $size );
    }

    /**
     * Get first name
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_first_name() {
        if ( $this->id ) {
            if ( $this->is_wp_user() ) {
                return \get_user_by( 'id', $this->user_id )->first_name;
            } else {
                return $this->first_name;
            }
        }
    }

    /**
     * Get last name
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_last_name() {
        if ( $this->id ) {
            if ( $this->is_wp_user() ) {
                return \get_user_by( 'id', $this->user_id )->last_name;
            } else {
                return $this->last_name;
            }
        }
    }

    /**
     * Get phone number
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_phone() {
        if ( $this->id ) {
            return ( $this->phone ) ? erp_get_clickable( 'phone', $this->phone ) : '—';
        }
    }

    /**
     * Get mobile number
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_mobile() {
        if ( $this->id ) {
            return ( $this->mobile ) ? erp_get_clickable( 'phone', $this->mobile ) : '—';
        }
    }

    /**
     * Get fax number
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_fax() {
        if ( $this->id ) {
            return ( $this->fax ) ? $this->fax : '—';
        }
    }

    /**
     * Get street 1 address
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_street_1() {
        if ( $this->id ) {
            return ( $this->street_1 ) ? $this->street_1 : '—';
        }
    }

    /**
     * Get street 2 address
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_street_2() {
        if ( $this->id ) {
            return ( $this->street_2 ) ? $this->street_2 : '—';
        }
    }

    /**
     * Get city name
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_city() {
        if ( $this->id ) {
            return ( $this->city ) ? $this->city : '—';
        }
    }

    /**
     * Get country name
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_country() {
        if ( $this->id ) {
            return erp_get_country_name( $this->country );
        }
    }

    /**
     * Get state name
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_state() {
        if ( $this->id ) {
            return erp_get_state_name( $this->country, $this->state );
        }
    }

    /**
     * Get postal code/Zip Code
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_postal_code() {
        if ( $this->id ) {
            return ( $this->postal_code ) ? $this->postal_code : '—';
        }
    }

    /**
     * Get notes
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_notes() {
        if ( $this->id ) {
            return ( $this->notes ) ? $this->notes : '—';
        }
    }

    /**
     * Get birth date
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_birthday() {
        if ( $this->date_of_birth ) {
            return erp_format_date( $this->date_of_birth );
        }
    }

    /**
     * Get the contact source
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_source() {
        $sources = erp_crm_contact_sources();
        $source = '';

        if ( array_key_exists( $this->source , $sources ) ) {
            $source = $sources[ $this->source ];
        }

        return $source;
    }

    /**
     * Get life stage
     *
     * @since 1.0
     *
     * @return string
     */
    public function get_life_stage() {
        $life_stages       = erp_crm_get_life_stages_dropdown_raw();
        $life_stage        = erp_people_get_meta( $this->id, 'life_stage', true );

        return isset( $life_stages[$life_stage] ) ? $life_stages[$life_stage] : '—';
    }

    public function get_contact_owner() {

    }

}

