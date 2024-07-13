<?php
function custom_admin_color_scheme_activate() {
    $users = get_users();
    foreach ($users as $user) {
        if (false === get_user_meta($user->ID, 'custom_admin_color_scheme_toggle', true)) {
            update_user_meta($user->ID, 'custom_admin_color_scheme_toggle', 'on');
        }
    }
}
register_activation_hook(__FILE__, 'custom_admin_color_scheme_activate');

function custom_admin_color_scheme_login($user_login, $user) {
    if ('' === get_user_meta($user->ID, 'custom_admin_color_scheme_toggle', true)) {
        update_user_meta($user->ID, 'custom_admin_color_scheme_toggle', 'on');
    }
}
add_action('wp_login', 'custom_admin_color_scheme_login', 10, 2);
