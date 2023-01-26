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
        wp_register_script('k-kit-countdown-js', plugin_dir_url(__FILE__) . '/js/karmakit-countdown.js', ['elementor-frontend'], '1.0.0', true);
    }

    /**
     * @return string[]
     */
    public function get_style_depends()
    {
        return ["k-kit-countdown-css"];
    }

    public function get_script_depends()
    {
        return ['k-kit-countdown-js'];
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
                'label' => esc_html__('Due Date', 'karmakit'),
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

        <script>
            const newDate = new Date('<?php echo $this->get_settings('due_date'); ?>').getTime();
        </script>

        <div class="karmakit-countdown">
            <div class="countdown-timer">
                <div>
                    <span class="number months"></span>
                </div>
                <div>
                    <span class="number days"></span>
                </div>
                <div>
                    <span class="number hours"></span>
                </div>
                <div>
                    <span class="number minutes"></span>
                </div>
                <div>
                    <span class="number seconds"></span>
                </div>
            </div>
            <div class="countdown-ended">
                <p>Party's over!</p>
            </div>
        </div>

    <?php  }

    protected function content_template()
    { ?>
        <div class="karmakit-countdown-preview">
            Your timer deadline set to {{{ settings.due_date }}}. For watching countdown time please view the page.
        </div>
<?php }
}
