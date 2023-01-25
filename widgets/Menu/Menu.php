<?php

namespace Karma\Widgets\Menu;

use Elementor\Repeater;

/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-16
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();

class Menu extends \Elementor\Widget_Base
{

    /**
     * set widget name
     *
     * @return string|null
     */
    public function get_name()
    {
        return __('Menu', 'karmakit');
    }


    /**
     * set widget title
     *
     * @return string|null
     */
    public function get_title()
    {
        return __('Menu', 'karmakit');
    }


    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'eicon-nav-menu';
    }


    /**
     * set widget category
     *
     * @return array
     */
    public function get_categories()
    {
        return [KARMA_KIT_GROUP];
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

        wp_register_style('k-kit-navabr-css', plugin_dir_url(__FILE__) . '/css/karmakit-menu.css');
        wp_register_script('k-kit-navbar-js', plugin_dir_url(__FILE__) . '/js/karmakit-menu.js', ['elementor-frontend'], '1.0.0', true);
    }

    /**
     * @return string[]
     */
    public function get_style_depends()
    {
        return ["k-kit-navabr-css"];
    }

    public function get_script_depends()
    {
        return ['k-kit-navbar-js'];
    }

    /**
     * register controls
     *
     * @return void
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'content',
            [
                'label' => esc_html__('Menu', 'karmakit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $menu_list = [];

        foreach (get_terms('nav_menu') as $menu) {
            $menu_list += [
                $menu->name => $menu->name
            ];
        };

        $this->add_control(
            'menu',
            [
                'label' => esc_html__('Select menu', 'karmakit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => $menu_list[0]->name,
                'options' => $menu_list,
            ]
        );

        $this->add_control(
            'responsive_menu',
            [
                'label' => esc_html__('Select menu (responsive)', 'karmakit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => $menu_list[0]->name,
                'options' => $menu_list,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'general_style',
            [
                'label' => esc_html__('General', 'karmakit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'space_right',
            [
                'label' => esc_html__('Space between', 'karmakit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} ul > li:not(li:last-child)' => 'padding-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'menu_align' => 'start',
                ],
            ]
        );

        $this->add_control(
            'space_left',
            [
                'label' => esc_html__('Space between', 'karmakit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} ul > li:not(li:first-child)' => 'padding-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'menu_align' => 'end',
                ],
            ]
        );

        $this->add_control(
            'space_both',
            [
                'label' => esc_html__('Space between', 'karmakit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} ul > li' => 'padding: 0 {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'menu_align' => 'center',
                ],
            ]
        );

        $this->add_control(
            'submenu_width',
            [
                'label' => esc_html__('Submenu width', 'karmakit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'selectors' => [
                    '{{WRAPPER}} ul li ul' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'menu_align',
            [
                'label' => esc_html__('Alignment', 'karmakit'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'karmakit'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'karmakit'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'karmakit'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'start',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .navbar-nav' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mainmenu_style',
            [
                'label' => esc_html__('Main menu', 'karmakit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'mainmenu_color',
            [
                'label' => esc_html__('Color', 'karmakit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul li a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'submenu_style',
            [
                'label' => esc_html__('Submenu', 'karmakit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mobile_mainmenu_style',
            [
                'label' => esc_html__('Mobile menu', 'karmakit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mobile_submenu_style',
            [
                'label' => esc_html__('Mobile Submenu', 'karmakit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->end_controls_section();
    }



    /**
     * render widget
     *
     * @return void
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        echo wp_nav_menu([
            'menu' => $settings['menu'],
            'depth'           => 6,
            'container'       => 'div',
            'container_class' => '',
            'container_id'    => 'karmakit-nav',
            'menu_class'      => 'navbar-nav',
        ]); ?>

        <div id="karmakit-nav-res-area">
            <input type="checkbox" />
            <span></span>
            <span></span>
            <span></span>
            <?php
            echo wp_nav_menu([
                'menu' => $settings['responsive_menu'],
                'depth'           => 2,
                'container'       => '',
                'menu_class'      => '',
                'menu_id'         => 'karmakit-nav-res',
            ]);
            ?>
        </div>
<?php
    }
}
