<?php
/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-17
 * @website     : https://karmatechhub.com
 */
defined('ABSPATH') or exit();


if(!function_exists('karma_kit')){
    /**
     * @return \Karma\Kit\Loader
     */
    function karma_kit(){
        global $karma_kit;
        return $karma_kit;
    }
}


if(!function_exists('karma_get_current_templates')){

    function karma_get_current_templates($type = 'header', $result_type = 'ids')
    {
        $templates = get_option('karma_kit_templates');

        $result = [];

        if($templates){
            foreach($templates as $template) {
                if($template['type'] == $type){
                    $not_display_on     = parse_template_display_condition($template['id'], $template['not_display_on']);
                    $display_on         = parse_template_display_condition($template['id'], $template['display_on']);
                    $display_on_user    = parse_template_display_user_condition($template['user_rule']);

                    if($result_type == 'select'){
                        $result[] = [
                            'label' => $template['title'],
                            'value' => absint($template['id']),
                        ];
                    }
                    if(!$not_display_on && $display_on && $display_on_user){

                        if($result_type == 'ids'){
                            $result[] = absint($template['id']);
                        }

                    }
                }
            }
        }

        return $result;
    }
}

if(!function_exists('parse_template_display_condition')){
    function parse_template_display_condition( $post_id , $rules, $include = true )
    {
        $display    = !$include;

        if(is_singular('karma-kit-template')){
            return false;
        }

        if(is_array($rules) && !empty($rules)) {
            foreach($rules as $key => $rule) {
                if(strrpos($rule, 'all') !== false) {
                    $rule_case = 'all';
                }
                else {
                    $rule_case = $rule;
                }

                switch($rule_case) {
                    case 'basic-global':
                        $display = $include;
                        break;

                    case 'basic-singulars':
                        if(is_singular()) {
                            $display = $include;
                        }
                        break;

                    case 'basic-archives':
                        if(is_archive()) {
                            $display = $include;
                        }
                        break;

                    case 'special-404':
                        if(is_404()) {
                            $display = $include;
                        }
                        break;

                    case 'special-search':
                        if(is_search()) {
                            $display = $include;
                        }
                        break;

                    case 'special-blog':
                        if(is_home()) {
                            $display = $include;
                        }
                        break;

                    case 'special-front':
                        if(is_front_page()) {
                            $display = $include;
                        }
                        break;

                    case 'special-date':
                        if(is_date()) {
                            $display = $include;
                        }
                        break;

                    case 'special-author':
                        if(is_author()) {
                            $display = $include;
                        }
                        break;

                    case 'special-woo-shop':
                        if(function_exists('is_shop') && is_shop()) {
                            $display = $include;
                        }
                        break;

                    case 'all':
                        $rule_data = explode('|', $rule);

                        $post_type     = isset($rule_data[ 0 ]) ? $rule_data[ 0 ] : false;
                        $archive_type   = isset($rule_data[ 2 ]) ? $rule_data[ 2 ] : false;
                        $taxonomy      = isset($rule_data[ 3 ]) ? $rule_data[ 3 ] : false;
                        if(false === $archive_type) {
                            $current_post_type = get_post_type($post_id);

                            if(false !== $post_id && $current_post_type == $post_type) {
                                $display = $include;
                            }
                        }
                        else {
                            if(is_archive()) {
                                $current_post_type = get_post_type();
                                if($current_post_type == $post_type) {
                                    if('archive' == $archive_type) {
                                        $display = $include;
                                    }
                                    elseif('taxarchive' == $archive_type) {
                                        $obj              = get_queried_object();
                                        $current_taxonomy = '';
                                        if('' !== $obj && null !== $obj) {
                                            $current_taxonomy = $obj->taxonomy;
                                        }

                                        if($current_taxonomy == $taxonomy) {
                                            $display = $include;
                                        }
                                    }
                                }
                            }
                        }
                        break;


                    default:
                        break;
                }

                if($display) {
                    break;
                }
            }
        }

        return $display;
    }
}



if(!function_exists('parse_template_display_user_condition')){
    function parse_template_display_user_condition( $rules )
    {
        $display    = false;

        if(is_array($rules) && !empty($rules)) {
            foreach($rules as  $rule) {

                switch($rule) {
                    case '':
                    case 'all':
                        $display = true;
                        break;

                    case 'logged-in':
                        if(is_user_logged_in()) {
                            $display = true;
                        }
                        break;
                    case 'logged-out':
                        if(!is_user_logged_in()) {
                            var_dump($rule);
                            $display = true;
                        }
                        break;
                    default:
                        if ( is_user_logged_in() ) {
                            $current_user = wp_get_current_user();

                            if ( isset( $current_user->roles )
                                && is_array( $current_user->roles )
                                && in_array( $rule, $current_user->roles )
                            ) {
                                $display = true;
                            }
                        }
                        break;
                }

                if($display) {
                    break;
                }
            }
        }else{
            return true;
        }

        return $display;
    }
}

function convert_array_select_options($array){
    return array_map(function($value, $key) {
        return [
            'label' => $value,
            'value' => $key,
        ];
    }, $array, array_keys($array));
}
