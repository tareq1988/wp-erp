<?php

namespace WeDevs\ERP;

use Exception;
use Mailgun\Mailgun;
use Mailgun\Message\MessageBuilder;

/**
 * Mailgun Email Class
 *
 * Send Outgoing Email for WP ERP
 *
 * @since 1.10.0
 */
class EmailMailgun {

    /**
     * Private API Key
     *
     * @var $private_api_key
     */
    private $private_api_key;

    /**
     * Region Host Address
     *
     * @var $region
     */
    public $region;

    /**
     * Domain Name
     *
     * @var $domain
     */
    public $domain;

    /**
     * Mailgun Instance
     *
     * @var $mailgun instance
     */
    protected $mailgun;

    /**
     * Message Builder Instance
     *
     * @var $builder instance
     */
    protected $builder;

    /**
     * Class contsructor
     *
     * @param string $private_api_key   key-xxx
     * @param string $region            api.mailgun.net
     * @param string $domain            sandboxxxx.mailgun.org
     */
    public function __construct( $private_api_key, $region, $domain ) {
        $this->private_api_key = $private_api_key;
        $this->region          = $region;
        $this->domain          = $domain;

        $this->init();
    }

    /**
     * Init Mailgun Instance
     *
     * @since 1.10.0
     *
     * @return void
     */
    public function init() {
        $this->mailgun = Mailgun::create( $this->private_api_key, "https://$this->region" );
        $this->builder = new MessageBuilder();
    }

    /**
     * Set Email Subject
     *
     * @since 1.10.0
     *
     * @param string $subject
     *
     * @return void
     */
    public function set_subject ( $subject ) {
        if ( ! empty( $subject ) ) {
            $subject = esc_html( $subject );

            $this->builder->setSubject( $subject );
        }
    }

    /**
     * Set Email Message
     *
     * @since 1.10.0
     *
     * @param string $message
     *
     * @return void
     */
    public function set_message( $message ) {
        if ( ! empty( $message ) ) {
            $messageHTML = preg_replace( "/\r\n|\r|\n/", '<br>', $message );

            $this->builder->setHtmlBody( $messageHTML );
        }
    }

    /**
     * Set Email From Address
     *
     * @since 1.10.0
     *
     * @param array $from address_array example; `[ 'email' => 'test@example.com', ['name' => 'Jhon Doe'] ]`
     *
     * @return void
     */
    public function set_from_address( $from = [] ) {
        if ( ! empty( $from['email'] ) ) {
            $this->builder->setFromAddress(
                $from['email'],
                [
                    'first' => ! empty ( $from['name'] ) ? $from['name'] : ''
                ]
            );
        }
    }

    /**
     * Set Email To Address
     *
     * @since 1.10.0
     *
     * @param array $to address_array example; `[ 'email' => 'test@example.com', ['name' => 'Jhon Doe'] ]`
     *
     * @return void
     */
    public function set_to_address( $to = [] ) {
        if ( ! empty( $to['email'] ) ) {
            $this->builder->addToRecipient(
                $to['email'],
                [
                    'first' => ! empty ( $to['name'] ) ? $to['name'] : ''
                ]
            );
        }
    }

    /**
     * Set Email CC Address
     *
     * @since 1.10.0
     *
     * @param array $cc address_array example; `[ 'email' => 'test@example.com', ['first' => 'Jhon Doe'] ]`
     *
     * @return void
     */
    public function set_cc_address( $cc = [] ) {
        if ( ! empty( $cc['email'] ) ) {
            $this->builder->addCcRecipient(
                $cc['email'],
                [
                    'first' => ! empty ( $cc['name'] ) ? $cc['name'] : ''
                ]
            );
        }
    }

    /**
     * Set Email BCC Address
     *
     * @since 1.10.0
     *
     * @param array $bcc address_array example; `[ 'email' => 'test@example.com', ['first' => 'Jhon Doe'] ]`
     *
     * @return void
     */
    public function set_bcc_address( $bcc = [] ) {
        if ( ! empty( $bcc['email'] ) ) {
            $this->builder->addCcRecipient(
                $bcc['email'],
                [
                    'first' => ! empty ( $bcc['name'] ) ? $bcc['name'] : ''
                ]
            );
        }
    }

    /**
     * Set Email Reply To Address
     *
     * @since 1.10.0
     *
     * @param array $reply_to address_array example; `[ 'email' => 'test@example.com', ['first' => 'Jhon Doe'] ]`
     *
     * @return void
     */
    public function set_reply_to_address( $reply_to = [] ) {
        if ( ! empty( $reply_to['email'] ) ) {
            $this->builder->setReplyToAddress(
                $reply_to['email'],
                [
                    'first' => ! empty ( $reply_to['name'] ) ? $reply_to['name'] : ''
                ]
            );
        }
    }

    /**
     * Set Email Custom Headers
     *
     * @since 1.10.0
     *
     * @param array $headers custom_headers example; `[[ 'Custom-ID' => '123456' ]]`
     *
     * @return void
     */
    public function set_custom_headers( $headers = [] ) {
        foreach ( (array) $headers as $key => $value ) {
            if ( ! empty( $value ) ) {
                $this->builder->addCustomHeader( $key, $value );
            }
        }
    }

    /**
     * Set Email Headers
     *
     * Set headers if there is any, Example: cc, bcc, to, reply-to etc.
     *
     * @since 1.10.0
     *
     * @param array $headers Email headers
     *
     * @return void
     */
    public function set_headers( $headers = [] ) {
        $cc       = [];
        $bcc      = [];
        $reply_to = [];

        if ( empty( $headers ) ) {
            $headers = [];
        } else {
            if ( ! is_array( $headers ) ) {
                // Explode the headers out, so this function can take both
                // string headers and an array of headers.
                $temp_headers = explode( "\n", str_replace( "\r\n", "\n", $headers ) );
            } else {
                $temp_headers = $headers;
            }

            $headers = [];

            foreach ( (array) $temp_headers as $header ) {
                if ( strpos( $header, ':' ) === false ) {
                    if ( false !== stripos( $header, 'boundary=' ) ) {
                        $parts    = preg_split( '/boundary=/i', trim( $header ) );
                        $boundary = trim( str_replace( [ "'", '"' ], '', $parts[1] ) );
                    }
                    continue;
                }

                // Explode them out
                list( $name, $content ) = explode( ':', trim( $header ), 2 );

                // Cleanup crew
                $name    = trim( $name );
                $content = trim( $content );

                switch ( strtolower( $name ) ) {
                    // Mainly for legacy -- process a From: header if it's there
                    case 'from':
                        $bracket_pos = strpos( $content, '<' );

                        if ( $bracket_pos !== false ) {
                            // Text before the bracketed email is the "From" name.
                            if ( $bracket_pos > 0 ) {
                                $from_name = substr( $content, 0, $bracket_pos - 1 );
                                $from_name = str_replace( '"', '', $from_name );
                                $from_name = trim( $from_name );
                            }

                            $from_email = substr( $content, $bracket_pos + 1 );
                            $from_email = str_replace( '>', '', $from_email );
                            $from_email = trim( $from_email );

                        // Avoid setting an empty $from_email.
                        } elseif ( '' !== trim( $content ) ) {
                            $from_email = trim( $content );
                            $from_name = '';
                        }

                        if ( ! empty( $from_email ) ) {
                            $this->set_from_address( [ 'email' => $from_email, 'name' => $from_name ] );
                        }
                        break;

                    case 'content-type':
                        if ( strpos( $content, ';' ) !== false ) {
                            list( $type, $charset_content ) = explode( ';', $content );
                            $content_type                   = trim( $type );

                            if ( false !== stripos( $charset_content, 'charset=' ) ) {
                                $charset = trim( str_replace( [ 'charset=', '"' ], '', $charset_content ) );
                            } elseif ( false !== stripos( $charset_content, 'boundary=' ) ) {
                                $boundary = trim( str_replace( [ 'BOUNDARY=', 'boundary=', '"' ], '', $charset_content ) );
                                $charset  = '';
                            }

                            // Avoid setting an empty $content_type.
                        } elseif ( '' !== trim( $content ) ) {
                            $content_type = trim( $content );
                        }
                        break;

                    case 'cc':
                        $cc = array_merge( (array) $cc, explode( ',', $content ) );
                        $this->set_cc_address( [ 'email' => $cc ] );
                        break;

                    case 'bcc':
                        $bcc = array_merge( (array) $bcc, explode( ',', $content ) );
                        $this->set_bcc_address( [ 'email' => $bcc ] );
                        break;

                    case 'reply-to':
                        $reply_to = array_merge( (array) $reply_to, explode( ',', $content ) );
                        $this->set_reply_to_address( [ 'email' => $reply_to ] );
                        break;

                    default:
                        $headers[ trim( $name ) ] = trim( $content );
                        $this->set_to_address( trim( $content ) );
                        break;
                }
            }
        }
    }

    /**
     * Set Email Attachment
     *
     * @since 1.10.0
     *
     * @param array attachments
     *
     * @return void
     */
    public function set_attachment( $attachments = [] ) {
        foreach ( (array) $attachments as $attachment ) {
            $this->builder->addAttachment( $attachment );
        }
    }

    /**
     * Make Message
     *
     * Build a mailgun message with the data
     *
     * @since 1.10.0
     *
     * @param array $args
     *
     * @todo Add all supported features of mailgun if missed any
     *
     * @return void
     */
    public function make_message( $args = [] ) {
        $default = [
            'subject'         => '',
            'from_address'    => [ 'email' => '', 'name'  => '' ],
            'to_address'      => [ 'email' => '', 'name'  => '' ],
            'cc_address'      => [ 'email' => '', 'name'  => '' ],
            'headers'         => [],
            'customer_header' => [ 'key'   => '', 'value' => '' ],
            'attachment'      => '',
            'message'         => ''
        ];

        $data = wp_parse_args( $args, $default );

        $this->set_subject( $data['subject'] );
        $this->set_from_address( $data['from_address'] );
        $this->set_to_address( $data['to_address'] );
        $this->set_cc_address( $data['cc_address'] );
        $this->set_headers( $data['headers'] );
        $this->set_custom_headers( $data['customer_header'] );
        $this->set_attachment( $data['attachment'] );
        $this->set_message( $data['message'] );
    }

    /**
     * Send a Mailgun Message
     *
     * @since 1.10.0
     *
     * @param array $data A complete dataset of the message
     *
     * @return mixed
     */
    public function send_email( $data = [] ) {
        try {
            $this->make_message( $data );

            return $this->mailgun->messages()->send(
                $this->domain,
                $this->builder->getMessage()
            );
        } catch ( Exception $e ) {
            throw new Exception( $e->getMessage() );
        }
    }
}
