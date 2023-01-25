<?php
namespace Karma\Kit\Hook;

use Elementor\Elements_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;
use WpTool\Helper\Hook;

/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-16
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();

class Elementor extends Hook
{

    /**
     * Instance of Elemenntor Frontend class.
     *
     * @var \Elementor\Plugin()
     */
    private static $elementor_instance;



    public function register()
    {



        // add karma category in elementor
        $this->action('elementor/elements/categories_registered', 'add_category');

        // register karma elementor widgets
        $this->action('elementor/widgets/register', 'register_widgets');


        $this->action('wp', 'hooks');

        $is_elementor_callable = defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' );

        if($is_elementor_callable){
            self::$elementor_instance = \Elementor\Plugin::instance();
        }

    }


    /**
     * add elementor widget category
     *
     * @param $elements_manager Elements_Manager
     */
    public function add_category($elements_manager)
    {
        $elements_manager->add_category(
            KARMA_KIT_GROUP,
            [
                'title' => __('Karma Kit', 'karmakit'),
                'icon' => 'fa fa-plug',
            ]
        );

    }



    /**
     * auto register karma elementor widgets
     *
     * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
     */
    public function register_widgets($widgets_manager)
    {

        $widgets = glob(KARMA_KIT_PATH . 'widgets' . DIRECTORY_SEPARATOR . '**' . DIRECTORY_SEPARATOR . '*.php');

        foreach ($widgets as $widget)
        {

            $class = str_replace(KARMA_KIT_PATH . 'widgets' . DIRECTORY_SEPARATOR, '', $widget);
            $class = str_replace(DIRECTORY_SEPARATOR, '\\', $class);
            $class = str_replace('.php', '', $class);
            $class = 'Karma\\Widgets\\' . $class;

            if(class_exists($class) && is_subclass_of($class, Widget_Base::class) ){
                $widgets_manager->register( new $class() );
            }

        }
    }


    /**
     * hooks
     *
     * @return void
     */
    public function hooks()
    {
        if(function_exists('wp_body_open')){
            $this->action('wp_body_open', 'render_top_bar', 0);
            $this->action('wp_body_open', 'render_header', 0);
        }else{
            $this->action('wp_head', [ $this, 'render_top_bar' ], 99);
            $this->action('wp_head', [ $this, 'render_header' ], 99);
        }
        $this->action('wp_footer', 'render_before_footer');
        $this->action('wp_footer', 'render_footer');
    }


    /**
     * render header
     *
     * @return void
     */
    public function render_top_bar()
    {
        $current_post_id   = get_the_ID();
        $page_top_bar       = get_post_meta(get_the_ID(), 'karma_top_bar', true);
        $default_top_bars   = karma_get_current_templates('top-bar');
        $current_top_bar_id = 0;

        if($page_top_bar && get_post_status($page_top_bar) == 'publish' ){
            $current_top_bar_id = $page_top_bar;
        }elseif($default_top_bars && get_post_status($default_top_bars[0]) == 'publish' ){
            $current_top_bar_id = $default_top_bars[0];
        }

        $current_top_bar_id = apply_filters('karma_current_top_bar_id', $current_top_bar_id, $current_post_id);

        if($current_top_bar_id){
            echo self::$elementor_instance->frontend->get_builder_content_for_display( $current_top_bar_id );
        }
    }

    /**
     * render header
     *
     * @return void
     */
    public function render_header()
    {
        $current_post_id   = get_the_ID();
        $page_header       = get_post_meta(get_the_ID(), 'karma_header', true);
        $default_headers   = karma_get_current_templates();
        $current_header_id = 0;

        if($page_header && get_post_status($page_header) == 'publish' ){
            $current_header_id = $page_header;
        }elseif($default_headers && get_post_status($default_headers[0]) == 'publish' ){
            $current_header_id = $default_headers[0];
        }

        $current_header_id = apply_filters('karma_current_header_id', $current_header_id, $current_post_id);

        if($current_header_id){
            echo self::$elementor_instance->frontend->get_builder_content_for_display( $current_header_id );
        }
    }

    /**
     * render footer
     *
     * @return void
     */
    public function render_footer()
    {
        $current_post_id   = get_the_ID();
        $page_footer       = get_post_meta(get_the_ID(), 'karma_footer', true);
        $default_footers   = karma_get_current_templates('footer');
        $current_footer_id = 0;

        if($page_footer && get_post_status($page_footer) == 'publish' ){
            $current_footer_id = $page_footer;
        }elseif($default_footers && get_post_status($default_footers[0]) == 'publish' ){
            $current_footer_id = $default_footers[0];
        }

        $current_footer_id = apply_filters('karma_current_footer_id', $current_footer_id, $current_post_id);

        if($current_footer_id){
            echo self::$elementor_instance->frontend->get_builder_content_for_display( $current_footer_id );
        }
    }

    /**
     * render footer
     *
     * @return void
     */
    public function render_before_footer()
    {
        $current_post_id   = get_the_ID();
        $page_before_footer       = get_post_meta(get_the_ID(), 'karma_before_footer', true);
        $default_before_footers   = karma_get_current_templates('before-footer');
        $current_before_footer_id = 0;

        if($page_before_footer && get_post_status($page_before_footer) == 'publish' ){
            $current_before_footer_id = $page_before_footer;
        }elseif($default_before_footers && get_post_status($default_before_footers[0]) == 'publish' ){
            $current_before_footer_id = $default_before_footers[0];
        }

        $current_before_footer_id = apply_filters('karma_current_before_footer_id', $current_before_footer_id, $current_post_id);

        if($current_before_footer_id){
            echo self::$elementor_instance->frontend->get_builder_content_for_display( $current_before_footer_id );
        }
    }
}
