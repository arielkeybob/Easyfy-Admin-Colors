<?php

class ClassAdminSettings {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_settings_page() {
        add_menu_page(
            'Easyfy Admin Colors Settings',
            'Easyfy Colors',
            'manage_options',
            'easyfy-admin-colors',
            array($this, 'render_settings_page'),
            'dashicons-art',
            99
        );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Easyfy Admin Colors Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('easyfy_admin_colors_options');
                do_settings_sections('easyfy-admin-colors');
                submit_button('Save Changes');
                ?>
            </form>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.color-picker').wpColorPicker();
            });
        </script>
        <?php
    }

    public function register_settings() {
        error_log('Registering settings...');
        register_setting('easyfy_admin_colors_options', 'easyfy_admin_colors_settings', array($this, 'validate_inputs'));

        add_settings_section(
            'easyfy_admin_colors_section',
            'Color Settings',
            null,
            'easyfy-admin-colors'
        );

        $colors = get_custom_admin_colors();

        if (is_array($colors)) {
            foreach ($colors as $color_name => $default_value) {
                add_settings_field(
                    $color_name,
                    ucwords(str_replace('_', ' ', $color_name)),
                    array($this, 'color_picker_callback'),
                    'easyfy-admin-colors',
                    'easyfy_admin_colors_section',
                    array(
                        'id' => 'easyfy_admin_colors_settings[' . $color_name . ']',
                        'default' => $default_value
                    )
                );
            }
        } else {
            // Log error or notify admin
            error_log('Expected an array from get_custom_admin_colors(), got: ' . gettype($colors));
        }
    }

    public function color_picker_callback($args) {
        $options = get_option('easyfy_admin_colors_settings');
        $color = isset($options[$args['id']]) ? $options[$args['id']] : $args['default'];
        echo '<input type="text" id="' . esc_attr($args['id']) . '" name="' . esc_attr($args['id']) . '" value="' . esc_attr($color) . '" class="color-picker" data-default-color="' . esc_attr($args['default']) . '" />';
    }

    public function validate_inputs($inputs) {
        if (is_array($inputs)) {
            foreach ($inputs as $key => $value) {
                $inputs[$key] = sanitize_hex_color($value);
            }
        }
        // Adicionando log para depuração
        error_log('Salvando as seguintes cores: ' . print_r($inputs, true));
        return $inputs;
    }
}

function get_custom_admin_colors() {
    // Valores padrão
    $defaults = [
        'menu_text' => '#ffffff',
        'base_menu' => '#333333',
        'highlight' => '#0073aa',
        'notification' => '#d54e21',
        'background' => '#f1f1f1',
        'links' => '#0073aa',
        'buttons' => '#0073aa',
        'form_inputs' => '#ffffff'
    ];
    // Busca as configurações atuais e usa os padrões se nada estiver salvo
    $settings = get_option('easyfy_admin_colors_settings', $defaults);
    return $settings;
}



add_action('admin_notices', function() {
    $options = get_option('easyfy_admin_colors_settings');
    echo '<pre>';
    print_r($options);
    echo '</pre>';
});
