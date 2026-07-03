<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class AskChokro_Settings {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    public function add_plugin_page() {
        add_options_page(
            'AskChokro Settings',
            'AskChokro',
            'manage_options',
            'askchokro-settings',
            array( $this, 'create_admin_page' )
        );
    }

    public function create_admin_page() {
        ?>
        <div class="wrap">
            <h1>AskChokro Integration Settings</h1>
            <p>Connect your WordPress site to your AskChokro Microservice.</p>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'askchokro_option_group' );
                do_settings_sections( 'askchokro-setting-admin' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function page_init() {
        register_setting(
            'askchokro_option_group',
            'askchokro_options',
            array( $this, 'sanitize' )
        );

        add_settings_section(
            'setting_section_id',
            'Microservice Configuration',
            array( $this, 'print_section_info' ),
            'askchokro-setting-admin'
        );

        add_settings_field(
            'microservice_url',
            'Microservice URL',
            array( $this, 'microservice_url_callback' ),
            'askchokro-setting-admin',
            'setting_section_id'
        );

        add_settings_field(
            'jwt_secret',
            'JWT Secret',
            array( $this, 'jwt_secret_callback' ),
            'askchokro-setting-admin',
            'setting_section_id'
        );
    }

    public function sanitize( $input ) {
        $sanitary_values = array();
        if ( isset( $input['microservice_url'] ) ) {
            $sanitary_values['microservice_url'] = esc_url_raw( $input['microservice_url'] );
        }
        if ( isset( $input['jwt_secret'] ) ) {
            $sanitary_values['jwt_secret'] = sanitize_text_field( $input['jwt_secret'] );
        }
        return $sanitary_values;
    }

    public function print_section_info() {
        print 'Enter the connection details for your AskChokro Docker instance below:';
    }

    public function microservice_url_callback() {
        $options = get_option( 'askchokro_options' );
        $val = isset( $options['microservice_url'] ) ? esc_attr( $options['microservice_url'] ) : 'http://localhost:3000';
        printf(
            '<input type="url" id="microservice_url" name="askchokro_options[microservice_url]" value="%s" style="width: 400px;" />',
            $val
        );
        print '<p class="description">The base URL of your AskChokro microservice (e.g. http://localhost:3000).</p>';
    }

    public function jwt_secret_callback() {
        $options = get_option( 'askchokro_options' );
        $val = isset( $options['jwt_secret'] ) ? esc_attr( $options['jwt_secret'] ) : '';
        printf(
            '<input type="password" id="jwt_secret" name="askchokro_options[jwt_secret]" value="%s" style="width: 400px;" />',
            $val
        );
        print '<p class="description">Must match the JWT_SECRET environment variable in your AskChokro Docker container.</p>';
    }
}
