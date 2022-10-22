<?php
namespace Karma\Widgets\Footer;
use Elementor\Repeater;

/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-16
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();

class Footer extends \Elementor\Widget_Base
{

    /**
     * set widget name
     *
     * @return string|null
     */
    public function get_name()
    {
        return __('Footer', 'karmakit');
    }


    /**
     * set widget title
     *
     * @return string|null
     */
    public function get_title()
    {
        return __('Footer', 'karmakit');
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

        wp_register_style( 'k-kit-footer', plugin_dir_url( __FILE__ ) . '/css/footer.css' );

    }

    /**
     * @return string[]
     */
    public function get_style_depends(){

        return [
            "k-kit-footer"
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
                'label' => esc_html__( 'Layout', 'karmakit' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );


        $this->add_control(
            'layout',
            [
                'type' => \Elementor\Controls_Manager::SELECT,
                'label' => esc_html__( 'Layout', 'karmakit' ),
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
                'label' => esc_html__( 'Style', 'karmakit' ),
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
                'label' => esc_html__( 'Logo', 'karmakit' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'show_logo',
            [
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Show Logo', 'karmakit' ),
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'logo',
            [
                'type' => \Elementor\Controls_Manager::MEDIA,
                'label' => esc_html__( 'Logo', 'karmakit' ),
                'default' => [
                    'url' => KARMA_KIT_URL . 'widgets/Header/img/logo.png'
                ]
            ]
        );

        $this->add_control(
            'logo_url',
            [
                'type' => \Elementor\Controls_Manager::URL,
                'label' => esc_html__( 'Logo Url', 'karmakit' ),
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'copyright_section',
            [
                'label' => esc_html__( 'Copyright', 'karmakit' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        $this->add_control(
            'copyright',
            [
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'label' => esc_html__( 'Copyright', 'karmakit' ),
                'default' => '© 2000-2021, All Rights Reserved'
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'nav_section',
            [
                'label' => esc_html__( 'Nav', 'karmakit' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Show Nav', 'karmakit' ),
                'default' => 'yes'
            ]
        );


        $menus = get_terms( 'nav_menu' );
        $menus = array_combine( wp_list_pluck( $menus, 'term_id' ), wp_list_pluck( $menus, 'name' ) );

        $this->add_control(
            'nav',
            [
                'type' => \Elementor\Controls_Manager::SELECT,
                'label' => esc_html__( 'Nav', 'karmakit' ),
                'options' => $menus
            ]
        );



        $this->end_controls_section();


        $this->start_controls_section(
            'social_section',
            [
                'label' => esc_html__( 'Social', 'karmakit' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'icon',
            [
                'type' => \Elementor\Controls_Manager::ICONS,
                'label' => esc_html__( 'Icon', 'karmakit' )
            ]
        );


        $repeater->add_control(
            'url',
            [
                'type' => \Elementor\Controls_Manager::URL,
                'label' => esc_html__( 'Url', 'karmakit' )
            ]
        );

        $this->add_control(
            'socials',
            [
                'type' => \Elementor\Controls_Manager::REPEATER,
                'label' => esc_html__( 'Social Media', 'karmakit' ),
                'fields' => $repeater->get_controls()
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'logo_style',
            [
                'label' => esc_html__( 'Logo', 'karmakit' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
            'social_style',
            [
                'label' => esc_html__( 'Social', 'karmakit' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'social_style_tabs'
        );

        $this->start_controls_tab(
            'social_style_normal',
            [
                'label' => esc_html__( 'Normal', 'karmakit' ),
            ]
        );

        $this->add_control(
            'social_color',
            [
                'label' => esc_html__( 'Social Color', 'karmakit' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .k-kit-footer_social a' => 'color: {{VALUE}};',
                ],
                'default' => '#4475F2',
            ]
        );

        $this->add_control(
            'social_bg',
            [
                'label' => esc_html__( 'Social Background', 'karmakit' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .k-kit-footer_social a' => 'background-color: {{VALUE}};',
                ],
                'default' => '#E3EBFD',
            ]
        );

        $this->end_controls_tab();


        $this->start_controls_tab(
            'social_style_hover',
            [
                'label' => esc_html__( 'Hover', 'karmakit' ),
            ]
        );

        $this->add_control(
            'social_color_hover',
            [
                'label' => esc_html__( 'Social Color', 'karmakit' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .k-kit-footer_social a:hover' => 'color: {{VALUE}};',
                ],
                'default' => '#fff',
            ]
        );

        $this->add_control(
            'social_bg_hover',
            [
                'label' => esc_html__( 'Social Background', 'karmakit' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .k-kit-footer_social a:hover' => 'background-color: {{VALUE}};',
                ],
                'default' => '#4475F2',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'copyright_style',
            [
                'label' => esc_html__( 'Copyright', 'karmakit' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'copyright_typography',
                'selector' => '{{WRAPPER}} .k-kit-footer_copyright',
                'fields_options' => [
                    'typography' => ['default' => 'Plus Jakarta Display'],
                    'font_size' => ['default' => ['size' => 14]],
                    'font_weight' => ['default' => 400]
                ],

            ]
        );


        $this->add_control(
            'copyright_color',
            [
                'label' => esc_html__( 'Copyright Color', 'karmakit' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .k-kit-footer_copyright' => 'color: {{VALUE}};',
                ],
                'default' => '#9A9EA6',
            ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
            'nav_style',
            [
                'label' => esc_html__( 'Nav', 'karmakit' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_responsive_control(
            'nav_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__( 'Padding', 'karmakit' ),
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
                'label' => esc_html__( 'Nav Color', 'karmakit' ),
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
                'label' => esc_html__( 'Nav Hover Color', 'karmakit' ),
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
        karma_kit()->view_widget("Footer/view/footer{$layout}", [
            'widget' => $this
        ]);
    }


}
