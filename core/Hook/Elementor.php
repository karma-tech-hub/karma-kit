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
            $this->action('wp_body_open', 'render_header', 0);
        }else{
            $this->action('wp_head', [ $this, 'render_header' ], 99);
        }
        $this->action('wp_footer', 'render_footer');
    }


    /**
     * render header
     *
     * @return void
     */
    public function render_header()
    {
        $ids = kk_get_current_template_ids();

        if(!$ids){
            return;
        }
        foreach($ids as $id){
            echo self::$elementor_instance->frontend->get_builder_content_for_display( $id );
        }
    }

    /**
     * render footer
     *
     * @return void
     */
    public function render_footer()
    {
        $ids = kk_get_current_template_ids('footer');
        if(!$ids){
            return;
        }
        foreach($ids as $id){
            echo self::$elementor_instance->frontend->get_builder_content_for_display( $id );
        }
    }
}
