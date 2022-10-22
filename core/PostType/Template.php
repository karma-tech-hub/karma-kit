<?php
namespace Karma\Kit\PostType;

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
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'exclude_from_search' => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_icon'           => 'dashicons-editor-kitchensink',
        'supports'            => [ 'title', 'thumbnail', 'elementor' ],
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


    public function init()
    {
        add_filter( 'single_template', [ $this, 'load_canvas_template' ] );

        if( class_exists( 'CSF' ) ){
            $this->register_metabox();
        }
        add_action( 'save_post', [ $this, 'sync_templates' ] , 99, 3);
        add_action( 'template_redirect', [ $this, 'block_template_frontend' ] );


    }

    /**
     * load template
     *
     * @return void
     */
    public function load_canvas_template($single_template)
    {
        global $post;

        if ( $this->type == $post->post_type && defined('ELEMENTOR_PATH') && ELEMENTOR_PATH ) {
            $elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

            if ( file_exists( $elementor_2_0_canvas ) ) {
                return $elementor_2_0_canvas;
            } else {
                return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
            }
        }

        return $single_template;
    }

    /**
     * register metabox
     *
     * @return void
     */
    public function register_metabox()
    {

        $prefix = 'kk_template_options';

        // Create a metabox
        \CSF::createMetabox( $prefix, array(
            'title'     => 'Template Options',
            'post_type' => $this->type,
            'data_type'          => 'unserialize',
            'priority'              => 'high',
        ) );


        // Create a section
        \CSF::createSection( $prefix, array(
            'fields' => array(

                array(
                    'id'    => 'template_type',
                    'type'  => 'select',
                    'title' => 'Template Type',
                    'options' => [
                        'header' => 'Header',
                        'before_footer' => 'Before Footer',
                        'footer' => 'Footer',
                    ]
                ),

                array(
                    'id'    => 'display_on',
                    'type'  => 'select',
                    'title'  => 'Display On',
                    'chosen'      => true,
                    'multiple'    => true,
                    'options'      => array(
                        '' => 'Select',
                        'Basic'    => array(
                            'basic-global'      => 'Entire Website',
                            'basic-singulars'   => 'All Singulars',
                            'basic-archives'    => 'All Archives',
                        ),
                        'Special Pages'    => array(
                            'special-404'       => '404 Page',
                            'special-search'    => 'Search Page',
                            'special-blog'      => 'Blog / Posts Page',
                            'special-front'     => 'Front Page',
                            'special-date'      => 'Date Archive',
                            'special-author'    => 'Author Archive',
                        ),
                        'Posts'    => array(
                            'post|all'          => 'All Posts',
                            'post|all|archive'    => 'All Posts Archive',
                            'post|all|taxarchive|category'      => 'All Categories Archive',
                            'post|all|taxarchive|post_tag'     => 'All Tags Archive'
                        ),
                        'Pages'    => array(
                            'page|all'          => 'All Pages'
                        ),
                        'Landing Pages'    => array(
                            'e-landing-page|all'            => 'All Landing Pages',
                            'e-landing-page|all|archive'    => 'All Landing Pages Archive',
                        ),
                        'My Templates'    => array(
                            'elementor_library|all'            => 'All Landing Pages',
                            'elementor_library|all|archive'    => 'All Landing Pages Archive',
                        ),
                        'Templates'    => array(
                            'karma-kit-template|all'            => 'All Templates',
                            'karma-kit-template|all|archive'    => 'All Templates Archive',
                        ),
                    ),
                ),
                array(
                    'id'    => 'not_display_on',
                    'type'  => 'select',
                    'title'  => 'Do Not Display On',
                    'chosen'      => true,
                    'multiple'    => true,
                    'options'      => array(
                        '' => 'Select',
                        'Basic'    => array(
                            'basic-global'      => 'Entire Website',
                            'basic-singulars'   => 'All Singulars',
                            'basic-archives'    => 'All Archives',
                        ),
                        'Special Pages'    => array(
                            'special-404'       => '404 Page',
                            'special-search'    => 'Search Page',
                            'special-blog'      => 'Blog / Posts Page',
                            'special-front'     => 'Front Page',
                            'special-date'      => 'Date Archive',
                            'special-author'    => 'Author Archive',
                            'special-woo-shop'  => 'Shop Page',
                        ),
                        'Posts'    => array(
                            'post|all'          => 'All Posts',
                            'post|all|archive'    => 'All Posts Archive',
                            'post|all|taxarchive|category'      => 'All Categories Archive',
                            'post|all|taxarchive|post_tag'     => 'All Tags Archive'
                        ),
                        'Pages'    => array(
                            'page|all'          => 'All Pages'
                        ),
                        'Landing Pages'    => array(
                            'e-landing-page|all'            => 'All Landing Pages',
                            'e-landing-page|all|archive'    => 'All Landing Pages Archive',
                        ),
                        'My Templates'    => array(
                            'elementor_library|all'            => 'All Landing Pages',
                            'elementor_library|all|archive'    => 'All Landing Pages Archive',
                        ),
                        'Templates'    => array(
                            'karma-kit-template|all'            => 'All Templates',
                            'karma-kit-template|all|archive'    => 'All Templates Archive',
                        ),
                    ),
                ),

                array(
                    'id'    => 'user_rule',
                    'type'  => 'select',
                    'chosen'      => true,
                    'multiple'    => true,
                    'title' => 'User Roles',
                    'options'      => array(
                        '' => 'Select',
                        'Basic'    => array(
                            'all'           => 'All',
                            'logged-in'     => 'Logged In',
                            'logged-out'    => 'Logged Out',
                        ),
                        'Advanced'    => array(
                            'administrator' => 'Administrator',
                            'editor'        => 'Editor',
                            'author'        => 'Author',
                            'contributor'   => 'Contributor',
                            'subscriber'    => 'Subscriber',
                        ),
                    ),
                ),


            )
        ) );
    }



    /**
     * redirect post
     *
     * @return void
     */
    public function block_template_frontend()
    {
        if ( is_singular( $this->type ) && ! current_user_can( 'edit_posts' ) ) {
            wp_redirect( site_url(), 301 );
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
        if(!self::$templates){

            $query = new \WP_Query([
                'post_type' => self::get_post_type(),
                'post_status' => [ 'publish' ],
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
        if($post->post_type == $this->type){
            $query = new \WP_Query([
                'post_type'         => [ $this->type ],
                'post_status'       => ['publish'],
                'posts_per_page'    => -1,
                'fields'            => 'ids'
            ]);

            $templates        = [];

            if($query->have_posts()){
                while($query->have_posts()){
                    $query->the_post();

                    $type           = get_post_meta(get_the_ID(), 'template_type', true);
                    $display_on     = get_post_meta(get_the_ID(), 'display_on', true);
                    $not_display_on = get_post_meta(get_the_ID(), 'not_display_on', true);
                    $user_rule      = get_post_meta(get_the_ID(), 'user_rule', true);

                    $templates[] = [
                        'id'                => get_the_ID(),
                        'type'              => $type,
                        'display_on'        => $display_on,
                        'not_display_on'    => $not_display_on,
                        'user_rule'         => $user_rule,
                    ];

                }
            }


            update_option('kk_templates', $templates);
        }

    }
}
