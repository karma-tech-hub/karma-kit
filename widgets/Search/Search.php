<?php

namespace Karma\Widgets\Search;

/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-16
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();

class Search extends \Elementor\Widget_Base
{

    /**
     * set widget name
     *
     * @return string|null
     */
    public function get_name()
    {
        return __('Search', 'karmakit');
    }


    /**
     * set widget title
     *
     * @return string|null
     */
    public function get_title()
    {
        return __('Search', 'karmakit');
    }


    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'eicon-search';
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

        wp_register_style('k-kit-search-css', plugin_dir_url(__FILE__) . '/css/karmakit-search.css');
    }

    /**
     * @return string[]
     */
    public function get_style_depends()
    {
        return ["k-kit-search-css"];
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
                'label' => esc_html__('Search', 'karmakit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label' => esc_html__('Pleceholder', 'karmakit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Search...', 'karmakit'),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'karmakit'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-search',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                    'fa-regular' => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                ],
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
            'height',
            [
                'label' => esc_html__('Height', 'karmakit'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .karmakit-searchbox form' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Background color', 'karmakit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .karmakit-searchbox form' => 'background-color: {{VALUE}}'
                ],
                'default' => '#f0f1f2'
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon color', 'karmakit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .karmakit-searchbox form label' => 'color: {{VALUE}}'
                ],
                'default' => '#9A9EA6'
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text color', 'karmakit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .karmakit-searchbox form input' => 'color: {{VALUE}}'
                ],
                'default' => '#333'
            ]
        );

        $this->add_control(
            'placeholder_color',
            [
                'label' => esc_html__('Placeholder color', 'karmakit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .karmakit-searchbox form input::placeholder' => 'color: {{VALUE}}'
                ],
                'default' => '#9A9EA6'
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border radius', 'karmakit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .karmakit-searchbox form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'karmakit'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .karmakit-searchbox form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
        $settings = $this->get_settings_for_display(); ?>

        <div class="karmakit-searchbox">
            <form action="/" method="get">
                <label for="search">
                    <?php \Elementor\Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
                </label>
                <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="<?php echo $settings['placeholder'] ?>" />
            </form>
        </div>
<?php }
}
