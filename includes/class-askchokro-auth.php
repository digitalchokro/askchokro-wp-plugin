<?php
use \Firebase\JWT\JWT;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class AskChokro_Auth {

    /**
     * Generate a short-lived JWT for the current logged-in user.
     * Returns false if user is not logged in or JWT secret is missing.
     */
    public static function generate_token() {
        if ( ! is_user_logged_in() ) {
            return false;
        }

        $options = get_option( 'askchokro_options' );
        $secret = isset( $options['jwt_secret'] ) ? $options['jwt_secret'] : '';

        if ( empty( $secret ) ) {
            return false;
        }

        $user = wp_get_current_user();
        
        // Add roles and any other WP specific context you want AskChokro to know about.
        $payload = array(
            'iss'       => get_site_url(),
            'iat'       => time(),
            'exp'       => time() + 3600, // 1 hour expiration
            'wp_user_id'=> $user->ID,
            'wp_roles'  => $user->roles,
            'wp_email'  => $user->user_email
        );

        try {
            return JWT::encode( $payload, $secret, 'HS256' );
        } catch ( Exception $e ) {
            return false;
        }
    }
}
