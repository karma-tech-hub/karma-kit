<?php

namespace Karma\Kit;
use Karma\Kit\PostType\Template;
use Karma\Kit\Provider\Provider;
use MongoDB\Driver\Query;

/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-16
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();

class Loader
{




    /**
     * Instance
     *
     * @since 1.0.0
     * @access private
     * @static
     * @var Loader The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     * @access public
     * @static
     * @return Loader An instance of the class.
     */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }


    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     * @var string Minimum Elementor version required to run the addon.
     */
    const MINIMUM_ELEMENTOR_VERSION = '3.2.0';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     * @var string Minimum PHP version required to run the addon.
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Constructor
     *
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct()
    {


        /**
         * include main functions
         */
        require KARMA_KIT_CORE . 'Functions/function_core.php';


        /**
         * register provider classes
         */
        $this->register_provider_classes();


    }


    /**
     * register provider class
     */
    private function register_provider_classes()
    {
        $providers = Provider::get_all();

        $types = Provider::get_types();

        foreach ($types as $type){
            if (isset($providers[$type])){
                foreach ($providers[$type] as $provider){
                    new $provider();
                }
            }
        }
    }



    /**
     * get view php files in view dir
     *
     * @param $template
     * @param array $params
     * @return false|string
     */
    public function view($template, $params = [], $dir = KARMA_KIT_VIEW)
    {
        /**
         * Remove php suffix if exists
         */
        if( strrpos( $template, '.php' ) + 4 == strlen( $template ) ){
            $template = substr( $template, 0, strrpos( $template, '.php' ) );
        }

        $template = str_replace('/', DIRECTORY_SEPARATOR, $template);

        $file       =  $dir . DIRECTORY_SEPARATOR .  $template . '.php' ;

        if( file_exists( $file ) ) {
            if (is_array($params) && !empty($params)) {
                extract($params);
            }
            ob_start();

            include($file);

            return ob_get_clean();
        }

    }


    /**
     * get view widget template
     *
     * @param $template
     * @param $params
     *
     * @return void
     */
    public function view_widget($template, $params = [])
    {
        echo $this->view($template, $params, KARMA_KIT_WIDGETS);
    }

    /**
     * get nav menu
     *
     * @param $name
     * @param array $args
     */
    public function menu( $name , $args = [])
    {
        $defaults = array(
            'menu'                 => $name,
            'container'            => 'nav',
            'container_class'      => 'k-kit-menu'
        );

        $args = wp_parse_args( $args, $defaults );
        wp_nav_menu($args);

    }





}
