<?php
/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-17
 * @website     : https://karmatechhub.com
 * @var $widget \Elementor\Widget_Base
 */
defined('ABSPATH') or exit();
$style  = $widget->get_settings_for_display('style');
$logo   = $widget->get_settings_for_display('logo');
$logo_url   = $widget->get_settings_for_display('logo_url');
$nav    = $widget->get_settings_for_display('nav');
?>
<header class="k-kit-header header-style-<?php echo $style;?>">
    <a href="<?php echo $logo_url ? esc_url($logo_url['url']) : esc_url(home_url());?>" class="k-kit-header_logo">

        <?php
        if(isset($logo['id']) && !empty($logo['id']) ){
            echo wp_get_attachment_image( $logo['id'], 'full' );
        }elseif($logo){
            echo sprintf('<img src="%s"/>', esc_url($logo['url']));
        }
        ?>
    </a>
    <?php
    if($nav){
        karma_kit()->menu($nav);
    }
    ?>

    <a href="" class="k-kit-header_btn">
        <?php echo esc_html__('Register / Login', 'karmakit'); ?>
    </a>

</header>
