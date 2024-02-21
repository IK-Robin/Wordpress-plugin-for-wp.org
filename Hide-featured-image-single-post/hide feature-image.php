<?php
/**
 * Plugin Name: Hide Featured Image Checkbox
 * Description: A plugin to add a checkbox under the featured image select option to hide or show the feature image on single post pages.
 * Version: 1.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 */

// Check if the plugin is activated
register_activation_hook( __FILE__, 'ikr_hide_featured_image_checkbox_activate' );
function ikr_hide_featured_image_checkbox_activate() {
    // Nothing to do here
}





// Add a meta box to the post editor
add_action( 'add_meta_boxes', 'ikr_hide_featured_image_checkbox_meta_box' );
function ikr_hide_featured_image_checkbox_meta_box() {
    add_meta_box( 'IKR_hide-featured-image-checkbox', __( 'Hide Featured Image', 'IKR_hide-featured-image-checkbox' ), 'ikr_hide_featured_image_checkbox_meta_box_callback', 'post', 'normal', 'high' );
}


// Display the meta box content
function ikr_hide_featured_image_checkbox_meta_box_callback( $post ) {
    // Retrieve the current value of the 'hide_featured_image' meta field
    $ikr_hide_featured_image = get_post_meta( $post->ID, 'hide_featured_image', true );

    // Display the checkbox
    echo '<label for="ikr_hide_and_show_checkbox">';
    echo '<input type="checkbox" id="ikr_hide_and_show_checkbox" name="hide_featured_image" value="1" ' . checked( 1, $ikr_hide_featured_image, false ) . ' />';
    echo __( 'Hide Featured Image', 'ikr_hide_and_show_checkbox' );
    echo '</label>';
   
}


// Save the meta field value
add_action( 'save_post', 'ikr_hide_featured_image_checkbox_save_meta_box' );
function ikr_hide_featured_image_checkbox_save_meta_box( $post_id ) {
    // Check if the current user has permission to edit the post
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Retrieve the submitted value of the 'hide_featured_image' meta field
    $ikr_hide_featured_image = isset( $_POST['hide_featured_image'] ) ? 1 : 0;

    // Update the 'hide_featured_image' meta field
    update_post_meta( $post_id, 'hide_featured_image', $ikr_hide_featured_image );
}

// Add a filter to the post thumbnail HTML
add_filter( 'post_thumbnail_html', 'hide_featured_image_checkbox_html', 10, 3);
function hide_featured_image_checkbox_html( $html, $post_id, $post_image_id ) {
    // Check if the current page is a single post page
    if ( is_single() ) {
        // Retrieve the value of the 'hide_featured_image' meta field
        $ikr_hide_featured_image = get_post_meta( $post_id, 'hide_featured_image', true );

        // Check if the 'hide_featured_image' meta field is set to 1
        if ( $ikr_hide_featured_image ) {
            // Return an empty string to hide the featured image
            return '';
        }
    }

    // Return the original HTML to display the featured image on other pages
    return $html;
}

// add the plugin to hide the post thumbnil 