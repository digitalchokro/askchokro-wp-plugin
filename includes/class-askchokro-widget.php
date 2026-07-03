<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class AskChokro_Widget {

    public function __construct() {
        add_shortcode( 'askchokro', array( $this, 'render_shortcode' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    public function render_shortcode( $atts ) {
        // Only render for logged in users if auth is strictly required?
        // Let's render the div, React will handle the logic.
        return '<div id="askchokro-root"></div>';
    }

    public function enqueue_scripts() {
        $asset_file = ASKCHOKRO_PLUGIN_DIR . 'build/index.asset.php';
        
        if ( ! file_exists( $asset_file ) ) {
            return; // Not built yet
        }

        $assets = require $asset_file;
        
        wp_enqueue_script(
            'askchokro-react-app',
            ASKCHOKRO_PLUGIN_URL . 'build/index.js',
            $assets['dependencies'],
            $assets['version'],
            true
        );

        wp_enqueue_style(
            'askchokro-react-style',
            ASKCHOKRO_PLUGIN_URL . 'build/index.css',
            array(),
            $assets['version']
        );

        // Pass settings and JWT token to React
        $options = get_option( 'askchokro_options' );
        $url = isset( $options['microservice_url'] ) ? $options['microservice_url'] : 'http://localhost:3000';
        $token = AskChokro_Auth::generate_token();

        wp_localize_script( 'askchokro-react-app', 'askChokroSettings', array(
            'apiUrl' => trailingslashit( $url ) . 'api/ask',
            'token'  => $token ? $token : null,
            'nonce'  => wp_create_nonce( 'wp_rest' )
        ) );
    }
}
