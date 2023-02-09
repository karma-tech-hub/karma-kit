<?php

namespace Karma\Widgets\Countdown;

use Elementor\Repeater;

/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-16
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();

class Countdown extends \Elementor\Widget_Base
{

    /**
     * set widget name
     *
     * @return string|null
     */
    public function get_name()
    {
        return __('Countdown', 'karma-kit');
    }


    /**
     * set widget title
     *
     * @return string|null
     */
    public function get_title()
    {
        return __('Countdown', 'karma-kit');
    }


    /**
     *
     * Set widget icon
     *
     */
    public function get_icon()
    {
        return 'eicon-clock-o';
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

        wp_register_style('k-kit-countdown-css', plugin_dir_url(__FILE__) . '/css/karmakit-countdown.css');
    }

    /**
     * @return string[]
     */
    public function get_style_depends()
    {
        return ["k-kit-countdown-css"];
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
                'label' => esc_html__('Content', 'karma-kit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'due_date',
            [
                'label' => esc_html__('Countdown deadline', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => '2023-05-28 12:00'
            ]
        );

        $this->add_control(
            'countdown_title',
            [
                'label' => esc_html__('Countdown text', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('50% OFF ON BLACK FRIDAY', 'karma-kit'),
            ]
        );

        $this->add_control(
            'countdown_end_title',
            [
                'label' => esc_html__('Countdown over-time text', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Sale campaign is over!', 'karma-kit'),
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
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .karmakit-countdown',
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => esc_html__('Text color', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .countdown-notif'          => 'color: {{VALUE}}',
                    '{{WRAPPER}} .countdown-ended'          => 'color: {{VALUE}}',
                    '{{WRAPPER}} .countdown-timer-timer'    => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'karma-kit' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 45,
				],
				'selectors' => [
					'{{WRAPPER}} .karmakit-countdown' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selectors' => [
                    '{{WRAPPER}} .countdown-notif',
                    '{{WRAPPER}} .countdown-ended',
                    '{{WRAPPER}} .countdown-timer-timer',
                ],
            ]
        );

        $this->add_control(
            'countdown_color',
            [
                'label' => esc_html__('Timer color', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .karmakit-countdown .countdown-timer-timer span'   => 'color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'countdown_backcolor',
            [
                'label' => esc_html__('Timer background', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .karmakit-countdown .countdown-timer-timer span'   => 'background-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'close_color',
            [
                'label' => esc_html__('Close button color', 'karma-kit'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .karmakit-countdown svg path'   => 'fill: {{VALUE}}'
                ],
                'default' => '#ffffff'
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
        $element_unique_id = $this->get_unique_selector(); ?>
        <?php if (!is_admin()) : ?>
            <script>
                countdown = setInterval(() => {
                    diff = new Date('<?php echo $settings['due_date']; ?>').getTime() - new Date().getTime();
                    month = Math.floor((diff % (1000 * 60 * 60 * 24 * (365.25 / 12) * 365)) / (1000 * 60 * 60 * 24 * (365.25 / 12)));
                    days = Math.floor(diff % (1000 * 60 * 60 * 24 * (365.25 / 12)) / (1000 * 60 * 60 * 24));
                    hours = Math.floor(diff % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
                    minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    seconds = Math.floor((diff % (1000 * 60)) / 1000);
                    if (document.querySelector('<?php echo $element_unique_id; ?>').querySelector(".seconds")) {
                        document.querySelector('<?php echo $element_unique_id; ?>').querySelector(".seconds").innerHTML = seconds < 10 ? '0' + seconds : seconds;
                        document.querySelector('<?php echo $element_unique_id; ?>').querySelector(".minutes").innerHTML = minutes < 10 ? '0' + minutes : minutes;
                        document.querySelector('<?php echo $element_unique_id; ?>').querySelector(".hours").innerHTML = hours < 10 ? '0' + hours : hours;
                        document.querySelector('<?php echo $element_unique_id; ?>').querySelector(".days").innerHTML = days < 10 ? '0' + days : days;
                        document.querySelector('<?php echo $element_unique_id; ?>').querySelector(".months").innerHTML = month < 10 ? '0' + month : month;
                    }
                    if (diff <= 0) {
                        document.querySelector('<?php echo $element_unique_id; ?>').querySelector('.karmakit-countdown .countdown-timer').style.display = "none";
                        document.querySelector('<?php echo $element_unique_id; ?>').querySelector('.karmakit-countdown .countdown-ended').style.display = "block";
                    } else {
                        document.querySelector('<?php echo $element_unique_id; ?>').querySelector('.karmakit-countdown .countdown-timer').style.display = "flex";
                        document.querySelector('<?php echo $element_unique_id; ?>').querySelector('.karmakit-countdown .countdown-ended').style.display = "none";
                    }
                }, 1000);
            </script>
        <?php endif; ?>

        <div class="karmakit-countdown">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.3034 18.0104C17.4986 18.2057 17.8152 18.2057 18.0105 18.0104C18.2057 17.8151 18.2057 17.4986 18.0105 17.3033L12.7072 12L18.0105 6.6967C18.2057 6.50144 18.2057 6.18485 18.0105 5.98959C17.8152 5.79433 17.4986 5.79433 17.3034 5.98959L12.0001 11.2929L6.69676 5.98959C6.5015 5.79433 6.18492 5.79433 5.98965 5.98959C5.79439 6.18486 5.79439 6.50144 5.98965 6.6967L11.293 12L5.98966 17.3033C5.79439 17.4986 5.79439 17.8151 5.98966 18.0104C6.18492 18.2057 6.5015 18.2057 6.69676 18.0104L12.0001 12.7071L17.3034 18.0104Z" fill="white" />
            </svg>
            <?php if (is_admin()) : ?>
                <div class="preload-widget">
                    <small class="countdown-notif"><?php _e('Your timer deadline set to ', 'karma-kit'); ?><?php echo $settings['due_date']; ?>.<?php echo _e(' For watching countdown time please view the page.', 'karma-kit'); ?></small>
                </div>
            <?php else : ?>
                <div class="countdown-timer">
                    <div class="countdown-notif">
                        <?php echo $settings['countdown_title']; ?>
                    </div>
                    <div class="countdown-timer-timer">
                        <span class="number months">00</span>:
                        <span class="number days">00</span>:
                        <span class="number hours">00</span>:
                        <span class="number minutes">00</span>:
                        <span class="number seconds">00</span>
                    </div>
                </div>
                <div class="countdown-ended">
                    <?php echo $settings['countdown_end_title']; ?>
                </div>
            <?php endif; ?>
        </div>
        <script>
            document.querySelector('<?php echo $element_unique_id; ?> .karmakit-countdown svg').addEventListener('click', () => {
                document.querySelector('<?php echo $element_unique_id; ?> .karmakit-countdown').style.display = 'none';
            });
        </script>

<?php  }
}
