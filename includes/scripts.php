<?php
function custom_admin_color_scheme_scripts() {
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'custom_admin_color_scheme_scripts');

function custom_admin_color_scheme_settings_scripts($hook) {
    if ($hook != 'toplevel_page_custom-admin-colors') {
        return;
    }
    wp_enqueue_style('custom-admin-colors-settings', plugins_url('../custom-admin-colors.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'custom_admin_color_scheme_settings_scripts');

// Verifique se esta função está incluída no arquivo certo e está sendo chamada
function custom_admin_color_scheme_apply() {
    $toggle_value = get_user_meta(get_current_user_id(), 'custom_admin_color_scheme_toggle', true);
    if ($toggle_value !== 'off') {
        $colors = get_custom_admin_colors(); // Esta função deve estar acessível

        $css = "
            #adminmenu a { color: {$colors['menu_text']} !important; }
            #adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap { background-color: {$colors['base_menu']} !important; }
            #adminmenu li:hover > a, #adminmenu .wp-has-current-submenu > a { background-color: {$colors['highlight']} !important; }
            #adminmenu .awaiting-mod, #adminmenu .update-plugins { background-color: {$colors['notification']} !important; color: #ffffff !important; }
            .wp-core-ui .wp-ui-notification { background-color: {$colors['notification']} !important; color: #ffffff !important; }
            #wpcontent, #wpfooter { background-color: {$colors['background']} !important; }
            #wpbody-content a, #wpbody a { color: {$colors['links']} !important; }
            .wp-core-ui .button, .wp-core-ui .button-primary { background-color: {$colors['buttons']}; border-color: {$colors['buttons']}; }
            input[type='text'], input[type='search'], textarea { background-color: {$colors['form_inputs']} !important; }
        ";

        wp_register_style('custom-admin-colors-style', false);
        wp_enqueue_style('custom-admin-colors-style');
        wp_add_inline_style('custom-admin-colors-style', $css);
    }
}
add_action('admin_enqueue_scripts', 'custom_admin_color_scheme_apply');
