<?php
function custom_admin_color_scheme_user_profile($user) {
    // Verifica e define o valor padrão para o toggle se não existir
    if (false === get_user_meta($user->ID, 'custom_admin_color_scheme_toggle', true)) {
        update_user_meta($user->ID, 'custom_admin_color_scheme_toggle', 'on');
    }
    $toggle_value = get_user_meta($user->ID, 'custom_admin_color_scheme_toggle', true);
    ?>
    <h3>Personalize Admin Colors</h3>
    <table class="form-table">
        <tr>
            <td>
                <input type="checkbox" name="custom_admin_color_scheme_toggle" id="custom_admin_color_scheme_toggle" <?php checked($toggle_value, 'on'); ?> />
            </td>
            <th><label for="custom_admin_color_scheme_toggle">Enable Custom Colors</label></th>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'custom_admin_color_scheme_user_profile');
add_action('edit_user_profile', 'custom_admin_color_scheme_user_profile');

function custom_admin_color_scheme_save_user_profile($user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    update_user_meta($user_id, 'custom_admin_color_scheme_toggle', isset($_POST['custom_admin_color_scheme_toggle']) ? 'on' : 'off');
}
add_action('personal_options_update', 'custom_admin_color_scheme_save_user_profile');
add_action('edit_user_profile_update', 'custom_admin_color_scheme_save_user_profile');
