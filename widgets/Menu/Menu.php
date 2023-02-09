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
        return __('Menu', 'karma-kit');
    }


    /**
     * set widget title
     *
     * @return string|null
     */
    public function get_title()
    {
        return __('Menu', 'karma-kit');
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
                'label' => esc_html__('Menu', 'karma-kit'),
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
                'label' => esc_html__('Menu', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => $menu_list[0]->name,
                'options' => $menu_list,
            ]
        );

        $this->add_control(
            'responsive_menu',
            [
                'label' => esc_html__('Responsive menu', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => $menu_list[0]->name,
                'options' => $menu_list,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'general_style',
            [
                'label' => esc_html__('General', 'karma-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'menu_typography',
                'selector' => '{{WRAPPER}} #karmakit-nav li a',
                'devices' => ['desktop', 'tablet', 'mobile'],
            ]
        );

        $this->add_control(
            'show_seperator',
            [
                'label' => esc_html__('Show seperator', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'karma-kit'),
                'label_off' => esc_html__('Hide', 'karma-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mainmenu_desktop_style',
            [
                'label' => esc_html__('Main Menu', 'karma-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'space_right',
            [
                'label' => esc_html__('Space between', 'karma-kit'),
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
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav ul > li:not(li:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'menu_align' => 'start',
                ],
            ]
        );

        $this->add_control(
            'space_left',
            [
                'label' => esc_html__('Space between', 'karma-kit'),
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
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav ul > li:not(li:first-child)' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'menu_align' => 'end',
                ],
            ]
        );

        $this->add_control(
            'space_both',
            [
                'label' => esc_html__('Space between', 'karma-kit'),
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
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav ul > li' => 'margin: 0 {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'menu_align' => 'center',
                ],
            ]
        );

        $this->add_control(
            'vertical_padding',
            [
                'label' => esc_html__('Vertical padding', 'karma-kit'),
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
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav > ul > li' => 'padding-top:{{SIZE}}{{UNIT}};padding-bottom:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'menu_align',
            [
                'label' => esc_html__('Alignment', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'karma-kit'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'karma-kit'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'karma-kit'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'start',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav .navbar-nav' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mainmenu_color',
            [
                'label' => esc_html__('Color', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav > ul > li a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} #karmakit-nav > ul > li.menu-item-has-children > a::after' => 'border-color: {{VALUE}}',
                ],
                'default' => '#555555',
            ]
        );

        $this->add_control(
            'mainmenu_backcolor',
            [
                'label' => esc_html__('Background color', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav > ul > li' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'mainmenu_hover_color',
            [
                'label' => esc_html__('Hover color', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav > ul > li:hover > a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} #karmakit-nav > ul > li.menu-item-has-children:hover > a::after' => 'border-color: {{VALUE}}',
                ],
                'default' => '#555555',
            ]
        );

        $this->add_control(
            'mainmenu_hover_backcolor',
            [
                'label' => esc_html__('Hover back-color', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav > ul > li:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'submenu_desktop_style',
            [
                'label' => esc_html__('SubMenu', 'karma-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'submenu_width',
            [
                'label' => esc_html__('Submenu width', 'karma-kit'),
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
                    '{{WRAPPER}} #karmakit-nav ul li ul' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'submenu_color',
            [
                'label' => esc_html__('Color', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav ul ul li a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} #karmakit-nav ul ul li.menu-item-has-children > a::after' => 'border-color: {{VALUE}}',
                ],
                'default' => '#555555',
            ]
        );

        $this->add_control(
            'submenu_backcolor',
            [
                'label' => esc_html__('Background color', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav ul ul li' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'submenu_hover_color',
            [
                'label' => esc_html__('Hover color', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav ul ul li:hover a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} #karmakit-nav ul ul li.menu-item-has-children:hover > a::after' => 'border-color: {{VALUE}}',
                ],
                'default' => '#555555',
            ]
        );

        $this->add_control(
            'submenu_hover_backcolor',
            [
                'label' => esc_html__('Hover back-color', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav ul ul li:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'responsive_style',
            [
                'label' => esc_html__('Responsive', 'karma-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'responsive_color',
            [
                'label' => esc_html__('Color', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav-res li a' => 'color: {{VALUE}}',
                ],
                'default' => '#555555',
            ]
        );

        $this->add_control(
            'responsive_back_color',
            [
                'label' => esc_html__('Background color', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #karmakit-nav-res' => 'background-color: {{VALUE}}',
                ],
                'default' => '#ededed',
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

        if($settings['show_seperator'] !== 'yes'):
        ?>
            <style>#karmakit-nav>ul>li:not(li:last-child)::after{display:none};</style>
        <?php
        else:
        ?>
            <style>#karmakit-nav>ul>li:not(li:last-child)::after{display:block};</style>
        <?php
        endif;

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
