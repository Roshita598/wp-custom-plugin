<?php
/*
Plugin Name: Hello Startup Plugin
Description: A custom WordPress plugin with admin notice and settings page.
Version: 1.1
Author: Roshita Verma
*/

if (!defined('ABSPATH')) {
    exit;
}

/* -----------------------------
   Admin Menu
------------------------------*/
add_action('admin_menu', 'hello_startup_menu');

function hello_startup_menu() {
    add_menu_page(
        'Hello Startup Settings',
        'Hello Startup',
        'manage_options',
        'hello-startup',
        'hello_startup_settings_page',
        'dashicons-smiley',
        80
    );
}

/* -----------------------------
   Settings Page UI
------------------------------*/
function hello_startup_settings_page() {
    ?>
    <div class="wrap">
        <h1>Hello Startup Plugin Settings</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('hello_startup_group');
                do_settings_sections('hello-startup');
                submit_button();
            ?>
        </form>
    </div>
    <?php
}

/* -----------------------------
   Register Settings
------------------------------*/
add_action('admin_init', 'hello_startup_settings');

function hello_startup_settings() {
    register_setting('hello_startup_group', 'hello_startup_message');

    add_settings_section(
        'hello_startup_section',
        'Custom Admin Notice',
        null,
        'hello-startup'
    );

    add_settings_field(
        'hello_startup_message',
        'Admin Notice Message',
        'hello_startup_message_field',
        'hello-startup',
        'hello_startup_section'
    );
}

function hello_startup_message_field() {
    $message = get_option(
        'hello_startup_message',
        'Hello! Your custom WordPress plugin is active 🚀'
    );

    echo '<input type="text" name="hello_startup_message" value="' .
         esc_attr($message) .
         '" style="width:400px;" />';
}

/* -----------------------------
   Admin Notice
------------------------------*/
add_action('admin_notices', 'hello_startup_notice');

function hello_startup_notice() {
    $message = get_option(
        'hello_startup_message',
        'Hello! Your custom WordPress plugin is active 🚀'
    );

    echo '<div class="notice notice-success is-dismissible">
            <p>' . esc_html($message) . '</p>
          </div>';
}
/* -----------------------------
   Shortcode Feature
------------------------------*/
add_shortcode('hello_startup', 'hello_startup_shortcode');

function hello_startup_shortcode() {
    $message = get_option(
        'hello_startup_message',
        'Hello! Your custom WordPress plugin is active 🚀'
    );

    return '<div class="hello-startup-shortcode">' .
            esc_html($message) .
           '</div>';
}