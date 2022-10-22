<?php
/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-21
 * @website     : https://karmatechhub.com
 * @var $widget \Elementor\Widget_Base
 */
defined('ABSPATH') or exit();

$style      = $widget->get_settings_for_display('style');
$logo       = $widget->get_settings_for_display('logo');
$logo_url   = $widget->get_settings_for_display('logo_url');
$nav        = $widget->get_settings_for_display('nav');
$copyright  = $widget->get_settings_for_display('copyright');
$socials  = $widget->get_settings_for_display('socials');
?>

<footer class="k-kit-footer">
    <?php
    if($nav){
        karma_kit()->menu($nav);
    }
    ?>
    <div class="k-kit-footer_layout">
        <a href="<?php echo $logo_url ? $logo_url['url'] : home_url();?>" class="k-kit-footer_logo">

            <?php
            if(isset($logo['id']) && !empty($logo['id']) ){
                echo wp_get_attachment_image( $logo['id'], 'full' );
            }elseif($logo){
                echo sprintf('<img src="%s"/>', $logo['url']);
            }
            ?>
        </a>
        <div class="k-kit-footer_social">
            <?php foreach($socials as $social): ?>

                <a href="<?php echo $social['url'] ? $social['url']['url'] : '';?>">
                    <?php \Elementor\Icons_Manager::render_icon( $social['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="k-kit-footer_copyright">
            <?php echo $copyright;?>
        </div>

    </div>
</footer>
