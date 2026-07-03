<?php
/**
 * Plugin Name: AskChokro
 * Description: Zero-code AI integration for WordPress using the AskChokro Microservice.
 * Version: 1.0.0
 * Author: Digital Chokro
 * License: MIT
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Autoload composer dependencies
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

define( 'ASKCHOKRO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ASKCHOKRO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Load includes
require_once ASKCHOKRO_PLUGIN_DIR . 'includes/class-askchokro-settings.php';
require_once ASKCHOKRO_PLUGIN_DIR . 'includes/class-askchokro-auth.php';
require_once ASKCHOKRO_PLUGIN_DIR . 'includes/class-askchokro-widget.php';

// Initialize the plugin
function askchokro_init() {
    new AskChokro_Settings();
    new AskChokro_Widget();
}
add_action( 'plugins_loaded', 'askchokro_init' );
