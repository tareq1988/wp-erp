<?php
/**
 * Plugin Name: WP ERP
 * Description: ERP solution for WordPress
 * Plugin URI: http://wedevs.com/plugin/erp/
 * Author: Tareq Hasan
 * Author URI: http://wedevs.com
 * Version: 0.1-alpha
 * License: GPL2
 * Text Domain: wp-erp
 * Domain Path: languages
 *
 * Copyright (c) 2014 Tareq Hasan (email: info@wedevs.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// don't call the file directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

include dirname( __FILE__ ) . '/vendor/autoload.php';

/**
 * WeDevs_ERP class
 *
 * @class WeDevs_ERP The class that holds the entire WeDevs_ERP plugin
 */
final class WeDevs_ERP {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '0.1';

    /**
     * Holds various class instances
     *
     * @var array
     */
    private $container = array();

    /**
     * Initializes the WeDevs_ERP() class
     *
     * Checks for an existing WeDevs_ERP() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Constructor for the WeDevs_ERP class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    public function __construct() {

        // Define constants
        $this->define_constants();

        // Include required files
        $this->includes();

        // instantiate classes
        $this->instantiate();

        // Initialize the action hooks
        $this->init_actions();

        // load the modules
        $this->load_module();

        // Loaded action
        do_action( 'erp_loaded' );
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }

        return $this->{$prop};
    }

    /**
     * Magic isset to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __isset( $prop ) {
        return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
    }

    /**
     * Check if the PHP version is supported
     *
     * @return bool
     */
    public function is_supported_php() {
        if ( version_compare( PHP_VERSION, '5.4.0', '<=' ) ) {
            return false;
        }

        return true;
    }

    /**
     * Define the plugin constants
     *
     * @return void
     */
    private function define_constants() {
        define( 'WPERP_VERSION', $this->version );
        define( 'WPERP_FILE', __FILE__ );
        define( 'WPERP_PATH', dirname( WPERP_FILE ) );
        define( 'WPERP_INCLUDES', WPERP_PATH . '/includes' );
        define( 'WPERP_MODULES', WPERP_PATH . '/modules' );
        define( 'WPERP_URL', plugins_url( '', WPERP_FILE ) );
        define( 'WPERP_ASSETS', WPERP_URL . '/assets' );
        define( 'WPERP_VIEWS', WPERP_INCLUDES . '/admin/views' );
    }

    /**
     * Include the required files
     *
     * @return void
     */
    private function includes() {
        require_once WPERP_INCLUDES . '/class-install.php';

        if ( ! $this->is_supported_php() ) {
            return;
        }

        require_once WPERP_INCLUDES . '/functions.php';
        require_once WPERP_INCLUDES . '/actions-filters.php';
        require_once WPERP_INCLUDES . '/functions-html.php';
        require_once WPERP_INCLUDES . '/functions-company.php';
        require_once WPERP_INCLUDES . '/functions-people.php';

        if ( is_admin() ) {
            require_once WPERP_INCLUDES . '/admin/functions.php';
            require_once WPERP_INCLUDES . '/admin/class-menu.php';
            require_once WPERP_INCLUDES . '/admin/class-admin.php';
        }
    }

    /**
     * Instantiate classes
     *
     * @return void
     */
    private function instantiate() {
        if ( ! $this->is_supported_php() ) {
            return;
        }

        $this->container['modules'] = new \WeDevs\ERP\Framework\Modules();
    }

    /**
     * Initialize erp script register
     *
     * @return void
     */
    function init_script_register() {

        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        // Register select2 scripts
        wp_register_script( 'erp-select2', WPERP_ASSETS . '/js/select2.full.min.js', false, false, true );

        // Register Fontawesome font icons
        wp_register_style( 'erp-fontawesome', WPERP_ASSETS . '/css/font-awesome.min.css' );

        // Register select2 style
        wp_register_style( 'erp-select2', WPERP_ASSETS . '/css/select2.min.css' );

        // Register TipTip jquery plugin
        wp_register_script( 'erp-tiptip', WPERP_ASSETS . '/js/jquery.tipTip.min.js', array( 'jquery' ), false, true );

        // Register select2 style
        wp_register_style( 'erp-tiptip', WPERP_ASSETS . '/css/tipTip.css' );

        // Register main style
        wp_register_style( 'erp-style', WPERP_ASSETS . '/css/style.css' );

        //Settings script
        wp_register_script( 'erp-admin-settings', WPERP_ASSETS . '/js/settings' . $suffix . '.js', array( 'jquery' ), false, true );

        //Settings style
        wp_register_style( 'erp-admin-settings', WPERP_ASSETS . '/css/admin/settings' . $suffix . '.css' );

        //jQuery full calendar moment script
        wp_register_script( 'erp-admin-calendar-moment', WPERP_ASSETS . '/js/moment.min.js', false, false, true );

        //jQuery full calendar script
        wp_register_script( 'erp-admin-calendar', WPERP_ASSETS . '/js/fullcalendar' . $suffix . '.js', array( 'jquery', 'erp-admin-calendar-moment' ), false, true );

        //jQuery full calendar style
        wp_register_style( 'erp-admin-calendar', WPERP_ASSETS . '/css/fullcalendar' . $suffix . '.css' );

        //jQuery timepicker script
        wp_register_script( 'erp-admin-timepicker', WPERP_ASSETS . '/js/jquery.timepicker.min.js', array( 'jquery', 'erp-admin-calendar-moment' ), false, true );

        //jQuery timepicker style
        wp_register_style( 'erp-admin-timepicker', WPERP_ASSETS . '/css/jquery.timepicker.css' );

        // Register Vuejs script
        wp_register_script( 'erp-vuejs', WPERP_ASSETS . '/js/vue'. $suffix .'.js', array( 'jquery' ), false, true );

        // Register Basecamp text editor styles
        wp_register_style( 'erp-trix-editor', WPERP_ASSETS . '/css/trix.css' );

        // Register Flot Valuelabel css
        wp_register_style( 'erp-flotchart-valuelabel-css', WPERP_ASSETS . '/css/plot.css' );

        // Register Bascamp text editor js
        wp_register_script( 'erp-trix-editor', WPERP_ASSETS . '/js/trix.js', array( 'jquery' ), false, false );

        // Register upload js
        wp_register_script( 'erp-file-upload', WPERP_ASSETS . '/js/upload.js', array( 'jquery', 'plupload-handlers' ), false, false );

        // flot charts
        wp_register_script( 'erp-flotchart', WPERP_ASSETS . '/js/jquery.flot.min.js', array( 'jquery' ), false, false );
        wp_register_script( 'erp-flotchart-time', WPERP_ASSETS . '/js/jquery.flot.time.min.js', array( 'jquery' ), false, false );
        wp_register_script( 'erp-flotchart-orerbars', WPERP_ASSETS . '/js/jquery.flot.orderBars.js', array( 'jquery' ), false, false );
        wp_register_script( 'erp-flotchart-pie', WPERP_ASSETS . '/js/jquery.flot.pie.min.js', array( 'jquery' ), false, false );
        wp_register_script( 'erp-flotchart-axislables', WPERP_ASSETS . '/js/jquery.flot.axislabels.js', array( 'jquery' ), false, false );
        wp_register_script( 'erp-flotchart-tooltip', WPERP_ASSETS . '/js/jquery.flot.tooltip.min.js', array( 'jquery' ), false, false );
        wp_register_script( 'erp-flotchart-resize', WPERP_ASSETS . '/js/jquery.flot.resize.min.js', array( 'jquery' ), false, false );
        wp_register_script( 'erp-flotchart-valuelabel', WPERP_ASSETS . '/js/jquery.flot.valuelabels.js', array( 'jquery' ), false, false );

        // Enqueue scripts in globally wp-erp
        wp_enqueue_script( 'erp-select2' );
        wp_enqueue_style( 'erp-select2' );
    }

    /**
     * Initialize WordPress action hooks
     *
     * @return void
     */
    private function init_actions() {

        if ( ! $this->is_supported_php() ) {
            return;
        }

        // Localize our plugin
        add_action( 'init', array( $this, 'localization_setup' ) );
        add_action( 'init', array( $this, 'setup_database' ) );

        add_action( 'admin_enqueue_scripts', array( $this, 'init_script_register' ) );
    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'wp-erp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Setup database related tasks
     *
     * @return void
     */
    public function setup_database() {
        global $wpdb;

        $wpdb->erp_peoplemeta = $wpdb->prefix . 'erp_peoplemeta';
    }

    /**
     * Load the current ERP module
     *
     * We don't load every module at once, just load
     * what is necessary
     *
     * @return void
     */
    public function load_module() {
        $modules = $this->modules->get_modules();

        if ( ! $modules ) {
            return;
        }

        foreach ($modules as $key => $module) {

            if ( ! $this->modules->is_module_active( $key ) ) {
                continue;
            }

            if ( isset( $module['callback'] ) && class_exists( $module['callback'] ) ) {
                new $module['callback']( $this );
            }
        }
    }

} // WeDevs_ERP

/**
 * Init the wperp plugin
 *
 * @return WeDevs_ERP the plugin object
 */
function wperp() {
    return WeDevs_ERP::init();
}

// kick it off
wperp();
