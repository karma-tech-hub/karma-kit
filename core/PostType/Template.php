<?php

namespace Karma\Kit\PostType;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use WpTool\Helper\PostType;

/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-18
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();

class Template extends PostType
{


    /**
     * post type name
     *
     * @var string
     */
    protected $type = 'karma-kit-template';

    protected $args = [
        'supports'              => array('title', 'editor', 'revisions', 'elementor'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 25,
        'menu_icon'             => 'dashicons-editor-kitchensink',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'rewrite'               => false,
        'capability_type'       => 'page'
    ];

    protected $labels = [
        'name'                  => 'Karma Templates',
        'singular_name'         => 'Karma Template',
        'menu_name'             => 'Karma Templates',
        'name_admin_bar'        => 'Karma Template',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New karma template',
        'new_item'              => 'New karma template',
        'edit_item'             => 'Edit karma template',
        'view_item'             => 'View karma template',
        'all_items'             => 'All karma templates',
        'search_items'          => 'Search karma templates',
        'parent_item_colon'     => 'Parent karma templates:',
        'not_found'             => 'No karma templates found.',
        'not_found_in_trash'    => 'No karma templates found in Trash.',
    ];



    /**
     * get all templates
     *
     * @var $templates
     */
    protected static $templates;


    /**
     * template types
     *
     * @var string[]
     */
    protected $template_types = [
        ''                  => 'Select Template Type',
        'top-bar'           => 'Top Bar',
        'header'            => 'Header',
        'before-footer'     => 'Before Footer',
        'footer'            => 'Footer',
    ];


    /**
     * template display rules
     *
     * @var string[]
     */
    protected $template_display_rules = [
        'basic-global'                   => 'Entire Website',
        'basic-singulars'                => 'All Singulars',
        'basic-archives'                 => 'All Archives',
        'special-404'                    => '404 Page',
        'special-search'                 => 'Search Page',
        'special-blog'                   => 'Blog / Posts Page',
        'special-front'                  => 'Front Page',
        'special-date'                   => 'Date Archive',
        'special-author'                 => 'Author Archive',
        'post|all'                       => 'All Posts',
        'post|all|archive'               => 'All Posts Archive',
        'post|all|taxarchive|category'   => 'All Categories Archive',
        'post|all|taxarchive|post_tag'   => 'All Tags Archive',
        'page|all'                       => 'All Pages',
        'e-landing-page|all'             => 'All Landing Pages',
        'e-landing-page|all|archive'     => 'All Landing Pages Archive',
        'elementor_library|all'          => 'All Landing Pages',
        'elementor_library|all|archive'  => 'All Landing Pages Archive',
        'karma-kit-template|all'         => 'All Templates',
        'karma-kit-template|all|archive' => 'All Templates Archive'
    ];


    /**
     * template user rules
     *
     * @var string[]
     */
    protected $template_user_rules = [
        'all'           => 'All',
        'logged-in'     => 'Logged In',
        'logged-out'    => 'Logged Out',
        'administrator' => 'Administrator',
        'editor'        => 'Editor',
        'author'        => 'Author',
        'contributor'   => 'Contributor',
        'subscriber'    => 'Subscriber'
    ];


    /**
     * init template
     *
     * @return void
     */
    public function init()
    {
        add_filter('single_template', [$this, 'load_canvas_template']);

        add_action('init', [$this, 'register_metabox']);
        add_action('save_post', [$this, 'sync_templates'], 99, 3);
        add_action('template_redirect', [$this, 'block_template_frontend']);
    }

    /**
     * load template
     *
     * @return void
     */
    public function load_canvas_template($single_template)
    {
        global $post;

        if ($this->type == $post->post_type && defined('ELEMENTOR_PATH') && ELEMENTOR_PATH) {
            $elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

            if (file_exists($elementor_2_0_canvas)) {
                return $elementor_2_0_canvas;
            } else {
                return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
            }
        }

        return $single_template;
    }

    /**
     * redirect post
     *
     * @return void
     */
    public function block_template_frontend()
    {
        if (is_singular($this->type) && !current_user_can('edit_posts')) {
            wp_redirect(site_url(), 301);
            die;
        }
    }

    /**
     * get port type
     *
     * @return string
     */
    public function get_post_type()
    {
        return $this->type;
    }


    /**
     * get all template
     *
     * @return int[]|\WP_Post[]
     */
    public static function get_all_templates()
    {
        if (!self::$templates) {

            $query = new \WP_Query([
                'post_type' => self::get_post_type(),
                'post_status' => ['publish'],
            ]);

            self::$templates = $query->get_posts();
        }

        return self::$templates;
    }


    /**
     * sync template
     *
     * @param int $post_id
     * @param \WP_Post $post
     * @param $update
     *
     * @return void
     */
    public function sync_templates($post_id, $post, $update)
    {
        if ($post->post_type == $this->type) {
            $query = new \WP_Query([
                'post_type'         => [$this->type],
                'post_status'       => ['publish'],
                'posts_per_page'    => -1,
                'fields'            => 'ids'
            ]);

            $templates        = [];

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();

                    $type           = get_post_meta(get_the_ID(), 'karma_template_type', true);
                    $display_on     = get_post_meta(get_the_ID(), 'karma_display_on', true);
                    $not_display_on = get_post_meta(get_the_ID(), 'karma_not_display_on', true);
                    $user_rule      = get_post_meta(get_the_ID(), 'karma_user_rule', true);

                    $templates[] = [
                        'id'                => get_the_ID(),
                        'title'             => get_the_title(get_the_ID()),
                        'type'              => $type,
                        'display_on'        => $display_on,
                        'not_display_on'    => $not_display_on,
                        'user_rule'         => $user_rule,
                    ];
                }
            }


            update_option('karma_kit_templates', $templates);
        }
    }


    /**
     * register metabox
     *
     * @return void
     */
    public function register_metabox()
    {

        $types          = get_post_types();
        $footers        = karma_get_current_templates('footer', 'select');
        $headers        = karma_get_current_templates('header', 'select');
        $top_bars       = karma_get_current_templates('top-bar', 'select');
        $before_footers = karma_get_current_templates('before-footer', 'select');

        if ($types[$this->type]) {
            unset($types[$this->type]);
        }

        wpify_custom_fields()->create_metabox([
            'title'      => __('Layout Template', 'karma-kit'),
            'post_types' => $types,
            'priority'   => 'high',
            'items'      => [
                array(
                    'type'  => 'select',
                    'title' => __('Top Bar', 'karma-kit'),
                    'id'    => 'karma_top_bar',
                    'options'    =>  $top_bars
                ),
                array(
                    'type'  => 'select',
                    'title' => __('Header', 'karma-kit'),
                    'id'    => 'karma_header',
                    'options'    =>  $headers
                ),
                array(
                    'type'  => 'select',
                    'title' => __('Before Footer', 'karma-kit'),
                    'id'    => 'karma_before_footer',
                    'options'    =>  $before_footers
                ),
                array(
                    'type'  => 'select',
                    'title' => __('Footer', 'karma-kit'),
                    'id'    => 'karma_footer',
                    'options'    =>  $footers
                ),
            ]
        ]);

        wpify_custom_fields()->create_metabox(array(

            'title'      => __('Template Options', 'karma-kit'),
            'post_types' => array($this->type),
            'priority'      => 'high',
            'items'      => array(
                array(
                    'type'  => 'select',
                    'title' => __('Template Type', 'karma-kit'),
                    'id'    => 'karma_template_type',
                    'options'    =>  convert_array_select_options($this->template_types)
                ),
                array(
                    'type'  => 'multi_select',
                    'title' => __('Display On', 'karma-kit'),
                    'id'    => 'karma_display_on',
                    'options'    =>  convert_array_select_options($this->template_display_rules)
                ),
                array(
                    'type'  => 'multi_select',
                    'title' => __('Not Display On', 'karma-kit'),
                    'id'    => 'karma_not_display_on',
                    'options'    =>  convert_array_select_options($this->template_display_rules)
                ),
                array(
                    'type'  => 'multi_select',
                    'title' => __('User Rule', 'karma-kit'),
                    'id'    => 'karma_user_rule',
                    'options'    =>  convert_array_select_options($this->template_user_rules)
                ),
            ),
        ));
    }
}
