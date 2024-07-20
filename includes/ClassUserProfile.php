<?php

/**
 * Classe responsável por adicionar e gerenciar campos personalizados no perfil do usuário no painel administrativo do WordPress.
 */
class ClassUserProfile {
    /**
     * Construtor que adiciona os hooks necessários para manipular os campos do perfil do usuário.
     */
    public function __construct() {
        add_action('show_user_profile', array($this, 'add_custom_user_profile_fields'));
        add_action('edit_user_profile', array($this, 'add_custom_user_profile_fields'));

        add_action('personal_options_update', array($this, 'save_custom_user_profile_fields'));
        add_action('edit_user_profile_update', array($this, 'save_custom_user_profile_fields'));
    }

    /**
     * Adiciona campos personalizados à página de perfil do usuário.
     *
     * @param WP_User $user O objeto do usuário sendo editado.
     */
    public function add_custom_user_profile_fields($user) {
        ?>
        <h3><?php esc_html_e("Personalized Admin Color Settings", "easyfy-admin-colors"); ?></h3>
        <table class="form-table">
            <tr>
                <th>
                    <label for="admin_color_scheme"><?php esc_html_e("Admin Color Scheme", "easyfy-admin-colors"); ?></label>
                </th>
                <td>
                    <input type="text" id="admin_color_scheme" name="admin_color_scheme" value="<?php echo esc_attr(get_user_meta($user->ID, 'admin_color_scheme', true)); ?>" class="regular-text" />
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Salva os campos personalizados quando o perfil do usuário é atualizado.
     *
     * @param int $user_id O ID do usuário cujo perfil está sendo atualizado.
     */
    public function save_custom_user_profile_fields($user_id) {
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }

        update_user_meta($user_id, 'admin_color_scheme', sanitize_text_field($_POST['admin_color_scheme']));
    }
}
