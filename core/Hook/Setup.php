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
                'k-kit-menu' => __('Karma Kit Menu', 'karmakit'),
            )
        );
    }
}
