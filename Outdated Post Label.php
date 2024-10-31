<?php
/*
 * Plugin Name:       Outdated Post Label
 * Plugin URI:        https://saudrazzak.com/plugins/outdated-post-label/
 * Description:       Adds a label to indicate if a post is outdated or updated.
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Saud Razzak
 * Author URI:        https://saudrazzak.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       outdated-post-label
 * Domain Path:       /languages
 */

function outdated_post_label() {
    global $post;
    $post_date = strtotime( $post->post_date );
    $post_modified = strtotime( $post->post_modified );
    $six_months_ago = strtotime( '-6 months' );
    if ( $post_date <= $six_months_ago ) {
        echo '<span style="color:red;font-weight:bold;">Outdated</span>';
    } elseif ( $post_modified > $post_date ) {
        echo '<span style="color:green;font-weight:bold;">Updated</span>';
    }
}
add_action( 'admin_enqueue_scripts', 'outdated_post_label' );

function add_outdated_post_label_column( $columns ) {
    $columns['outdated_post'] = 'Outdated Post';
    return $columns;
}
add_filter( 'manage_post_posts_columns', 'add_outdated_post_label_column' );

function display_outdated_post_label( $column_name, $post_id ) {
    if ( $column_name == 'outdated_post' ) {
        global $post;
        $post_date = strtotime( get_the_date( 'Y-m-d', $post_id ) );
        $post_modified = strtotime( $post->post_modified );
        $six_months_ago = strtotime( '-6 months' );
        if ( $post_date <= $six_months_ago ) {
            echo '<span style="color:red;font-weight:bold;">Outdated</span>';
        } elseif ( $post_modified > $post_date ) {
            echo '<span style="color:green;font-weight:bold;">Updated</span>';
        }
    }
}
add_action( 'manage_post_posts_custom_column', 'display_outdated_post_label', 10, 2 );
