<?php
function get_custom_admin_colors() {
    return get_option('custom_admin_colors', get_custom_admin_colors_defaults());
}

function get_custom_admin_colors_defaults() {
    return [
        'menu_text' => '#ffffff',
        'base_menu' => '#333333',
        'highlight' => '#0073aa',
        'notification' => '#d54e21',
        'background' => '#f1f1f1',
        'links' => '#0073aa',
        'buttons' => '#0073aa',
        'form_inputs' => '#ffffff'
    ];
}

function custom_admin_color_scheme_menu() {
    add_menu_page('Custom Admin Colors', 'Admin Colors', 'manage_options', 'custom-admin-colors', 'custom_admin_color_scheme_settings_page', 'dashicons-admin-customizer');
}
add_action('admin_menu', 'custom_admin_color_scheme_menu');

function custom_admin_color_scheme_settings_page() {
    if (isset($_POST['submit'])) {
        check_admin_referer('custom_admin_colors_save', 'custom_admin_colors_nonce');
        update_option('custom_admin_colors', [
            'menu_text' => sanitize_hex_color($_POST['menu_text']),
            'base_menu' => sanitize_hex_color($_POST['base_menu']),
            'highlight' => sanitize_hex_color($_POST['highlight']),
            'notification' => sanitize_hex_color($_POST['notification']),
            'background' => sanitize_hex_color($_POST['background']),
            'links' => sanitize_hex_color($_POST['links']),
            'buttons' => sanitize_hex_color($_POST['buttons']),
            'form_inputs' => sanitize_hex_color($_POST['form_inputs'])
        ]);
    } elseif (isset($_POST['reset'])) {
        check_admin_referer('custom_admin_colors_save', 'custom_admin_colors_nonce');
        update_option('custom_admin_colors', get_custom_admin_colors_defaults());
    }

    $colors = get_custom_admin_colors();
    ?>
    <div class="wrap">
        <h2>Custom Admin Colors Settings</h2>
        <form method="post" action="">
            <?php settings_fields('custom_admin_colors'); ?>
            <?php wp_nonce_field('custom_admin_colors_save', 'custom_admin_colors_nonce'); ?>
            <table id="custom-admin-colors-settings-table" class="form-table custom-admin-colors">
                <?php foreach ($colors as $key => $value): ?>
                    <tr>
                        <td><input type="text" name="<?php echo $key; ?>" value="<?php echo esc_attr($value); ?>" class="color-picker" /></td>
                        <th scope="row"><?php echo ucwords(str_replace('_', ' ', $key)); ?></th>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php submit_button(); ?>
            <input type="submit" name="reset" class="button button-secondary" value="Reset to Defaults">
        </form>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('.color-picker').wpColorPicker();
        });
    </script>
    <?php
}
