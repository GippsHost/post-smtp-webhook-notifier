<?php
/*
Plugin Name: Post SMTP Webhook Notifier
Description: Sends a webhook to a Google Chat space when an email fails to send via Post SMTP.
Version: 1.0
Author: GippsHost
Author URI: https://www.gippshost.com.au
*/

function postman_mail_failed($wp_error) {
    // Get the webhook URL from the settings
    $webhook_url = get_option('post_smtp_webhook_url');

    // Get the site URL
    $site_url = get_site_url();
    
    // Prepare the message
    $error_message = $wp_error->get_error_message();
    $message = array(
        'text' => 'An email failed to send on `' . $site_url . '`. Error details: ' . $error_message
    );

    // JSON encode the message
    $json_message = json_encode($message);

    // Log the JSON message
    error_log('Postman SMTP webhook payload: ' . $json_message);

    // Send the webhook
    $response = wp_remote_post($webhook_url, array(
        'method'    => 'POST',
        'body'      => $json_message,
        'headers'   => array(
            'Content-Type' => 'application/json'
        )
    ));

    // Check for errors in the response
    if (is_wp_error($response)) {
        error_log('Failed to send webhook: ' . $response->get_error_message());
    } else {
        error_log('Webhook sent successfully. Response: ' . print_r($response, true));
    }
}
add_action('wp_mail_failed', 'postman_mail_failed');

// Add an admin menu item and page
function post_smtp_webhook_notifier_menu() {
    add_options_page(
        'Post SMTP Webhook Notifier Settings',
        'Post SMTP Webhook Notifier',
        'manage_options',
        'post-smtp-webhook-notifier',
        'post_smtp_webhook_notifier_settings_page'
    );
}
add_action('admin_menu', 'post_smtp_webhook_notifier_menu');

// Display the settings page with the test button
function post_smtp_webhook_notifier_settings_page() {
    ?>
    <div class="wrap">
        <h1>Post SMTP Webhook Notifier</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('post_smtp_webhook_notifier_options_group');
            do_settings_sections('post_smtp_webhook_notifier');
            submit_button();
            ?>
        </form>
        <h2>Test Webhook</h2>
        <form method="post" action="">
            <input type="hidden" name="test_webhook" value="1">
            <?php submit_button('Send Test Webhook'); ?>
        </form>
    </div>
    <?php
}

// Register and define the settings
function post_smtp_webhook_notifier_register_settings() {
    register_setting('post_smtp_webhook_notifier_options_group', 'post_smtp_webhook_url');
    add_settings_section('post_smtp_webhook_notifier_section', 'Webhook Settings', null, 'post_smtp_webhook_notifier');
    add_settings_field('post_smtp_webhook_url', 'Webhook URL', 'post_smtp_webhook_notifier_webhook_url_callback', 'post_smtp_webhook_notifier', 'post_smtp_webhook_notifier_section');
}
add_action('admin_init', 'post_smtp_webhook_notifier_register_settings');

function post_smtp_webhook_notifier_webhook_url_callback() {
    $webhook_url = get_option('post_smtp_webhook_url');
    echo '<input type="text" name="post_smtp_webhook_url" value="' . esc_attr($webhook_url) . '" size="50">';
}

// Handle the test webhook button click
function post_smtp_webhook_notifier_handle_test() {
    if (isset($_POST['test_webhook']) && $_POST['test_webhook'] == '1') {
        $error_message = 'This is a test error message';
        $wp_error = new WP_Error('test_error', $error_message);
        postman_mail_failed($wp_error);
        add_action('admin_notices', 'post_smtp_webhook_notifier_admin_notice');
    }
}
add_action('admin_init', 'post_smtp_webhook_notifier_handle_test');

// Display a success notice after sending the test webhook
function post_smtp_webhook_notifier_admin_notice() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e('Test webhook sent successfully.', 'post-smtp-webhook-notifier'); ?></p>
    </div>
    <?php
}

// Additional logging to verify hook is added
error_log('wp_mail_failed action added.');
?>
