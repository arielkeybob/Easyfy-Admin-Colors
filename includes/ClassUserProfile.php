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
        add_action('wp_login', array($this, 'check_apply_custom_scheme'), 10, 2);
    }

    /**
     * Adiciona campos personalizados à página de perfil do usuário.
     *
     * @param WP_User $user O objeto do usuário sendo editado.
     */
    public function add_custom_user_profile_fields($user) {
        $apply_scheme = get_user_meta($user->ID, 'apply_custom_scheme', true);
        if ($apply_scheme === '') {  // Verifica se a meta ainda não foi definida.
            update_user_meta($user->ID, 'apply_custom_scheme', 1); // Define o padrão como 1 se não existir.
            $apply_scheme = 1;
        }
        ?>
        <h3><?php esc_html_e("Personalized Admin Color Settings", "easyfy-admin-colors"); ?></h3>
        <table class="form-table">
            <tr>
                <th>
                    <label for="apply_custom_scheme"><?php esc_html_e("Apply Custom Color Scheme?", "easyfy-admin-colors"); ?></label>
                </th>
                <td>
                    <input type="checkbox" id="apply_custom_scheme" name="apply_custom_scheme" value="1" <?php checked($apply_scheme, 1); ?>>
                    <span class="description"><?php esc_html_e("Enable or disable the custom color scheme for your admin panel.", "easyfy-admin-colors"); ?></span>
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

        $apply_scheme = isset($_POST['apply_custom_scheme']) ? 1 : 0;
        update_user_meta($user_id, 'apply_custom_scheme', $apply_scheme);
    }

    /**
     * Verifica a preferência do usuário sobre aplicar ou não o esquema de cores durante o login.
     *
     * @param string $user_login Nome de usuário do usuário que está logando.
     * @param WP_User $user Objeto do usuário que está logando.
     */
    public function check_apply_custom_scheme($user_login, $user) {
        if (get_user_meta($user->ID, 'apply_custom_scheme', true) === '') {
            update_user_meta($user->ID, 'apply_custom_scheme', 1); // Define o padrão como 1 se não existir.
        }
    }
}
