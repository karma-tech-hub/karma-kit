<?php

namespace Karma\Kit\Hook;
/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-18
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();

class Admin extends \WpTool\Helper\Hook
{

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->action('admin_menu', 'register_admin_menu', 50);
    }

    /**
     * register admin menu
     * @return void
     */
    public function register_admin_menu()
    {
        add_submenu_page(
            'themes.php',
            __( 'Karma Template', 'karmakit' ),
            __( 'Karma Template', 'karmakit' ),
            'edit_pages',
            'edit.php?post_type=karma-kit-template'
        );
    }
}
