<?php
/**
 * Plugin Name: Karma Kit
 * Author: Karma Team
 * Author URI: https://karmatechhub.com
 * Version: 0.0.1
 * Description: Karma kit Plugin is widgets kit for Elementor
 * Text Domain: karmakit
 * Domain Path: /languages
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-16
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();


define('KARMA_KIT_PATH', plugin_dir_path(__FILE__) . DIRECTORY_SEPARATOR);
define('KARMA_KIT_URL', plugin_dir_url(__FILE__));

const KARMA_KIT_CORE = KARMA_KIT_PATH . DIRECTORY_SEPARATOR . 'core' .DIRECTORY_SEPARATOR;
const KARMA_KIT_VIEW = KARMA_KIT_CORE . DIRECTORY_SEPARATOR . 'View' .DIRECTORY_SEPARATOR;
const KARMA_KIT_WIDGETS = KARMA_KIT_PATH  . 'widgets' . DIRECTORY_SEPARATOR;
const KARMA_KIT_GROUP = 'karma_kit';


if(file_exists(KARMA_KIT_PATH . '/vendor/autoload.php')){
    require KARMA_KIT_PATH . '/vendor/autoload.php';
}


global $karma_kit;
$karma_kit = new \Karma\Kit\Loader();

