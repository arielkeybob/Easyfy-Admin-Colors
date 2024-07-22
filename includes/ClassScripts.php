<?php

/**
 * Classe responsável por gerenciar scripts e estilos do plugin Easyfy Admin Colors.
 */
class ClassScripts {
    /**
     * Construtor que pode ser usado para inicializar configurações ou ações relacionadas a scripts e estilos.
     */
    public function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_styles_and_scripts'));
    }

    /**
     * Enfileira os estilos e scripts necessários para o painel administrativo,
     * incluindo a lógica para aplicar ou não as configurações de cor com base nas preferências do usuário.
     */
    public function enqueue_styles_and_scripts() {
        wp_enqueue_style('easyfy-admin-colors-css', plugin_dir_url(__FILE__) . '../admin/admin.css', array(), '1.0', 'all');
    
        // Verifica se o esquema de cores personalizado deve ser aplicado
        $user_id = get_current_user_id();
        $apply_scheme = get_user_meta($user_id, 'apply_custom_scheme', true);
        
        if ($apply_scheme) {
            wp_enqueue_script('easyfy-live-preview', plugin_dir_url(__FILE__) . '../js/live-preview.js', array('jquery', 'wp-color-picker'), null, true);
            $colors = get_option('easyfy_admin_colors_settings');
            if (is_array($colors)) {
                wp_localize_script('easyfy-live-preview', 'easyfy_admin_colors_settings', $colors);
            } else {
                // Se não for um array, passa um array vazio ou valores padrão
                wp_localize_script('easyfy-live-preview', 'easyfy_admin_colors_settings', array());
            }
        }
    }
    
}
