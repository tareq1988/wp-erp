<?php

namespace WeDevs\ERP\Accounting\Classes;

use WeDevs\ERP\Email;

class SendEmail extends Email {
    public function __construct() {
        parent::__construct();
    }

    public function trigger( $receiver_emails, $subject = 'Default subject', $body = 'Default body', $attachment = '' ) {
        $results = [];

        if ( is_array( $receiver_emails ) ) {
            foreach ( $receiver_emails as $email ) {
                $results[] = $this->send( $email, $subject, $body, '', $attachment );
            }
        } else {
            $results[] = $this->send( $receiver_emails, $subject, $body, '', $attachment );
        }

        if ( in_array( false, $results, true ) ) {
            return false;
        }

        return true;
    }
}
