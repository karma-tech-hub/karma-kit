<?php

namespace Karma\Widgets\Logo;
/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : karma team
 * @date        : 2023-01-26
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();

class Logo extends \Elementor\Widget_Base
{

    /**
     * @inheritDoc
     */
    public function get_name()
    {
        return 'karma-logo';
    }

    public function get_title()
    {
        return __('Logo', 'karmakit');
    }

    public function get_categories()
    {
        return [ KARMA_KIT_GROUP ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'view',
            [
                'label' => esc_html__( 'View', 'karmakit' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'custom',
            [
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Custom Logo', 'karmakit' )
            ]
        );

        $this->add_control(
            'logo',
            [
                'type' => \Elementor\Controls_Manager::MEDIA,
                'label' => esc_html__( 'Logo', 'karmakit' ),
                'default' => [
                    'url' => ELEMENTOR_URL . 'assets/img/placeholder.png',
                ],
                'condition' => [
                    'custom' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'logo_width',
            [
                'type' => \Elementor\Controls_Manager::SLIDER,
                'label' => esc_html__( 'Logo Width', 'karmakit' ),
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
            ]
        );


        $this->end_controls_section();
    }


    protected function render()
    {
        $custom         = $this->get_settings('custom');
        $custom_logo    = $this->get_settings('logo');
        $logo_width     = $this->get_settings('logo_width');
        $url            = '';
        $width          = 163;
        $custom_logo_id = get_theme_mod('custom_logo');
        $logo           = wp_get_attachment_image_src($custom_logo_id, 'full');

        /**
         * init image size
         */
        if($logo_width['size']){
            $width = $logo_width['size'];
        }

        /**
         * use site logo
         */
        if ( is_array($logo) ) {
            $url = $logo[0];
        }

        /**
         * use custom logo
         */
        if($custom && $custom_logo){
            $url = $custom_logo['url'];
        }

        $image = sprintf(
            "<img src='%s' alt='%s' width='%s' />",
            $url,
            get_bloginfo('name'),
            $width
        );

        echo sprintf('<a href="%s" class="%s" rel="home">%s</a>',
            esc_url( home_url( '/' ) ),
            apply_filters('karma_logo_class', 'karmakit-logo'),
            $image
        );
    }

}
