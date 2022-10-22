<?php
/**
 * @project     : KarmaKit
 * @version     : 1.0.0
 * @author      : Karma Team
 * @date        : 2022-10-18
 * @website     : https://karmatechhub.com
 *
 * @var $post
 * @var $template \Karma\Kit\PostType\Template
 */
defined('ABSPATH') or exit();

$values            = get_post_custom( $post->ID );
$template_type     = isset( $values['ekm_template_type'] ) ? esc_attr( $values['ekm_template_type'][0] ) : '';


wp_nonce_field( 'ekm_meta_nounce', 'ekm_meta_nounce' );
?>


<style>
    div#karma-kit-meta-box .inside {
        padding: 0;
        margin: 0;
    }

    div#karma-kit-meta-box td {
        padding-left: 12px;
        padding-right: 12px;
        border-bottom: 1px solid #f0f0f0;
        zoom: 1;
        vertical-align: middle;
    }

    div#karma-kit-meta-box .km-options-row-content {
        padding: 15px 10px;
        position: relative;
        width: 55%;
    }

    table.km-options-table {
        width: 100%;
    }

    div#karma-kit-meta-box select {
        width: 94%;
    }
</style>


<table class="km-options-table">
    <tbody>
    <tr class="km-options-row type-of-template">
        <td class="km-options-row-heading">
            <label for="ekm_template_type"><?php _e( 'Type of Template', 'karmakit' ); ?></label>
        </td>
        <td class="km-options-row-content">
            <select name="ekm_template_type" id="ekm_template_type">
                <option value="" <?php selected( $template_type, '' ); ?>><?php _e( 'Select Option', 'karmakit' ); ?></option>
                <option value="type_header" <?php selected( $template_type, 'type_header' ); ?>><?php _e( 'Header', 'karmakit' ); ?></option>
                <option value="type_before_footer" <?php selected( $template_type, 'type_before_footer' ); ?>><?php _e( 'Before Footer', 'karmakit' ); ?></option>
                <option value="type_footer" <?php selected( $template_type, 'type_footer' ); ?>><?php _e( 'Footer', 'karmakit' ); ?></option>
            </select>
        </td>
    </tr>
    </tbody>
</table>
