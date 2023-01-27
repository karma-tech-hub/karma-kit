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
        return __('Countdown', 'karmakit');
    }


    /**
     * set widget title
     *
     * @return string|null
     */
    public function get_title()
    {
        return __('Countdown', 'karmakit');
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
                'label' => esc_html__('Content', 'karmakit'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'due_date',
            [
                'label' => esc_html__('Countdown deadline', 'karmakit'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => '2023-05-28 12:00'
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

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .karmakit-countdown',
			]
		);

        $this->add_control(
			'color',
			[
				'label' => esc_html__( 'Text color', 'karmakit' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .countdown-notif'          => 'color: {{VALUE}}',
					'{{WRAPPER}} .countdown-ended'          => 'color: {{VALUE}}',
					'{{WRAPPER}} .countdown-timer-timer'    => 'color: {{VALUE}}',
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
				'label' => esc_html__( 'Countdown color', 'karmakit' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .karmakit-countdown .countdown-timer-timer span'   => 'color: {{VALUE}}'
                ],
			]
		);

        $this->add_control(
			'countdown_backcolor',
			[
				'label' => esc_html__( 'Countdown background', 'karmakit' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
                    '{{WRAPPER}} .karmakit-countdown .countdown-timer-timer span'   => 'background-color: {{VALUE}}'
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
        $settings = $this->get_settings_for_display();
        $element_unique_id = $this->get_unique_selector(); ?>

        <script>
            countdown = setInterval(() => {diff = new Date('<?php echo $settings['due_date']; ?>').getTime() - new Date().getTime();month = Math.floor((diff % (1000 * 60 * 60 * 24 * (365.25 / 12) * 365)) / (1000 * 60 * 60 * 24 * (365.25 / 12)));days = Math.floor(diff % (1000 * 60 * 60 * 24 * (365.25 / 12)) / (1000 * 60 * 60 * 24));hours = Math.floor(diff % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));seconds = Math.floor((diff % (1000 * 60)) / 1000);if (document.querySelector('<?php echo $element_unique_id; ?>').querySelector(".seconds")) {document.querySelector('<?php echo $element_unique_id; ?>').querySelector(".seconds").innerHTML = seconds < 10 ? '0' + seconds : seconds;document.querySelector('<?php echo $element_unique_id; ?>').querySelector(".minutes").innerHTML = minutes < 10 ? '0' + minutes : minutes;document.querySelector('<?php echo $element_unique_id; ?>').querySelector(".hours").innerHTML = hours < 10 ? '0' + hours : hours;document.querySelector('<?php echo $element_unique_id; ?>').querySelector(".days").innerHTML = days < 10 ? '0' + days : days;document.querySelector('<?php echo $element_unique_id; ?>').querySelector(".months").innerHTML = month < 10 ? '0' + month : month;}if (diff <= 0) {document.querySelector('<?php echo $element_unique_id; ?>').querySelector('.karmakit-countdown .countdown-timer').style.display = "none";document.querySelector('<?php echo $element_unique_id; ?>').querySelector('.karmakit-countdown .countdown-ended').style.display = "block";} else {document.querySelector('<?php echo $element_unique_id; ?>').querySelector('.karmakit-countdown .countdown-timer').style.display = "flex";document.querySelector('<?php echo $element_unique_id; ?>').querySelector('.karmakit-countdown .countdown-ended').style.display = "none";}}, 1000);
        </script>

        <div class="karmakit-countdown">
            <?php if (is_admin()) : ?>
                <div class="preload-widget">
                    <small class="countdown-notif"><?php _e('Your timer deadline set to ', 'karmakit'); ?><?php echo $settings['due_date']; ?>.<?php echo _e(' For watching countdown time please view the page.', 'karmakit'); ?></small>
                </div>
            <?php else : ?>
                <div class="countdown-timer">
                    <div class="countdown-notif">
                        50% OFF ON BLACK FRIDAY
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
                    <p>Party's over!</p>
                </div>
            <?php endif; ?>
        </div>

<?php  }
}
