<?php
/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-20
 * @website     : https://karmatechhub.com
 * @var $widget \Elementor\Widget_Base
 */
defined('ABSPATH') or exit();
$style  = $widget->get_settings_for_display('style');
$nav    = $widget->get_settings_for_display('nav');

?>

<header class="k-kit-header header-style-<?php echo $style;?>">
    <div class="k-kit-header_logo">
        <?php echo esc_html__('header', 'karmakit'); ?>
    </div>
    <?php
    if($nav){
        karma_kit()->menu($nav);
    }
    ?>

    <a href="" class="">
        <?php echo esc_html__('Register / Login', 'karmakit'); ?>
    </a>

</header>

