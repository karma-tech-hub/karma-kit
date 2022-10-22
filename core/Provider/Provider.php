<?php
namespace Karma\Kit\Provider;

use Karma\Kit\Hook\Admin;
use Karma\Kit\Hook\Elementor;
use Karma\Kit\Hook\Setup;
use Karma\Kit\PostType\Template;

/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-16
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();

class Provider
{

    /**
     * register hook class
     * @return string[]
     */
    private static function hooks()
    {
        return [
            Setup::class,
            Elementor::class,
            Admin::class
        ];
    }

    private static function post_type()
    {
        return [
          Template::class
        ];
    }

    /**
     * @return array
     */
    public static function get_all()
    {
        return [
            "Hook" => self::hooks(),
            "PostType" => self::post_type(),
        ];
    }


    /**
     * get types
     *
     * @return string[]
     */
    public static function get_types()
    {
        return [
            'Hook',
            'PostType',
            'MetaBox',
            'Route'
        ];
    }


}
