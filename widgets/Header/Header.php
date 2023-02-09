<?php

namespace Karma\Widgets\Header;

/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-16
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();

class Header extends \Elementor\Widget_Base
{

    /**
     * set widget name
     *
     * @return string|null
     */
    public function get_name()
    {
        return __('Header', 'karma-kit');
    }


    /**
     * set widget title
     *
     * @return string|null
     */
    public function get_title()
    {
        return __('Header', 'karma-kit');
    }


    /**
     * set widget category
     *
     * @return array
     */
    public function get_categories()
    {
        return [ KARMA_KIT_GROUP ];
    }

    /**
     * @param $data
     * @param $args
     *
     * @throws \Exception
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        wp_register_style( 'k-kit-header', plugin_dir_url( __FILE__ ) . '/css/header-one.css' );

    }

    /**
     * @return string[]
     */
    public function get_style_depends(){

        return [
            "k-kit-header"
        ];
    }


    /**
     * register controls
     *
     * @return void
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'layouts',
            [
                'label' => esc_html__( 'Layout', 'karma-kit' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );


        $this->add_control(
            'layout',
            [
                'type' => \Elementor\Controls_Manager::SELECT,
                'label' => esc_html__( 'Layout', 'karma-kit' ),
                'options' => [
                    'one' => 'Layout One',
                ],
                'default' => 'one'
            ]
        );


        $this->add_control(
            'style',
            [
                'type' => \Elementor\Controls_Manager::SELECT,
                'label' => esc_html__( 'Style', 'karma-kit' ),
                'options' => [
                    'style-one' => 'Style One',
                    'style-two' => 'Style Two',
                    'style-three' => 'Style Three',
                ],
                'default' => 'style-one'
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'logo_section',
            [
                'label' => esc_html__( 'Logo', 'karma-kit' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'show_logo',
            [
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Show Logo', 'karma-kit' ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'logo',
            [
                'type' => \Elementor\Controls_Manager::MEDIA,
                'label' => esc_html__( 'Logo', 'karma-kit' ),
                'default' => [
                    'url' => KARMA_KIT_URL . 'widgets/Header/img/logo.png'
                ]
            ]
        );

        $this->add_control(
            'logo_url',
            [
                'type' => \Elementor\Controls_Manager::URL,
                'label' => esc_html__( 'Logo Url', 'karma-kit' ),
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'nav_section',
            [
                'label' => esc_html__( 'Nav', 'karma-kit' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Show Nav', 'karma-kit' ),
                'default' => 'yes'
            ]
        );


        $menus = get_terms( 'nav_menu' );
        $menus = array_combine( wp_list_pluck( $menus, 'term_id' ), wp_list_pluck( $menus, 'name' ) );

        $this->add_control(
            'nav',
            [
                'type' => \Elementor\Controls_Manager::SELECT,
                'label' => esc_html__( 'Nav', 'karma-kit' ),
                'options' => $menus
            ]
        );



        $this->end_controls_section();


        $this->start_controls_section(
            'button',
            [
                'label' => esc_html__( 'Button', 'karma-kit' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_button',
            [
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Show Button', 'karma-kit' ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'button',
            [
                'type' => \Elementor\Controls_Manager::TEXT,
                'label' => esc_html__( 'Button Text', 'karma-kit' ),
                'default' => 'Register / Login'
            ]
        );

        $this->add_control(
            'button_url',
            [
                'type' => \Elementor\Controls_Manager::URL,
                'label' => esc_html__( 'Button Url', 'karma-kit' ),
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'logo_style',
            [
                'label' => esc_html__( 'Logo', 'karma-kit' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
            'nav_style',
            [
                'label' => esc_html__( 'Nav', 'karma-kit' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_responsive_control(
            'nav_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__( 'Padding', 'karma-kit' ),
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .k-kit-menu a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 8,
                    'right' => 10,
                    'bottom' => 8,
                    'left' => 10,
                    'unit' => 'px',
                    'isLinked' => false,
                ]
            ]
        );
        $this->add_control(
            'nav_color',
            [
                'label' => esc_html__( 'Nav Color', 'karma-kit' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .k-kit-menu a' => 'color: {{VALUE}};',
                ],
                'default' => '#9A9EA6',
            ]
        );
        $this->add_control(
            'nav_color_hover',
            [
                'label' => esc_html__( 'Nav Hover Color', 'karma-kit' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .k-kit-menu a:hover' => 'color: {{VALUE}};',
                ],
                'default' => '#4475F2',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'nav_typography',
                'selector' => '{{WRAPPER}} .k-kit-menu a',
                'fields_options' => [
                    'typography' => ['default' => 'Plus Jakarta Display'],
                    'font_size' => ['default' => ['size' => 14]],
                    'font_weight' => ['default' => 400]
                ],

            ]
        );


        $this->end_controls_section();
        $this->start_controls_section(
            'button_style',
            [
                'label' => esc_html__( 'Button', 'karma-kit' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_bg',
            [
                'label' => esc_html__( 'Button Background Color', 'karma-kit' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .k-kit-header_btn' => 'background-color: {{VALUE}};',
                ],
                'default' => '#4475F2',
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Button Color', 'karma-kit' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .k-kit-header_btn' => 'color: {{VALUE}};',
                ],
                'default' => '#fff',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .k-kit-header_btn',
                'fields_options' => [
                    'typography' => ['default' => 'Plus Jakarta Display'],
                    'font_size' => ['default' => ['size' => 12]],
                    'font_weight' => ['default' => 400]
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .k-kit-header_btn',
            ]
        );
        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'karma-kit' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .k-kit-header_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

                'default' => [
                    'top' => 30,
                    'right' => 30,
                    'bottom' => 30,
                    'left' => 30,
                    'unit' => 'px',
                    'isLinked' => true,
                ]
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__( 'Padding', 'karma-kit' ),
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .k-kit-header_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 16,
                    'right' => 38,
                    'bottom' => 16,
                    'left' => 38,
                    'unit' => 'px',
                    'isLinked' => false,
                ]
            ]
        );

        $this->end_controls_section();

    }

    /**
     * get layout
     *
     * @return mixed
     */
    public function get_layout()
    {
        $layout = $this->get_settings_for_display('layout');
        return $layout ? '-' . $layout : false;
    }


    /**
     * render widget
     *
     * @return void
     */
    protected function render()
    {
        $layout = $this->get_layout();
        karma_kit()->view_widget("Header/view/header{$layout}", [
            'widget' => $this
        ]);
    }


}
