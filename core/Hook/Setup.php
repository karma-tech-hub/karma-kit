<?php

namespace Karma\Kit\Hook;
/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-20
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();

class Setup extends \WpTool\Helper\Hook
{

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->action('after_setup_theme', 'register_menu');
        $this->action('init', 'load_text_domain');
    }


    /**
     * register menu
     *
     * @return void
     */
    public function register_menu()
    {
        register_nav_menus(
            array(
                'k-kit-menu' => __('Karma Kit Menu', 'karma-kit'),
            )
        );
    }


    /**
     * load text domain
     *
     * @return void
     */
    public function load_text_domain()
    {
        load_plugin_textdomain('karma-kit', false, KARMA_KIT_PATH . '/lang/');
    }
}
